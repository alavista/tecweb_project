<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <title>FOOD CAMPUS</title>
         <metacharset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- Latest compiled and minified CSS -->
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
         <!-- jQuery library -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
         <!-- Popper JS -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
         <!-- Latest compiled JavaScript -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
         <!--Font awesome-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../css/navbar.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../css/home.css">
    </head>
    <body>
          <div class="container-fluid">
              <?php require_once 'navbar.php';?>
              <div class = "text-center" id = "siteTitle">
                  <h1>FOOD CAMPUS</h1>
              </div>
              <div id="foodCategories" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ul class="carousel-indicators">
                  <li data-target="#foodCategories" data-slide-to="0" class="active"></li>
                  <li data-target="#foodCategories" data-slide-to="1"></li>
                  <li data-target="#foodCategories" data-slide-to="2"></li>
                  <li data-target="#foodCategories" data-slide-to="3"></li>
              </ul>
              <!-- The slideshow -->
              <div class="carousel-inner">
                  <div class="carousel-item active">
                      <a href="#"><img src="../res/home/slideshow/pizza.jpg" alt="Pizza"></a>
                      <div class="carousel-caption">
                          <h3>Pizze</h3>
                      </div>
                  </div>
                  <div class="carousel-item">
                      <a href="#"><img src="../res/home/slideshow/panino.jpg" alt="Panini"></a>
                      <div class="carousel-caption">
                          <h3>Panini</h3>
                      </div>
                  </div>
                  <div class="carousel-item">
                      <a href="#"><img src="../res/home/slideshow/primo.jpg" alt="Primi"></a>
                      <div class="carousel-caption">
                          <h3>Primi</h3>
                      </div>
                  </div>
                  <div class="carousel-item">
                      <a href="#"><img src="../res/home/slideshow/secondo.jpg" alt="Secondi"></a>
                      <div class="carousel-caption">
                          <h3>Secondi</h3>
                      </div>
                  </div>
                  <!-- Left and right controls -->
                  <a class="carousel-control-prev" href="#foodCategories" data-slide="prev">
                      <span class="carousel-control-prev-icon"></span>
                  </a>
                  <a class="carousel-control-next" href="#foodCategories" data-slide="next">
                      <span class="carousel-control-next-icon"></span>
                  </a>
              </div>
          </div>
      </body>
</html>
