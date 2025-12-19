<?php
session_start();
require_once('connexion.php');

// Vérifier si l'utilisateur est connecté
if (empty($_SESSION['connecte'])) {
    header("Location: acceuil.php");
    exit;
}

$mel = $_SESSION['connecte'];

// Initialiser le panier si nécessaire
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

$message = '';

// ----- AJOUT AU PANIER avec limite 5 livres ----- //
if (isset($_GET['ajouter'])) {
    $nolivre = intval($_GET['ajouter']);
    if (!in_array($nolivre, $_SESSION['panier'])) {
        if (count($_SESSION['panier']) >= 5) {
            $message = "Vous ne pouvez pas ajouter plus de 5 livres dans le panier.";
        } else {
            $_SESSION['panier'][] = $nolivre;
        }
    }
    header("Location: panier.php?msg=" . urlencode($message));
    exit;
}

// ----- SUPPRIMER DU PANIER ----- //
if (isset($_GET['supprimer'])) {
    $nolivre = intval($_GET['supprimer']);
    $_SESSION['panier'] = array_diff($_SESSION['panier'], [$nolivre]);
    header("Location: panier.php");
    exit;
}

// ----- VALIDER LE PANIER ----- //
if (isset($_GET['valider'])) {
    // Compter les emprunts déjà en cours
    $sql = "SELECT COUNT(*) FROM emprunter WHERE mel = :mel AND dateretour IS NULL";
    $stmt = $connexion->prepare($sql);
    $stmt->bindValue(":mel", $mel);
    $stmt->execute();
    $empruntsEnCours = $stmt->fetchColumn();

    $nbPanier = count($_SESSION['panier']);

    if ($empruntsEnCours + $nbPanier > 5) {
        $message = "Vous ne pouvez pas emprunter plus de 5 livres à la fois. En cours : $empruntsEnCours, dans le panier : $nbPanier.";
    } else {
        // Préparer l'insertion dans la table emprunter
        $sqlInsert = "INSERT INTO emprunter (mel, nolivre, dateemprunt, dateretour) VALUES (:mel, :nolivre, NOW(), NULL)";
        $stmtInsert = $connexion->prepare($sqlInsert);

        foreach ($_SESSION['panier'] as $nolivre) {
            // Vérifier si le livre n'est pas déjà emprunté et non rendu
            $stmtCheck = $connexion->prepare(
                "SELECT COUNT(*) FROM emprunter WHERE mel = :mel AND nolivre = :nolivre AND dateretour IS NULL"
            );
            $stmtCheck->bindValue(":mel", $mel);
            $stmtCheck->bindValue(":nolivre", $nolivre);
            $stmtCheck->execute();

            if ($stmtCheck->fetchColumn() == 0) {
                $stmtInsert->bindValue(":mel", $mel);
                $stmtInsert->bindValue(":nolivre", $nolivre);
                $stmtInsert->execute();
            }
        }

        // Vider le panier
        $_SESSION['panier'] = [];
        $message = "Panier validé avec succès. Bon emprunt !";
    }
}


// Récupérer message depuis GET si redirection
if (isset($_GET['msg'])) {
    $message = $_GET['msg'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier - BiblioDrive</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link href="style.css" rel="stylesheet">
</head>
<body class="text-light bg-blur">

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <?php include 'entete.php'; ?>
        </div>
        <div  class="col-sm-3 text-end">
            <img src="./images/bibliodriveimage2.png" alt="image" style="opacity: 0.75;">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-9">
        <h2 class="mb-4">Votre panier</h2>

                <?php if ($message): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <?php if (empty($_SESSION['panier'])): ?>
                    <p>Votre panier est vide.</p>
                    <a href="lister_livres.php" class="btn btn-primary">Retour au catalogue</a>
                <?php else: ?>
                    <table class="table table-dark table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Récupérer les informations des livres dans le panier
                        $nolivres = array_map('intval', $_SESSION['panier']);
                        if (count($nolivres) > 0) {
                            $sql = "
                                SELECT livre.titre, auteur.nom, auteur.prenom, livre.nolivre
                                FROM livre
                                INNER JOIN auteur ON auteur.noauteur = livre.noauteur
                                WHERE livre.nolivre IN (" . implode(',', $nolivres) . ")
                            ";
                            $stmt = $connexion->query($sql);
                            while ($livre = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($livre->titre) . "</td>";
                                echo "<td>" . htmlspecialchars($livre->prenom . " " . $livre->nom) . "</td>";
                                echo "<td>";
                                echo "<a href='panier.php?supprimer={$livre->nolivre}' class='btn btn-danger btn-sm'>Annuler❌</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <a href="panier.php?valider=1" class="btn btn-success">Valider le panier</a>
                        <a href="lister_livres.php" class="btn btn-secondary">Continuer vos recherches</a>
                    </div>
                <?php endif; ?>
        </div>

        <div class="col-sm-3">
            <?php include 'formulaire.php'; ?>
        </div>
    </div>
</div>

</body>
</html>
