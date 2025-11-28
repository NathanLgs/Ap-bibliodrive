<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style>
    /* Laisser chaque slide adopter la taille de son image */
    #myCarousel .item {
      text-align: center;
    }

    #myCarousel .item img {
      width: auto;          /* garde les proportions */
      max-width: 100%;      /* ne dépasse pas la largeur du conteneur */
      height: auto;         /* laisse l'image définir la hauteur */
      display: inline-block;
    }
  </style>
</head>
<body>

<div class="container"> 
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <div class="carousel-inner">
      <div class="item active">
        <img src="Bartleby_le_Scribe.jpg" alt="Los Angeles" style="width: 500px;">
      </div>

      <div class="item">
        <img src="1984.jpg" alt="Chicago" style="width: 500px;">
      </div>
    
      <div class="item">
        <img src="Anna_Karenine.jpg" alt="New york" style="width: 500px;">
      </div>
    </div>

    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

</body>
</html>
