<nav class="navbar navbar-expand-lg navbar-dark px-4 navbar-custom">
  <a class="navbar-brand" href="acceuil.php">BiblioDrive 📕</a>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarContent">

    <?php
        $auteur = isset($_GET['nmbr']) ? $_GET['nmbr'] : '';
    ?>

    <form action="lister_livres.php" method="get" class="d-flex flex-grow-1 mx-3" role="search">
      <input 
        class="form-control form-control-lg me-2" 
        type="search" 
        name="nmbr"
        id="nmbr"
        placeholder="Rechercher dans le catalogue (nom de l'auteur)" 
        aria-label="Recherche"
        value="<?=  $auteur ?>"
      >

      <button class="btn btn-primary btn-lg" type="submit">Recherche🔍</button>
    </form>

    <!-- Bouton Panier -->
    <?php if (!empty($_SESSION['connecte'])): ?>
      <a href="panier.php" class="btn btn-danger btn-lg ms-3">
        Panier 🛒
        <?php 
          $nbPanier = isset($_SESSION['panier']) ? count($_SESSION['panier']) : 0;
          if ($nbPanier > 0) echo " ($nbPanier)";
        ?>
      </a>
    <?php endif; ?>

  </div>
</nav>
