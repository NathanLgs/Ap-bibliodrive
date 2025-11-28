<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta-name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <?php include 'recherche.php';?>
            </div>
             <div class="col-sm-3 text-end">
        <img src="1200x680_biblio-alex.jpg" alt="hautdroite" class="img-fluid">
    </div>
</div>
        <div class="row">
            <div class="col-sm-9">
                <?php include 'carousel.php' ?>
            </div>
            <div class="col-sm-3">
                formulaire de connexion / profil connecté (include)
            </div>
        </div>
    </div>
</body>
</html>
