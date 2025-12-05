<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link href="style.css" rel="stylesheet">
</head>

<body class="text-light bg-blur">

    <div class="container-fluid">
        
        <div class="row">
            <div class="col-sm-9">
                <?php include 'recherche.php'; ?>
            </div>

            <div  class="col-sm-3 text-end">
                <img src="hautdroite.png" alt="image" style="opacity: 0.75;">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-9">
                <?php include 'carousel.php'; ?>
            </div>

            <div class="col-sm-3">
                <?php include 'formulaire.php'; ?>
            </div>
        </div>

    </div>

</body>
</html>
