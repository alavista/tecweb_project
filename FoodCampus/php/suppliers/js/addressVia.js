$(function() {
    $("#newSupplierAddress").hide();

    $("#changeAddress").click(function() {
        switchFromDivToDivAndSetValueTextbox("newAddress", "address", "supplierAddress", "newSupplierAddress");
    })

    $("#saveAddress").click(function() {
        checkTextUpdateSupplierInformationAndSwitchFromDivToDiv("newAddress", "address","indirizzo_via", "newSupplierAddress", "supplierAddress", "../php/changeSupplierInformation.php", function(inf) {
            $("#address").html(inf);
        }, function(inf) {
            managmentGeneralError($("#newAddress"), inf);
        });
    });

    $("#cancelChangeAddress").click(function() {
        switchFromDivToDivAndRemoveError("newAddress", "newSupplierAddress", "supplierAddress");
    });
});
