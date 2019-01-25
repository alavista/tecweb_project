$(function() {
    $("#newSupplierWebSite").hide();

    $("#changeWebSite").click(function() {
        //switchFromDivToDivAndSetValueTextbox("newWebSite", "webSite", "supplierWebSite", "newSupplierWebSite");

        if ($("#linkWebSite").length ) {
            $("#newWebSite").val($("#linkWebSite").html());
        }
        switchFromDivToDiv("supplierWebSite", "newSupplierWebSite");

    })

    $("#saveWebSite").click(function() {
        checkTextUpdateUserInformationAndSwitchFromDivToDiv("newWebSite", "webSite", "sito_web", "newSupplierWebSite", "supplierWebSite", "../../commonParts/php/changeUserInformation.php", function(inf) {
            $("#webSite").html("<a id='linkWebSite' href='" + inf + "'>" + inf + "</a>");
        }, function(inf) {
            managmentGeneralError($("#newWebSite"), inf);
        });
    });

    $("#cancelChangeWebSite").click(function() {
        switchFromDivToDivAndRemoveError("newWebSite", "newSupplierWebSite", "supplierWebSite");
    });
});
