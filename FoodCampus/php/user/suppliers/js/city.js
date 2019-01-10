$(function() {
    $("#newSupplierCity").hide();

    $("#changeCity").click(function() {
        switchFromDivToDivAndSetValueTextbox("newCity", "city", "supplierCity", "newSupplierCity");
    });

    $("#saveCity").click(function() {
        checkTextUpdateUserInformationAndSwitchFromDivToDiv("newCity", "city","citta", "newSupplierCity", "supplierCity", "../../commonParts/php/changeUserInformation.php", function(inf) {
            $("#city").html(inf);
        }, function(inf) {
            managmentGeneralError($("#newCity"), inf);
        });
    });

    $("#cancelChangeCity").click(function() {
        switchFromDivToDivAndRemoveError("newCity", "newSupplierCity", "supplierCity");
    });
});
