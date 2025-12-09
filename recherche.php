<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark px-4 navbar-custom">
  <a class="navbar-brand" href="#">BiblioDrive</a>

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
        value="<?= htmlspecialchars($auteur) ?>"
      >

      <button class="btn btn-primary btn-lg" type="submit">Recherche</button>
    </form>

  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
