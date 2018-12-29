$(function() {
    $("#newSupplierCity").hide();

    $("#changeCity").click(function() {
        switchFromDivToDivAndSetValueTextbox("newCity", "city", "supplierCity", "newSupplierCity");
    });

    $("#saveCity").click(function() {
        checkTextUpdateSupplierInformationAndSwitchFromDivToDiv("newCity", "city","citta", "newSupplierCity", "supplierCity", "../php/changeSupplierInformation.php", function(inf) {
            $("#city").html(inf);
        }, function(inf) {
            managmentGeneralError($("#newCity"), inf);
        });
    });

    $("#cancelChangeCity").click(function() {
        switchFromDivToDivAndRemoveError("newCity", "newSupplierCity", "supplierCity");
    });
});
