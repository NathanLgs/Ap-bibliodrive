<!-- NATHAN LE GALLAIS SIO1 RABELAIS 2025/2026 PROJET : BIBLIODRIVE -->
<?php
session_start();
require_once('connexion.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des livres</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

<?php
/* Filtre auteur */
$auteur = isset($_GET['nmbr']) ? "%" . $_GET['nmbr'] . "%" : "%";

/* Requête complète pour la modal */
$sql = "
    SELECT 
        livre.nolivre,
        livre.titre,
        livre.anneeparution,
        livre.isbn13,
        livre.detail,
        livre.photo,
        auteur.nom,
        auteur.prenom
    FROM livre
    INNER JOIN auteur ON auteur.noauteur = livre.noauteur
    WHERE auteur.nom LIKE :auteur
";

$stmt = $connexion->prepare($sql);
$stmt->bindValue(":auteur", $auteur);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_OBJ);

echo "<div class='row row-cols-1 row-cols-md-3 g-4'>";

while ($livre = $stmt->fetch()) {

    echo "<div class='col'>";
    echo "<div class='card text-light p-4 shadow' style='max-width: 400px; width: 100%; background: rgba(33, 37, 41, 0.75); backdrop-filter: blur(4px); border: none; border-radius: 12px''>";

    /* Image */
    if (!empty($livre->photo)) {
        echo "<img src='images/" . $livre->photo . "' class='card-img-top'>";
    } else {
        echo "<div class='card-img-top text-center p-5 bg-secondary'>Pas d'image</div>";
    }

    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . $livre->titre . "</h5>";
    echo "<p class='card-text'>Année : {$livre->anneeparution}</p>";

    /* Bouton modal bootstrap5 */
    echo "
        <button class='btn btn-primary mb-2'
                data-bs-toggle='modal'
                data-bs-target='#modal{$livre->nolivre}'>
            Voir le détail
        </button>
    ";

    /* Bouton Panier (visible seulement si connecté) */
    if (!empty($_SESSION['connecte'])) {
        echo "
            <form method='post' action='panier.php'>
                <input type='hidden' name='nolivre' value='{$livre->nolivre}'>
                <button type='submit' name='btnAjouterPanier' class='btn btn-success w-100'>
                    Ajouter au panier
                </button>
            </form>
        ";
    }

    echo "</div></div></div>";
    ?>

    <div class="modal fade"
         id="modal<?= $livre->nolivre ?>"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content bg-dark text-light">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <?= $livre->titre ?>
                    </h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-8">
                            <p><strong>Auteur :</strong>
                                <?= $livre->prenom . " " . $livre->nom ?>
                            </p>

                            <p><strong>Année :</strong> <?= $livre->anneeparution ?></p>
                            <p><strong>ISBN :</strong> <?= $livre->isbn13 ?></p>

                            <h6>Résumé :</h6>
                            <p><?= $livre->detail ?></p>
                        </div>

                        <div class="col-md-4">
                            <?php if (!empty($livre->photo)) : ?>
                                <img src="images/<?= $livre->photo ?>"
                                     class="img-fluid rounded">
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

<?php
}
echo "</div>";
?>
</div>
    <div class="col-sm-3">
        <?php include 'formulaire.php'; ?>
    </div>
</div>

</div>
</body>
</html>
