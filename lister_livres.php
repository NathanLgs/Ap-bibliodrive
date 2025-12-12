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
session_start(); // Démarre la session pour le panier ou la connexion
require_once('connexion.php'); // Connexion à la base de données
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <?php include 'recherche.php'; // Formulaire de recherche ?>
        </div>

        <div class="col-sm-3 text-end">
            <img src="hautdroite.png" alt="image" style="opacity: 0.75;">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-9">

        <?php
        // Récupération du nom d'auteur depuis GET pour filtrer les livres
        $auteur = isset($_GET['nmbr']) ? "%" . htmlspecialchars($_GET['nmbr']) . "%" : "%";

        // Préparation de la requête pour récupérer les livres de l'auteur
        $stmt = $connexion->prepare("
            SELECT livre.nolivre, titre, anneeparution, auteur.nom, photo
            FROM livre
            INNER JOIN auteur ON auteur.noauteur = livre.noauteur
            WHERE auteur.nom LIKE :auteur
        ");
        $stmt->bindValue(":auteur", $auteur); // Liaison sécurisée du paramètre
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_OBJ);

        $found = false; // Indicateur si des livres sont trouvés

        // Boucle pour afficher tous les livres correspondant
        while ($enregistrement = $stmt->fetch()) {
            $found = true;
            $nolivre = htmlspecialchars($enregistrement->nolivre);
            $titre = htmlspecialchars($enregistrement->titre);
            $annee = htmlspecialchars($enregistrement->anneeparution);

            // Lien vers la page détail du livre
            echo "<p>
                    <a class='text-light' href='detail.php?nolivre=$nolivre'>
                        $titre - $annee
                    </a>
                  </p>";
        }

        // Message si aucun livre n'a été trouvé
        if (!$found) {
            echo "<p class='text-warning'>Aucun livre trouvé pour cet auteur.</p>";
        }
        ?>

        </div>

        <div class="col-sm-3">
            <?php include 'formulaire.php'; // Formulaire complémentaire ?>
        </div>
    </div>
</div>

</body>
</html>
