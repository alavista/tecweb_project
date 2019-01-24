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
         <!-- Notify -->
         <?php require_once '../navbar/filesForNotify.html'; ?>
         <!--Font awesome-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <!--JAVASCRIPT-->
          <script src="food.js" type="text/javascript"></script>
          <script src="../user/commonParts/js/userFunctions.js" type="text/javascript"></script>
         <!--CSS-->
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../navbar/navbar.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="home.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../footer/footer.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../css/utilities.css">

    </head>
    <body>
          <div class="container">
              <?php require_once '../navbar/navbar.php';?>
              <div class = "text-center <?php if ($supplier) { echo 'supplierStartAfterNavbar'; } else { echo 'clientStartAfterNavbar'; } ?>">
                  <h1>FOOD CAMPUS</h1>
              </div>
              <div id="foodCategories" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ul class="carousel-indicators">
                      <li data-target="#foodCategories" data-slide-to="0" class="active"></li>
                      <li data-target="#foodCategories" data-slide-to="1"></li>
                      <li data-target="#foodCategories" data-slide-to="2"></li>
                      <li data-target="#foodCategories" data-slide-to="3"></li>
                      <li data-target="#foodCategories" data-slide-to="4"></li>
                      <li data-target="#foodCategories" data-slide-to="5"></li>
                      <li data-target="#foodCategories" data-slide-to="6"></li>
                  </ul>
                  <!-- The slideshow -->
                  <div class="carousel-inner">
                      <div class="carousel-item active">
                          <div id="pizza"><img src="../../res/home/slideshow/pizza.jpg" alt="Pizza"></div>
                          <div class="carousel-caption">
                              <h3>Pizze</h3>
                          </div>
                      </div>
                      <div class="carousel-item">
                          <div id="sandwich"><img src="../../res/home/slideshow/sandwich.jpg" alt="Panini"></div>
                          <div class="carousel-caption">
                              <h3>Panini</h3>
                          </div>
                      </div>
                      <div class="carousel-item">
                          <div id="piada"><img src="../../res/home/slideshow/piada.jpg" alt="Piade"></div>
                          <div class="carousel-caption">
                              <h3>Piade</h3>
                          </div>
                      </div>
                      <div class="carousel-item">
                          <div id="sushi"><img src="../../res/home/slideshow/sushi.jpg" alt="Piade"></div>
                          <div class="carousel-caption">
                              <h3>Sushi</h3>
                          </div>
                      </div>
                      <div class="carousel-item">
                          <div id="firstDish"><img src="../../res/home/slideshow/firstDish.jpg" alt="Primi"></div>
                          <div class="carousel-caption">
                              <h3>Primi</h3>
                          </div>
                      </div>
                      <div class="carousel-item">
                          <div id="secondDish"><img src="../../res/home/slideshow/secondDish.jpg" alt="Secondi"></div>
                          <div class="carousel-caption">
                              <h3>Secondi</h3>
                          </div>
                      </div>
                      <div class="carousel-item">
                          <div id="sweet"><img src="../../res/home/slideshow/sweet.jpg" alt="Dolci"></div>
                          <div class="carousel-caption">
                              <h3>Dolci</h3>
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
                  <div class="validation" id="carouselError"></div>
              </div>
              <div class="text-center">
                  <h1>Chi siamo</h1>
                  <p>
                      Food Campus 
                  </p>
                  <h1>I nostri obiettivi</h1>
                  <p>
                      <b>Sei uno studente di Cesena?</b>
                      <br/>
                      Food Campus ti permette di ordinare il tuo piatto preferito che ti sar&agrave; consegnato direttamente al nuovo campus!
                      <br/>
                      Scegli il cibo che preferisci dai nostri fornitori, troverai una grande variet&agrave; di pietanze, inclusi cibi vegani e per celiaci.
                      <br/>
                      Dai un'occhiata ai nostri prodotti <a href="../products_research/products_research_index.php">qui</a>!
                      <br/>
                      Inoltre, potrai votare ogni fornitore e lasciare delle recensioni!
                      <br/>
                      Puoi vedere i nostri fornitori in base alle tue preferenze <a href="../suppliers_research/suppliers_research_index.php">qui</a>!
                      <br/>
                      <br/>
                       <b>Sei un fornitore? </b>
                      <br/>
                      Con Food Campus puoi vendere in modo efficace e veloce tutti i tuoi prodotti!
                      <br/>
                      Grazie al sistema di notifiche in tempo reale, sarai avvertito appena riceverai un ordine e ogni cliente sapr&agrave; quando l'ordine &egrave; in consegna!
                      <br/>
                      <br/>
                      Infine, ogni utente ha un profilo personale che pu&ograve; personalizzare come preferisce!
                      <br/>
                      Che aspetti? <a href="../subscription/php/subscription.php">Iscriviti ora!</a>
                  </p>
                  <h1>Come contattarci</h1>
                  <p>
                      Se hai dubbi o hai bisogno di ulteriori informazioni puoi contattarci al nostro indirizzo email: <span class="font-weight-bold">foodcampus.cesena@gmail.com</span>
                  </p>
              </div>
          </div>
          <?php
            if(isset($_GET['order_success'])) {
              require_once "order-success.html";
            }
            require_once "../cookie/cookie.php";
            require_once "../footer/footer.html";
          ?>
      </body>


</html>
