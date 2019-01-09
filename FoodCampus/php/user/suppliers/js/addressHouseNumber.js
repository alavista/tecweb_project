$(function() {
    $("#newSupplierHouseNumber").hide();

    $("#changeHouseNumber").click(function() {
        switchFromDivToDivAndSetValueTextbox("newHouseNumber", "houseNumber", "supplierHouseNumber", "newSupplierHouseNumber");
    })

    $("#saveHouseNumber").click(function() {
        checkTextUpdateUserInformationAndSwitchFromDivToDiv("newHouseNumber", "houseNumber","indirizzo_numero_civico", "newSupplierHouseNumber", "supplierHouseNumber", "../../commonParts/php/changeUserInformation.php", function(inf) {
            $("#houseNumber").html(inf);
        }, function(inf) {
            managmentGeneralError($("#newHouseNumber"), inf);
        });
    });

    $("#cancelChangeHouseNumber").click(function() {
        switchFromDivToDivAndRemoveError("newHouseNumber", "newSupplierHouseNumber", "supplierHouseNumber");
    });
});
