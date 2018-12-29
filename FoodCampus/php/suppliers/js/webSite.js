$(function() {
    $("#newSupplierWebSite").hide();

    $("#changeWebSite").click(function() {
        switchFromDivToDivAndSetValueTextbox("newWebSite", "webSite", "supplierWebSite", "newSupplierWebSite");
    })

    $("#saveWebSite").click(function() {
        checkTextUpdateSupplierInformationAndSwitchFromDivToDiv("newWebSite", "webSite", "sito_web", "newSupplierWebSite", "supplierWebSite", "../php/changeSupplierInformation.php", function(inf) {
            $("#webSite").html(inf);
        }, function(inf) {
            managmentGeneralError($("#newWebSite"), inf);
        });
    });

    $("#cancelChangeWebSite").click(function() {
        switchFromDivToDivAndRemoveError("newWebSite", "newSupplierWebSite", "supplierWebSite");
    });
});
