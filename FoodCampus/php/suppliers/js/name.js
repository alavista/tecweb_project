$(function() {
    $("#newSupplierName").hide();

    $("#changeName").click(function() {
        switchFromDivToDivAndSetValueTextbox("newName", "name", "supplierName", "newSupplierName");
    });

    $("#saveName").click(function() {
        checkTextUpdateSupplierInformationAndSwitchFromDivToDiv("newName", "name", "nome", "newSupplierName", "supplierName", "../php/changeSupplierInformation.php", function(inf) {
            $("#name").html(inf.toUpperCase());
        }, function(inf) {
            managmentGeneralError($("#newName"), inf);
        });
    });

    $("#cancelChangeName").click(function() {
        switchFromDivToDivAndRemoveError("newName", "newSupplierName", "supplierName");
    });
});
