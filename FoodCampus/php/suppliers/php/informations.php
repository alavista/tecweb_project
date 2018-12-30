<div class="jumbotron">
    <span class="text-center"><h2>Informazioni</h2></span>
    <div id="supplierCity">
        <div class="row">
            <div class="col-sm-5">
                <span class="font-weight-bold">Città:</span>
                <p id="city"><?php echo $supplier["citta"];?></p>
            </div>
            <?php
            if ($supplierPage) {
                echo "<div class='col-sm-7'>
                          <button type='button' class='btn btn-secondary changePlus' id='changeCity'>Modifica città</button>
                      </div>";
            }
            ?>
        </div>
    </div>
    <?php
    if ($supplierPage) {
        ?>
        <form id="newSupplierCity" class="text-center">
            <div class="form-group">
                <label class="notVisible" for="newCity">Nuova città</label>
                <input type="text" id="newCity" class='form-control' placeholder="Nuova città"/>
                <button type='button' id="saveCity" class='btn btn-success change'>Salva</button>
                <button type='button' id="cancelChangeCity" class='btn btn-danger change'>Annulla</button>
            </div>
        </form>
        <?php
    }
    ?>
    <div id="supplierAddress">
        <div class="row">
            <div class="col-sm-5">
                <span class="font-weight-bold">Indirizzo:</span>
                <p id="address"><?php echo $supplier["indirizzo_via"];?></p>
            </div>
            <?php
            if ($supplierPage) {
                echo "<div class='col-sm-7'>
                          <button type='button' class='btn btn-secondary changePlus' id='changeAddress'>Modifica indirizzo</button>
                      </div>";
            }
            ?>
        </div>
    </div>
    <?php
    if ($supplierPage) {
        ?>
        <form id="newSupplierAddress" class="text-center">
            <div class="form-group">
                <label class="notVisible" for="newAddress">Nuovo indirizzo</label>
                <input type="text" id="newAddress" class='form-control' placeholder="Nuovo indirizzo"/>
                <button type='button' id="saveAddress" class='btn btn-success change'>Salva</button>
                <button type='button' id="cancelChangeAddress" class='btn btn-danger change'>Annulla</button>
            </div>
        </form>
        <?php
    }
    ?>
    <div id="supplierHouseNumber">
        <div class="row">
            <div class="col-sm-5">
                <span class="font-weight-bold">Numero civico:</span>
                <p id="houseNumber"><?php echo $supplier["indirizzo_numero_civico"];?></p>
            </div>
            <?php
            if ($supplierPage) {
                echo "<div class='col-sm-7'>
                          <button type='button' class='btn btn-secondary changePlus' id='changeHouseNumber'>Modifica numero civico</button>
                      </div>";
            }
            ?>
        </div>
    </div>
    <?php
    if ($supplierPage) {
        ?>
        <form id="newSupplierHouseNumber" class="text-center">
            <div class="form-group">
                <label class="notVisible" for="newHouseNumber">Nuovo numero civico</label><input type="text" id="newHouseNumber" class='form-control' placeholder="Nuovo numero civico"/>
                <button type='button' id="saveHouseNumber" class='btn btn-success change'>Salva</button>
                <button type='button' id="cancelChangeHouseNumber" class='btn btn-danger change'>Annulla</button>
            </div>
        </form>
        <?php
    }
    ?>
    <div id="supplierShippingCosts">
        <div class="row">
            <div class="col-sm-5">
                <span class="font-weight-bold">Costi di spedizione:</span>
                <p id="shippingCosts"><?php echo $supplier["costi_spedizione"];?> €</p>
            </div>
            <?php
            if ($supplierPage) {
                echo "<div class='col-sm-7'>
                          <button type='button' class='btn btn-secondary changePlus' id='changeShippingCosts'>Modifica costi di spedizione</button>
                      </div>";
            }
            ?>
        </div>
    </div>
    <?php
    if ($supplierPage) {
        ?>
        <form id="newSupplierShippingCosts" class="text-center">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">€</span>
                    </div>
                    <label class="notVisible" for="newShippingCosts">Nuovi costi spedizione</label><input type="number" value="0.00" max= "10.00" min="0" step="0.01" data-number-to-fixed="2" class="form-control spedition" id="newShippingCosts" placeholder="Nuovi costi spedizione"/>
                </div>
                <div id="costError"></div>
                <button type='button' id="saveShippingCosts" class='btn btn-success change'>Salva</button>
                <button type='button' id="cancelChangeShippingCosts" class='btn btn-danger change'>Annulla</button>
            </div>
        </form>
        <?php
    }
    ?>
    <div id="supplierWebSite">
        <div class="row">
            <div class="col-sm-5">
                <span class="font-weight-bold">Sito web:</span><br/>
                <a id="webSite" href="<?php echo $supplier["sito_web"];?>"><?php echo $supplier["sito_web"];?></a></p>
            </div>
            <?php
            if ($supplierPage) {
                echo "<div class='col-sm-7'>
                          <button type='button' class='btn btn-secondary changePlus' id='changeWebSite'>Modifica sito web</button>
                      </div>";
            }
            ?>
        </div>
    </div>
    <?php
    if ($supplierPage) {
        ?>
        <form id="newSupplierWebSite" class="text-center">
            <div class="form-group">
                <label class="notVisible" for="newWebSite">Nuovo sito web</label>
                <input type="text" id="newWebSite" class='form-control' placeholder="Nuovo sito web"/>
                <button type='button' id="saveWebSite" class='btn btn-success change'>Salva</button>
                <button type='button' id="cancelChangeWebSite" class='btn btn-danger change'>Annulla</button>
            </div>
        </form>
        <?php
    }
    ?>
</div>
