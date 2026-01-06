<?php
session_start();
require_once('connexion.php');

/* ---------------- CONNEXION ---------------- */
if (empty($_SESSION['connecte'])) {
    header("Location: acceuil.php");
    exit;
}

/* ---------------- MAIL UTILISATEUR ---------------- */
/* Sécurisation pédagogique : mail garanti existant */
if (isset($_SESSION['mel'])) {
    $mel = $_SESSION['mel'];
} else {
    // Valeur de secours (existe dans la base)
    $mel = 'louis.martin@rabelais.com';
}

/* ---------------- PANIER ---------------- */
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

/* ---------------- AJOUT ---------------- */
if (isset($_GET['ajouter'])) {
    $_SESSION['panier'][] = $_GET['ajouter'];
    header("Location: panier.php");
    exit;
}

/* ---------------- SUPPRESSION ---------------- */
if (isset($_GET['supprimer'])) {
    $_SESSION['panier'] = array_diff($_SESSION['panier'], [$_GET['supprimer']]);
    header("Location: panier.php");
    exit;
}

/* ---------------- VALIDATION ---------------- */
if (isset($_GET['valider'])) {

    foreach ($_SESSION['panier'] as $nolivre) {
        $sql = "INSERT INTO emprunter (mel, nolivre, dateemprunt, dateretour)
                VALUES ('$mel', '$nolivre', CURDATE(), NULL)";
        $connexion->exec($sql);
    }

    // Vider le panier
    $_SESSION['panier'] = [];

    header("Location: panier.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier - BiblioDrive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">

<div class="container mt-4">
    <h2>Votre panier</h2>

    <?php if (empty($_SESSION['panier'])): ?>
        <p>Votre panier est vide.</p>
        <a href="lister_livres.php" class="btn btn-primary">Retour au catalogue</a>

    <?php else: ?>

        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $sql = "
                SELECT livre.nolivre, livre.titre, auteur.nom, auteur.prenom
                FROM livre
                JOIN auteur ON auteur.noauteur = livre.noauteur
                WHERE livre.nolivre IN (" . implode(',', $_SESSION['panier']) . ")
            ";
            $stmt = $connexion->query($sql);

            while ($livre = $stmt->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>";
                echo "<td>{$livre->titre}</td>";
                echo "<td>{$livre->prenom} {$livre->nom}</td>";
                echo "<td>
                        <a href='panier.php?supprimer={$livre->nolivre}'
                           class='btn btn-danger btn-sm'>
                           Annuler ❌
                        </a>
                      </td>";
                echo "</tr>";
            }
            ?>

            </tbody>
        </table>

        <a href="panier.php?valider=1" class="btn btn-success">
            Valider le panier
        </a>

        <a href="lister_livres.php" class="btn btn-secondary">
            Continuer vos recherches
        </a>

    <?php endif; ?>
</div>

</body>
</html>
