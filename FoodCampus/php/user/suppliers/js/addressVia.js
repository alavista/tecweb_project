$(function() {
    $("#newSupplierAddress").hide();

    $("#changeAddress").click(function() {
        switchFromDivToDivAndSetValueTextbox("newAddress", "address", "supplierAddress", "newSupplierAddress");
    })

    $("#saveAddress").click(function() {
        checkTextUpdateUserInformationAndSwitchFromDivToDiv("newAddress", "address","indirizzo_via", "newSupplierAddress", "supplierAddress", "../../commonParts/php/changeUserInformation.php", function(inf) {
            $("#address").html(inf);
        }, function(inf) {
            managmentGeneralError($("#newAddress"), inf);
        });
    });

    $("#cancelChangeAddress").click(function() {
        switchFromDivToDivAndRemoveError("newAddress", "newSupplierAddress", "supplierAddress");
    });
});
