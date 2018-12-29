$(function() {
    $("#newSupplierEmail").hide();

    $("#changeEmail").click(function() {
        switchFromDivToDivAndSetValueTextbox("newEmail", "email", "supplierName", "newSupplierEmail");
    });

    $("#saveEmail").click(function() {
        var regex = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
        var emailTag = $("#newEmail");
        removeError(emailTag);
        if (regex.test((emailTag).val()) === false) {
            managmentEmailError(emailTag, "emailNonValida");
        } else {
            updateSupplierInformationAndSwitchFromDivToDiv("newEmail", "email", "email", emailTag.val(), "newSupplierEmail", "supplierName", "../php/changeEmail.php", function(inf) {
                $("#email").html(emailTag.val());
            }, function(inf) {
                managmentEmailError(emailTag, inf);
            });
        }
    });

    $("#cancelChangeEmail").click(function() {
        switchFromDivToDivAndRemoveError("newEmail", "newSupplierEmail", "supplierName");
    });
});
