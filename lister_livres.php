<?php 
require_once('connexion.php'); // Connexion à la base de données
?>

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

    <div class="container-fluid">
        
        <div class="row">
            <div class="col-sm-9">
                <?php include 'recherche.php'; ?>
            </div>

            <div  class="col-sm-3 text-end">
                <img src="hautdroite.png" alt="image" style="opacity: 0.75">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-9">
                <div class="container mt-4">

    <?php
    /* Récupération du nom d'auteur depuis l'URL pour filtrer les livres*/
    /* Exemple : lister_livres.php?nmbr=Hugo */
    $auteur = isset($_GET['nmbr']) ? "%" . $_GET['nmbr'] . "%" : "%";

    // Préparation de la requête SQL pour récupérer les livres et leur auteur
    $stmt = $connexion->prepare("
        SELECT livre.nolivre, titre, anneeparution, auteur.nom, photo
        FROM livre
        INNER JOIN auteur ON auteur.noauteur = livre.noauteur
        WHERE auteur.nom LIKE :auteur
    ");
    $stmt->bindValue(":auteur", $auteur); // Liaison sécurisée du paramètre
    $stmt->execute(); // Exécution de la requête
    $stmt->setFetchMode(PDO::FETCH_OBJ); // On récupère les résultats sous forme d'objet

    $found = false; // Indicateur pour savoir si des livres sont trouvés

    // Début de la grille Bootstrap (responsive)
    echo "<div class='row row-cols-1 row-cols-md-3 g-4'>";

    // Boucle pour afficher tous les livres récupérés
    while ($enregistrement = $stmt->fetch()) {
        $found = true; // Au moins un livre est trouvé
        $nolivre = $enregistrement->nolivre;
        $titre = $enregistrement->titre;
        $annee = $enregistrement->anneeparution;
        $photo = $enregistrement->photo;

        echo "<div class='col'>"; // Colonne Bootstrap pour chaque livre
        echo "  <div class='card text-light p-4 shadow' style='max-width: 400px; width: 100%; background: rgba(33, 37, 41, 0.75); backdrop-filter: blur(4px); border: none; border-radius: 12px''>"; // Carte Bootstrap sombre
        if (!empty($photo)) {
            // Si une image existe, on l'affiche
            echo "<img src='images/$photo' class='card-img-top' alt='$titre'>";
        } else {
            // Sinon, on affiche un bloc gris "Pas d'image"
            echo "<div class='card-img-top d-flex align-items-center justify-content-center' style='height:200px; background:#444;'>Pas d'image</div>";
        }
        echo "    <div class='card-body'>";
        echo "      <h5 class='card-title'>$titre</h5>"; // Titre du livre
        echo "      <p class='card-text'>Année : $annee</p>"; // Année de parution
        echo "      <a href='detail.php?nolivre=$nolivre' class='btn btn-primary'>Voir le détail</a>"; // Bouton vers la page de détail
        echo "    </div>";
        echo "  </div>";
        echo "</div>";
    }

    echo "</div>"; // Fin de la grille Bootstrap

    // Message si aucun livre n'est trouvé pour cet auteur
    if (!$found) {
        echo "<p class='text-warning mt-3'>Aucun livre trouvé pour cet auteur.</p>";
    }
    ?>
</div>
            </div>

            <div class="col-sm-3">
                <?php include 'formulaire.php'; ?>
            </div>
        </div>

    </div>

</body>

</html>
