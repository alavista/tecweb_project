<?php
$idSupplier = $_GET['id'];
$query = "SELECT * FROM fornitore WHERE IDFornitore = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $idSupplier);
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res->num_rows == 1) {
            $supplier = $res->fetch_assoc();
            ?>
            <div class="text-center supplierStartAfterNavbar" id="userName">
                <h1>
                    <span id="name"><?php echo strtoupper($supplier['nome']);?></span>
                    <?php
                    $supplierPage = false;
                    if ((isset($_COOKIE["user_email"]) && ($_COOKIE["user_email"] == $supplier["email"])) ||
                            ((!empty($_SESSION["user_type"])) && (!empty($_SESSION["user_id"])) &&
                            ($_SESSION["user_type"] == "Fornitore") && ($_SESSION["user_id"] == $idSupplier))) {
                        $supplierPage = true;
                    }
                    ?>
                </h1>
                <?php
                if ($supplierPage) {
                    ?>
                    <div class="form-group row">
                        <div class="col-lg-3"><button type="button" class="btn btn-secondary changePlus" id="changeName">Modifica nome</button></div>
                        <div class="col-lg-3"><button type="button" class="btn btn-secondary changePlus" id="changeEmail">Modifica email</button></div>
                        <div class="col-lg-3"><button type='button' class='btn btn-secondary changePlus' id='changePassword'>Modifica password</button></div>
                        <div class="col-lg-3"><button type='button' class='btn btn-secondary changePlus' id='changeVatNumber'>Modifica partita iva</button></div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
            if ($supplierPage) {
                ?>
                <span id="email" class="notVisible"><?php echo $supplier["email"]; ?></span>
                <span id="vatNumber" class="notVisible"><?php echo $supplier["partita_iva"]; ?></span>
                <form id="newUserName" class="text-center supplierTextBoxStartAfterNavbar">
                    <div class="form-group">
                        <label class="notVisible" for="newName">Nuovo nome</label>
                        <input type="text" id="newName" class='form-control' placeholder="Nuovo nome"/>
                    </div>
                    <div class="form-group">
                        <button type='button' id="saveName" class='btn btn-success change'>Salva</button>
                        <button type='button' id="cancelChangeName" class='btn btn-danger change'>Annulla</button>
                    </div>
                </form>
                <form id="newUserEmail" class="text-center supplierTextBoxStartAfterNavbar">
                    <div class="form-group">
                        <label class="notVisible" for="newEmail">Nuova email</label>
                        <input type="email" id="newEmail" class='form-control' placeholder="Nuova email"/>
                    </div>
                    <div class="form-group">
                        <button type='button' id="saveEmail" class='btn btn-success change'>Salva</button>
                        <button type='button' id="cancelChangeEmail" class='btn btn-danger change'>Annulla</button>
                    </div>
                </form>
                <form id="newUserPassword" class="text-center supplierTextBoxStartAfterNavbar">
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
                        <button type='button' id="cancelChangePassword" class='btn btn-danger change'>Annulla</button>
                    </div>
                </form>
                <form id="newSupplierVatNumber" class="text-center supplierTextBoxStartAfterNavbar">
                    <div class="form-group">
                        <label class="notVisible" for="newVatNumber">Nuova partita iva</label>
                        <input type="number" min="0" step="0.01" data-number-to-fixed="2" class="form-control spedition" id="newVatNumber" placeholder="Nuova partita iva"/>
                        <div id="vatNumberError"></div>
                    </div>
                    <div class="form-group">
                        <button type='button' id="saveVatNumber" class='btn btn-success change'>Salva</button>
                        <button type='button' id="cancelChangeVatNumber" class='btn btn-danger change'>Annulla</button>
                    </div>
                </form>
                <?php
            }
            ?>
            <img id="image" src="../../../../res/suppliers/<?php echo $supplier["immagine"] != NULL ? $supplier["immagine"] : 'default.jpg';?>" class="img-fluid img-thumbnail" alt="Logo fornitore">
            <?php
            if ($supplierPage) {
                ?>
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
                        <button type='button' id="cancelChangeImage" class='btn btn-danger change'>Annulla</button>
                    </div>
                </form>
                <?php
            }
        }
    }
}
?>
