<?php
session_start();
?>
<!-- NATHAN LE GALLAIS SIO1 RABELAIS 2025/2026 PROJET : BIBLIODRIVE -->

<!DOCTYPE html>
<html lang="fr">
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

            <div class="col-sm-3 text-end">
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
                    <div class="carousel-indicators">
                        <?php for ($i = 0; $i < count($livres); $i++): ?>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>"></button>
                        <?php endfor; ?>
                    </div>

                    <div class="carousel-inner">
                        <?php foreach ($livres as $id => $livre): ?>
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

                <!-- Zone explicative sous le formulaire -->
                <div class="card p-3 mt-3 text-dark bg-light shadow-sm">
                    <h5>Informations</h5>
                    <p>
                        Bienvenue sur <strong>BiblioDrive</strong> !<br>
                        Connectez-vous pour ajouter des livres à votre panier et les emprunter. 
                        credit : Projet de BTS sio a l'aide du cours , 'https://www.w3schools.com/' et de 'https://getbootstrap.com/'
                        nathan LE GALLAIS bts sio 2025/2026
                        RABELAIS
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
