<?php
session_start();
require_once('connexion.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANIER</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link href="style.css" rel="stylesheet">
</head>

<body class="text-light bg-blur">

    <div class="container-fluid">
        
        <div class="row">
            <div class="col-sm-9">
                <?php include 'header.php'; ?>
            </div>

            <div  class="col-sm-3 text-end">
                <img src="./images/bibliodriveimage2.png" alt="image" style="opacity: 0.75;">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-9">
            <?php
/*  CONNEXION  */
if (empty($_SESSION['connecte'])) {
    header("Location: acceuil.php");
    exit;
}

/*  MAIL UTILISATEUR   */
$mel = $_SESSION['mel'] ?? 'louis.martin@rabelais.com';

/*   PANIER   */
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

/*   AJOUT   */
if (isset($_GET['ajouter'])) {
    $_SESSION['panier'][] = $_GET['ajouter'];
    header("Location: panier.php");
    exit;
}

/*   SUPPRESSION   */
if (isset($_GET['supprimer'])) {
    $_SESSION['panier'] = array_diff($_SESSION['panier'], [$_GET['supprimer']]);
    header("Location: panier.php");
    exit;
}

/*   VALIDATION   */
if (isset($_GET['valider'])) {
    foreach ($_SESSION['panier'] as $nolivre) {
        // Vérifier si le livre est déjà emprunté
        $res = $connexion->query("SELECT COUNT(*) FROM emprunter WHERE nolivre = $nolivre AND dateretour IS NULL");
        $count = $res->fetchColumn();

        if ($count == 0) {
            // Livre disponible
            $connexion->exec("
                INSERT INTO emprunter (mel, nolivre, dateemprunt, dateretour)
                VALUES ('$mel', $nolivre, CURDATE(), NULL)
            ");
        }
        // Sinon, ne rien faire
    }

    $_SESSION['panier'] = [];
    header("Location: panier.php");
    exit;
}
?>
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
                // Vérifier si déjà emprunté
                $res = $connexion->query("SELECT COUNT(*) FROM emprunter WHERE nolivre = $livre->nolivre AND dateretour IS NULL");
                $dejaEmprunte = $res->fetchColumn() > 0;

                echo "<tr>";
                echo "<td>{$livre->titre}</td>";
                echo "<td>{$livre->prenom} {$livre->nom}</td>";
                if ($dejaEmprunte) {
                    echo "<td>Déjà emprunté ❌</td>";
                } else {
                    echo "<td>
                            <a href='panier.php?supprimer={$livre->nolivre}' class='btn btn-danger btn-sm'>
                               Annuler ❌
                            </a>
                          </td>";
                }
                echo "</tr>";
            }
            ?>

            </tbody>
        </table>

        <!-- Bouton pour ouvrir le modal de confirmation -->
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal">
            Valider le panier
        </button>

        <a href="lister_livres.php" class="btn btn-secondary">
            Continuer vos recherches
        </a>

        <!-- Modal de confirmation -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmer la validation</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir valider votre panier ?<br>
                        Les livres déjà empruntés seront ignorés.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <a href="panier.php?valider=1" class="btn btn-success">Confirmer</a>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

    </div>

<?php include 'footer.php'; ?>

</body>

</html>
