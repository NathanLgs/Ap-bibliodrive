<?php
session_start();

?>
<!-- NATHAN LE GALLAIS SIO1 RABELAIS 2025/2026 PROJET : BIBLIODRIVE -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIBLIODRIVE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <?php
require_once('connexion.php');
$stmt = $connexion->prepare("SELECT * FROM livre ORDER BY dateajout DESC LIMIT 3");
$stmt->setFetchMode(PDO::FETCH_OBJ);
$stmt->execute();
$livres = $stmt->fetchAll();
?>

<div class="container">
  <h3 class="text-center couleur1">DERNIER AJOUTS BIBLIODRIVE :</h3>
</div>

<div id="demo" class="carousel slide carousel-fade carousel carousel-dark slide" data-bs-ride="carousel">
  <div class="carousel-indicators ">
    <?php for ($i = 0; $i < count($livres); $i++): ?><!--Récupére les données-->
      <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></button>
    <?php endfor; ?>
  </div>

  <!-- affiche l'image-->
  <div class="carousel-inner">
    <?php foreach ($livres as $id => $livre): ?> <!--parcour le tableau-->
      <div class="carousel-item <?= $id == 0 ? 'active' : '' ?>">
        <div class="d-flex justify-content-center">
          <img src="./images/<?= $livre->photo ?>" alt="<?= $livre->titre ?>" class="d-block" style="width:50%">
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <button class="carousel-control-prev custom-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next custom-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>
            </div>

            <div class="col-sm-3">
                <?php include 'formulaire.php'; ?>
            </div>
        </div>

    </div>

</body>
</html>
