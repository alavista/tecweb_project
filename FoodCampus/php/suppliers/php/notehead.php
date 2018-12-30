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
            <div class="text-center" id="supplierName">
                <h1>
                    <span id="name"><?php echo strtoupper($supplier['nome']);?></span>
                    <?php
                    $supplierPage = false;
                    if ((isset($_COOKIE["user_email"]) && ($_COOKIE["user_email"] == $supplier["email"])) ||
                            ((!empty($_SESSION["user_type"])) && (!empty($_SESSION["user_id"])) &&
                            ($_SESSION["user_type"] == "Fornitore") && ($_SESSION["user_id"] == $idSupplier))) {
                        $supplierPage = true;
                    }
                    if ($supplierPage) {
                        ?>
                        <br/>
                        <div class="row">
                            <div class="col-md-4"><button type="button" class="btn btn-secondary changePlus" id="changeName">Modifica nome</button></div>
                            <div class="col-md-4"><button type="button" class="btn btn-secondary changePlus" id="changeEmail">Modifica email</button></div>
                            <div class="col-md-4"><button type='button' class='btn btn-secondary changePlus' id='changePassword'>Modifica password</button></div>
                        </div>
                        <?php
                    }
                    ?>
                </h1>
            </div>
            <?php
            if ($supplierPage) {
                ?>
                <span id="email" class="notVisible"><?php echo $supplier["email"]; ?></span>
                <form id="newSupplierName" class="text-center">
                    <div class="form-group">
                        <label class="notVisible" for="newName">Nuovo nome</label>
                        <input type="text" id="newName" class='form-control' placeholder="Nuovo nome"/>
                        <button type='button' id="saveName" class='btn btn-success change'>Salva</button>
                        <button type='button' id="cancelChangeName" class='btn btn-danger change'>Annulla</button>
                    </div>
                </form>
                <form id="newSupplierEmail" class="text-center">
                    <div class="form-group">
                        <label class="notVisible" for="newEmail">Nuova email</label>
                        <input type="email" id="newEmail" class='form-control' placeholder="Nuova email"/>
                        <button type='button' id="saveEmail" class='btn btn-success change'>Salva</button>
                        <button type='button' id="cancelChangeEmail" class='btn btn-danger change'>Annulla</button>
                    </div>
                </form>
                <form id="newSupplierPassword" class="text-center">
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
                <?php
            }
            ?>
            <img src="../../../res/suppliers/<?php echo $supplier["immagine"] != NULL ? $supplier["immagine"] : 'default.jpg';?>" class="img-fluid img-thumbnail" alt="Logo fornitore">
            <?php
            if ($supplierPage) {
                ?>
                <div class="text-center">
                    <button type='button' class='btn btn-secondary changePlus' id='changeImage'>Modifica immagine</button>
                </div>
                <?php
            }
        }
    }
}
?>
