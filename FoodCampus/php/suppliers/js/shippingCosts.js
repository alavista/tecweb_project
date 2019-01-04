$(function() {
    $("#newSupplierShippingCosts").hide();

    $("#changeShippingCosts").click(function() {
        var shippingCosts = $("#shippingCosts").html();
        //Rimuovo lo spazio ed il simbolo "€"
        shippingCosts = shippingCosts.substring(0, shippingCosts.length - 2);
        $("#newShippingCosts").val(shippingCosts);
        switchFromDivToDiv("supplierShippingCosts", "newSupplierShippingCosts");
    });

    $("#saveShippingCosts").click(function() {
        var shippingCosts = $("#newShippingCosts").val().replace(/,/,".");
        if ($.isNumeric(shippingCosts) && shippingCosts >= 0 && shippingCosts <= 10) {
            updateSupplierInformationAndSwitchFromDivToDiv("newShippingCosts", "shippingCosts", "costi_spedizione", shippingCosts, "newSupplierShippingCosts", "supplierShippingCosts", "../php/changeSupplierInformation.php", function(inf) {
                $("#costError").html();
                $("#shippingCosts").html(parseFloat(inf).toFixed(2) + " €");
            }, function(inf) {
                managmentGeneralError($("#newShippingCosts"), inf);
            });
        } else {
            $("#costError").html("<div class='text-danger validation'><i class='fas fa-times'> Devi inserire un costo di spedizione compreso tra 0 e 10 €</i></div>");
            $("#newShippingCosts").focus();
        }
    });

    $("#cancelChangeShippingCosts").click(function() {
        $("#costError").html("");
        switchFromDivToDiv("newSupplierShippingCosts", "supplierShippingCosts");
    });
});
