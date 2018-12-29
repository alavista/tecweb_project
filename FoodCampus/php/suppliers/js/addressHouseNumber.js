$(function() {
    $("#newSupplierHouseNumber").hide();

    $("#changeHouseNumber").click(function() {
        switchFromDivToDivAndSetValueTextbox("newHouseNumber", "houseNumber", "supplierHouseNumber", "newSupplierHouseNumber");
    })

    $("#saveHouseNumber").click(function() {
        checkTextUpdateSupplierInformationAndSwitchFromDivToDiv("newHouseNumber", "houseNumber","indirizzo_numero_civico", "newSupplierHouseNumber", "supplierHouseNumber", "../php/changeSupplierInformation.php", function(inf) {
            $("#houseNumber").html(inf);
        }, function(inf) {
            managmentGeneralError($("#newHouseNumber"), inf);
        });
    });

    $("#cancelChangeHouseNumber").click(function() {
        switchFromDivToDivAndRemoveError("newHouseNumber", "newSupplierHouseNumber", "supplierHouseNumber");
    });
});
