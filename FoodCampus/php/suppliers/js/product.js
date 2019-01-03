$(function() {
    $(".products").hide();

    $(document).on("click", ".changeProduct", function() {
        var idProduct = getIdProduct($(this));
        $("#newProductCost_" + idProduct).val($("#productCost_" + idProduct).html());
        switchFromDivToDivAndSetValueTextbox("newProductName_" + idProduct, "productName_" + idProduct, "product_" + idProduct, "modificationProduct_" + idProduct);
    });

    $(document).on("click", ".saveProduct", function() {
        var idProduct = getIdProduct($(this));
        var productName = $("#newProductName_" + idProduct).val();
        var productCost = $("#newProductCost_" + idProduct).val().replace(/,/,".");
        var productError = $("#productError_" + idProduct);
        removeError(productError);
        if (productName.trim()) {
            if ($.isNumeric(productCost) && productCost > 0) {
                $.post("../php/changeProduct.php", {
                    idProduct: idProduct,
                    productName: productName,
                    productCost: productCost
                }, function(data, status) {
                    data = JSON.parse(data);
                    if (data.status.localeCompare("ERROR") == 0) {
                        managmentGeneralError(productError, data.inf);
                    } else if (data.status.localeCompare("OK") == 0) {
                        $("#productName_" + idProduct).html(productName);
                        $("#productCost_" + idProduct).html(productCost);
                        removeError(productError);
                        switchFromDivToDiv("modificationProduct_" + idProduct, "product_" + idProduct);
                    }
                });
            } else {
                $(productError).html("<div class='text-danger validation'><i class='fas fa-times'> Il prodotto deve avere un prezzo maggiore di 0 €</i></div>");
                $("#newProductCost_" + idProduct).focus();
            }
        } else {
            $(productError).html("<div class='text-danger validation'><i class='fas fa-times'> " + STANDARD_ERROR_MESSAGGE + "</i></div>");
            $("#newProductName_" + idProduct).focus();
        }
    });

    $(document).on("click", ".cancelChangeProduct", function() {
        var idProduct = getIdProduct($(this));
        $("#productError_" + idProduct).html("");
        switchFromDivToDiv("modificationProduct_" + idProduct, "product_" + idProduct);
    });

    $(document).on("click", ".addNewProduct", function() {
        var idCategory = getIdCategory($(this));
        $("#newProductNameInCategory_" + idCategory).val("");
        $("#newProductCostInCategory_" + idCategory).val("0");
        switchFromDivToDiv("addProductInCategory_" + idCategory, "appendProductInCategory_" + idCategory);
    });

    $(document).on("click", ".saveNewProduct", function() {
        var idCategory = getIdCategory($(this));
        var productName = $("#newProductNameInCategory_" + idCategory).val();
        var productCost = $("#newProductCostInCategory_" + idCategory).val().replace(/,/,".");
        var productError = $("#productErrorInCategory_" + idCategory);
        removeError(productError);
        if (productName.trim()) {
            if ($.isNumeric(productCost) && productCost > 0) {
                $.post("../php/addProduct.php", {
                    idCategory: idCategory,
                    idSupplier: getId(),
                    productName: productName,
                    productCost: productCost
                }, function(data, status) {
                    data = JSON.parse(data);
                    if (data.status.localeCompare("ERROR") == 0) {
                        managmentGeneralError(productError, data.inf);
                    } else if (data.status.localeCompare("OK") == 0) {
                        $("#ProductsOfCategory_" + idCategory).append("<div class='product' id='product_" + data.inf + "'><div class='row'><div class='col-lg-4'><span id='productName_" + data.inf + "'>" + productName + "</span>: <span id='productCost_" + data.inf + "'>" + productCost + "</span> €</div><div class='col-lg-4'><button type='button' id='changeProduct_" + data.inf + "' class='btn btn-secondary changePlus changeProduct'>Modifica prodotto</button></div><div class='col-lg-4'><button type='button' id='deleteProduct_" + data.inf + "' class='btn btn btn-danger change deleteProduct'>Cancella prodotto</button></div></div></div><form id='modificationProduct_" + data.inf + "' class='text-center products'><div class='form-group'><label class='notVisible' for='newProductName_" + data.inf + "'>Nome prodotto</label><input type='text' id='newProductName_" + data.inf + "' class='form-control' placeholder='Nome prodotto'/></div><div class='form-group'><div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>€</span></div><label class='notVisible' for='newProductCost_" + data.inf + "'>Costo prodotto</label><input type='number' value='0.00' min='0' step='0.01' data-number-to-fixed='2' class='form-control spedition' id='newProductCost_" + data.inf + "' placeholder='Costo prodotto'/></div><div id='productError_" + data.inf + "'></div></div><div class='form-group'><button type='button' id='saveProduct_" + data.inf + "' class='btn btn-success change saveProduct'>Salva</button><button type='button' id='cancelChangeProduct_" + data.inf + "'    class='btn btn-danger change cancelChangeProduct'>Annulla</button></div></form>");
                        $("#modificationProduct_" + data.inf).hide();
                        removeError(productError);
                        switchFromDivToDiv("appendProductInCategory_" + idCategory, "addProductInCategory_" + idCategory);
                    }
                });
            } else {
                $(productError).html("<div class='text-danger validation'><i class='fas fa-times'> Il prodotto deve avere un prezzo maggiore di 0 €</i></div>");
                $("#newProductCostInCategory_" + idCategory).focus();
            }
        } else {
            $(productError).html("<div class='text-danger validation'><i class='fas fa-times'> " + STANDARD_ERROR_MESSAGGE + "</i></div>");
            $("#newProductNameInCategory_" + idCategory).focus();
        }
    });

    $(document).on("click", ".cancelNewProduct", function() {
        var idCategory = getIdCategory($(this));
        $("#productErrorInCategory_" + idCategory).html("");
        switchFromDivToDiv("appendProductInCategory_" + idCategory, "addProductInCategory_" + idCategory);
    });

    $(document).on("click", ".deleteProduct", function() {
        var idProduct = getIdProduct($(this));
        $.confirm({
            title: 'Attenzione!',
            content: 'Sei sicuro di voler cancellare DEFINITIVAMENTE questo prodotto?',
            buttons: {
                conferma: function () {
                    $.post("../php/deleteProduct.php", {
                        idProduct: idProduct
                    }, function(data, status) {
                        data = JSON.parse(data);
                        if (data.status.localeCompare("ERROR") == 0) {
                            $.alert({
                                title: 'Errore!',
                                content: data.inf,
                            });
                        } else if (data.status.localeCompare("OK") == 0) {
                            $("#product_" + idProduct).remove();
                        }
                    });
                },
                cancella: function () {
                }
            }
        });
    });
});

function getIdProduct(elem) {
    return elem.attr("id").split('_')[1];
}

function getIdCategory(elem) {
    return elem.attr("id").split('_')[1];
}
