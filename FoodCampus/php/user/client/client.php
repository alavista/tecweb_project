<?php
require_once "../../database.php";
require_once "../../utilities/direct_login.php";

if (!($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET["id"]) &&
            is_numeric($_GET["id"]) && ctype_digit($_GET["id"]) && $_GET["id"] >= 0 &&
            isUserLogged($conn) && (((!empty($_SESSION["user_type"]) && $_SESSION["user_type"] == "Cliente") ||
                    (isset($_COOKIE["user_type"]) && $_COOKIE["user_type"] == "Cliente")) &&
                    ((!empty($_SESSION["user_id"]) && $_SESSION["user_id"] == $_GET["id"]) ||
                    (isset($_COOKIE["user_id"]) && $_COOKIE["user_id"] == $_GET["id"]))))) {
        redirectToPageNotFound($conn);
    }
?>
<!DOCTYPE html>
<html lang="it-IT">
    <head>
        <title>FOOD CAMPUS</title>
         <meta charset="UTF-8">
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
         <?php require_once '../../navbar/filesForNotify.html'; ?>
         <!--JavaScript-->
         <script src="../commonParts/js/userFunctions.js" type="text/javascript"></script>
         <script src="../commonParts/js/name.js" type="text/javascript"></script>
         <script src="../commonParts/js/password.js" type="text/javascript"></script>
         <script src="../commonParts/js/image.js" type="text/javascript"></script>
         <script src="../commonParts/js/email.js" type="text/javascript"></script>
         <script src="surname.js" type="text/javascript"></script>
         <script src="../../../js/utilities/sha512.js" type="text/javascript"></script>
         <!--Font awesome-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
         <!--CSS-->
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../navbar/navbar.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../../css/utilities.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../commonParts/css/user.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="client.css">
         <link rel="stylesheet" type="text/css" title="stylesheet" href="../../footer/footer.css">
    </head>
    <body>
        <div class="container">
            <?php
            require_once '../../navbar/navbar.php';
            $_SESSION["page"] = "http://localhost/tecweb_project/FoodCampus/php/home/home.php";
            $query = "SELECT * FROM cliente WHERE IDCliente = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("s", $_GET["id"]);
                if ($stmt->execute()) {
                    $res = $stmt->get_result();
                    if ($res->num_rows == 1) {
                        $client = $res->fetch_assoc();
                        ?>
                        <div class="text-center clientImageStartAfterNavbar" id="userImage">
                            <img id="image" src="../../../res/clients/<?php echo $client["immagine"] != NULL ? $client["immagine"] : 'default.png';?>" class="img-fluid rounded-circle" alt="Logo cliente">
                        </div>
                        <div id="userImage" class="text-center">
                            <button type='button' class='btn btn-secondary changePlus' id='changeImage'>Modifica immagine</button>
                        </div>
                        <form id="newUserImage" class="text-center">
                            <div class="form-group">
                                <label class="notVisible" for="newImage">Immagine del profilo</label>
                                <input type="file" id="newImage" class="form-control-file" accept="image/*">
                            </div>
                            <div class="form-group">
                                <button type='button' id="saveImage" class='btn btn-success change'>Salva</button>
                                <button type='button' id="cancelChangeImage" class='btn btn-danger change cancelImageButton'>Annulla</button>
                            </div>
                        </form>
                        <div class="jumbotron">
                            <span class="text-center"><h2>Informazioni</h2></span>
                            <div id="userName">
                                <span class="font-weight-bold">Cognome e nome:</span>
                                <span id="surname"><?php echo ucfirst($client['cognome']);?></span>
                                <span id="name"><?php echo ucfirst($client['nome']);?></span><br/>
                                <div class="row">
                                    <div class="col-lg-4"><button type="button" class="btn btn-secondary changePlus aaa" id="changeSurname">Modifica cognome</button></div>
                                    <div class="col-lg-4"><button type="button" class="btn btn-secondary changePlus aaa" id="changeName">Modifica nome</button></div>
                                    <div class="col-lg-4"><button type='button' class='btn btn-secondary changePlus aaa' id='changePassword'>Modifica password</button></div>
                                </div>
                            </div>
                            <form id="newUserName" class="text-center">
                                <div class="form-group">
                                    <label class="notVisible" for="newName">Nuovo nome</label>
                                    <input type="text" id="newName" class='form-control' placeholder="Nuovo nome"/>
                                </div>
                                <div class="form-group">
                                    <button type='button' id="saveName" class='btn btn-success change'>Salva</button>
                                    <button type='button' id="cancelChangeName" class='btn btn-danger change cancelButton'>Annulla</button>
                                </div>
                            </form>
                            <form id="newUserSurname" class="text-center">
                                <div class="form-group">
                                    <label class="notVisible" for="newName">Nuovo cognome</label>
                                    <input type="text" id="newSurname" class='form-control' placeholder="Nuovo cognome"/>
                                </div>
                                <div class="form-group">
                                    <button type='button' id="saveSurname" class='btn btn-success change'>Salva</button>
                                    <button type='button' id="cancelChangeSurname" class='btn btn-danger change cancelButton'>Annulla</button>
                                </div>
                            </form>
                            <form id="newUserPassword" class="text-center">
                                <div class="form-group">
                                    <label class="notVisible" for="oldPassword">Vecchia password</label>
                                    <input type="password" id="oldPassword" class='form-control' placeholder="Vecchia password"/>
                                </div>
                                <div class="form-group">
                                    <label class="notVisible" for="newPassword">Nuova password</label>
                                    <input type="password" id="newPassword" class='form-control' placeholder="Nuova password"/>
                                </div>
                                <div class="form-group">
                                    <label class="notVisible" for="oldPassword">Ripeti nuova password</label>
                                    <input type="password" id="repetNewPassword" class='form-control' placeholder="Ripeti nuova password"/>
                                </div>
                                <div class="form-group">
                                    <button type='button' id="savePassword" class='btn btn-success change'>Salva</button>
                                    <button type='button' id="cancelChangePassword" class='btn btn-danger change cancelButton'>Annulla</button>
                                </div>
                            </form>
                            <div id="userEmail">
                                <span class="font-weight-bold">Email:</span>
                                <span id="email"><?php echo $client["email"]; ?></span><br/>
                                <button type='button' class='btn btn-secondary changePlus' id='changeEmail'>Cambia email</button>
                            </div>
                            <form id="newUserEmail" class="text-center">
                                <div class="form-group">
                                    <label class="notVisible" for="newEmail">Nuova email</label>
                                    <input type="text" id="newEmail" class='form-control' placeholder="Nuova email"/>
                                </div>
                                <div class="form-group">
                                    <button type='button' id="saveEmail" class='btn btn-success change'>Salva</button>
                                    <button type='button' id="cancelChangeEmail" class='btn btn-danger change cancelButton'>Annulla</button>
                                </div>
                            </form>
                        </div>
                        <?php
                    }
                }
            }
        ?>
        </div>
        <?php require_once "../../footer/footer.html"; ?>
    </body>
</html>
