<?php
// footer.php
?>
<footer class="bg-dark text-light mt-5 pt-4 pb-3">
    <div class="container-fluid">
        <div class="row">

            <!-- À propos -->
            <div class="col-md-4 mb-3">
                <h5 class="couleur1">BiblioDrive</h5>
                <p class="small">
                    Projet BTS SIO 2025/2026.<br>
                    Application de gestion et d’emprunt de livres en ligne.
                </p>
            </div>

            <!-- Liens utiles -->
            <div class="col-md-4 mb-3">
                <h5 class="couleur1">Liens utiles</h5>
                <ul class="list-unstyled">
                    <li><a href="acceuil.php" class="text-light text-decoration-none">Accueil</a></li>
                    <li><a href="lister_livres.php" class="text-light text-decoration-none">Catalogue</a></li>
                </ul>
            </div>

            <!-- Crédits -->
            <div class="col-md-4 mb-3">
                <h5 class="couleur1">Crédits</h5>
                <p class="small">
                    Réalisé par Nathan Le Gallais<br>
                    BTS SIO – Rabelais<br>
                    Ressources :
                    <a href="https://www.w3schools.com/" class="text-light">W3Schools</a>,
                    <a href="https://getbootstrap.com/" class="text-light">Bootstrap</a>
                </p>
            </div>

        </div>

        <hr class="border-secondary">

        
        <div class="text-center small">
            <?= date('Y'); ?> BiblioDrive
        </div>
    </div>
</footer>
