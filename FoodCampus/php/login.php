<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <title>Login</title>
         <metacharset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- Latest compiled and minified CSS -->
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
         <!-- jQuery library -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
         <!--Font awesome-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../css/navbar.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../css/login.css">
    </head>
    <body>
        <?php include 'navbar.php';?>
        <div class="container">
            <div class="jumbotron mx-auto" id="loginform">
			<h1>Login</h1>
            <br/><br/>
			<form action="/action_page.php">
				<div class="form-group">
					<label for="email">Indirizzo Email:</label>
					<input type="email" class="form-control" id="email" placeholder="Inserisci email" name="email">
				</div>
				<div class="form-group">
					<label for="pwd">Password:</label>
					<input type="password" class="form-control" id="pwd" placeholder="Inserisci password" name="pswd">
				</div>
                <a href="#">Password dimenticata?</a>
                <br/><br/>
				<div class="form-group form-check">
					<label class="form-check-label">
					<input class="form-check-input" type="checkbox" name="remember"> Ricordami
					</label>
				</div>
				<button type="submit" class="btn btn-primary btn-lg">Accedi</button>
			</form>
            <br/>
            <div class="d-flex justify-content-center">
                <a class="align-middle" href="iscrizione.php">Non hai un account? Clicca qui per iscriverti!</a>
            </div>
        </div>
    </div>
    </body>
</html>
