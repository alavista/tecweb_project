$(function() {
    $(".products").hide();

    $(".changeProduct").click(function() {
        var idProduct = getIdProduct($(this));
        $("#newProductCost_" + idProduct).val($("#productCost_" + idProduct).html());
        switchFromDivToDivAndSetValueTextbox("newProductName_" + idProduct, "productName_" + idProduct, "product_" + idProduct, "modificationProduct_" + idProduct);
    });

    $(".saveProduct").click(function() {
        var idProduct = getIdProduct($(this));
        var productName = $("#newProductName_" + idProduct).val();
        var productCost = $("#newProductCost_" + idProduct).val().replace(/,/,".");
        var productError = $("#productError_" + idProduct);
        removeError(productError);
        if (productName.trim()) {
            if ($.isNumeric(productCost) && productCost >= 0) {
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

    $(".cancelChangeProduct").click(function() {
        var idProduct = getIdProduct($(this));
        $("#productError_" + idProduct).html("");
        switchFromDivToDiv("modificationProduct_" + idProduct, "product_" + idProduct);
    });

});

function getIdProduct(elem) {
    return elem.attr("id").split('_')[1];
}
