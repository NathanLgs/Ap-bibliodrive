<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="style.css" rel="stylesheet">
</head>
<body class="text-light bg-blur">

<?php
require_once('connexion.php'); // Connexion à la base de données

// Vérification que le paramètre 'nolivre' est présent dans l'URL
if (!isset($_GET["nolivre"])) {
    die("Erreur : aucun livre spécifié.");
}

$nolivre = (int)$_GET["nolivre"]; // Sécurisation du paramètre (conversion en entier)

// Préparation de la requête pour récupérer toutes les informations du livre
$stmt = $connexion->prepare("
    SELECT nom, prenom, dateretour, detail, isbn13, anneeparution, photo, titre 
    FROM livre 
    INNER JOIN auteur ON livre.noauteur = auteur.noauteur 
    LEFT JOIN emprunter ON livre.nolivre = emprunter.nolivre 
    WHERE livre.nolivre = :nolivre
");

$stmt->bindValue(":nolivre", $nolivre, PDO::PARAM_INT); // Liaison sécurisée du paramètre
$stmt->execute();
$enregistrement = $stmt->fetch(PDO::FETCH_OBJ); // Récupération du résultat sous forme d'objet

// Vérification que le livre existe
if (!$enregistrement) {
    die("Livre introuvable.");
}
?>

<div class="row">
<div class="col-sm-8">

<!-- Affichage des informations du livre -->
<p>ISBN13 : <?= htmlspecialchars($enregistrement->isbn13) ?></p>
<p>Auteur : <?= htmlspecialchars($enregistrement->prenom . " " . $enregistrement->nom) ?></p>
<p>Titre : <?= htmlspecialchars($enregistrement->titre) ?> (<?= htmlspecialchars($enregistrement->anneeparution) ?>)</p>

<h4>Résumé du livre :</h4>
<p><?= nl2br(htmlspecialchars($enregistrement->detail)) ?></p>

</div>

<div class="col-sm-4">
    <!-- Affichage de la couverture du livre -->
    <img src="./images/<?= htmlspecialchars($enregistrement->photo) ?>" class="d-block w-100" alt="Image de couverture">
</div>
</div>
</body>
</html>
