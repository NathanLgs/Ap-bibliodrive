<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="style.css" rel="stylesheet">
</head>

<body class="text-light bg-blur">

<?php require_once('connexion.php'); ?>
<br><br>

<div class="container-fluid">


    <div class="row">
        <div class="col-sm-9">
            <?php include 'recherche.php'; ?>
        </div>

        <div class="col-sm-3 text-end">
            <img src="hautdroite.png" alt="image" style="opacity: 0.75;">
        </div>
    </div>


    <div class="row mt-3">

    
        <div class="col-sm-9">

        <?php
        $auteur = isset($_GET['nmbr']) ? "%" . $_GET['nmbr'] . "%" : "%";

        $stmt = $connexion->prepare("
            SELECT nolivre, titre, anneeparution, auteur.nom, photo
            FROM livre
            INNER JOIN auteur ON auteur.noauteur = livre.noauteur
            WHERE auteur.nom LIKE :auteur
        ");

        $stmt->bindValue(":auteur", $auteur);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $stmt->execute();

        while ($enregistrement = $stmt->fetch()) {
            $nolivre = htmlspecialchars($enregistrement->nolivre);
            $titre = htmlspecialchars($enregistrement->titre);
            $annee = htmlspecialchars($enregistrement->anneeparution);

            echo "<p>
                    <a class='text-light' href='detail.php?numero=$nolivre'>
                        $titre - $annee
                    </a>
                  </p>";
        }
        ?>

        </div>

        
        <div class="col-sm-3">
            <?php include 'formulaire.php'; ?>
        </div>

    </div>

</div>

</body>
</html>
