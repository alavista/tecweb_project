$(function() {
    $("#newSupplierPassword").hide();

    $("#changePassword").click(function() {
        $("#oldPassword").val("");
        $("#newPassword").val("");
        $("#repetNewPassword").val("");
        switchFromDivToDiv("supplierName", "newSupplierPassword");
    });

    $("#savePassword").click(function() {
        var oldPassword = $("#oldPassword");
        var newPassword = $("#newPassword");
        var repetNewPassword = $("#repetNewPassword");
        removeError(repetNewPassword);
        if (oldPassword.val().length >= 6) {
            if (newPassword.val().length >= 6) {
                if (newPassword.val().localeCompare(repetNewPassword.val()) == 0) {
                    var oldEncryptedPassword = hex_sha512($("#oldPassword").val());
                    var newEncryptedPassword = hex_sha512(newPassword.val());
                    var repetNewEncryptedPassword = hex_sha512(repetNewPassword.val());
                    $.post("../php/changePassword.php", {
                        idSupplier: getIdSupplier(),
                        oldEncryptedPassword: oldEncryptedPassword,
                        newEncryptedPassword: newEncryptedPassword,
                        repetNewEncryptedPassword: repetNewEncryptedPassword
                    }, function(data, status) {
                        data = JSON.parse(data);
                        if (data.status.localeCompare("ERROR") == 0) {
                            managmentPasswordError(data.inf, oldPassword, newPassword, repetNewPassword);
                        } else if (data.status.localeCompare("OK") == 0) {
                            removeError(repetNewPassword);
                            switchFromDivToDiv("newSupplierPassword", "supplierName");
                        }
                    });
                } else {
                    managmentPasswordError("passwordsNotMatch", oldPassword, newPassword, repetNewPassword);
                }
            } else {
                managmentPasswordError("newPasswordNotOk", oldPassword, newPassword, repetNewPassword);
            }
        } else {
            managmentPasswordError("oldPasswordNotOk", oldPassword, newPassword, repetNewPassword);
        }
    });

    $("#cancelChangePassword").click(function() {
        switchFromDivToDivAndRemoveError("repetNewPassword", "newSupplierPassword", "supplierName");
    });
});

function managmentPasswordError(error, oldPassword, newPassword, repetNewPassword) {
    switch(error) {
        case "oldPasswordNotOk":
            showError(repetNewPassword, "La vecchia password non è corretta!");
            oldPassword.focus();
            break;
        case "newPasswordNotOk":
            showError(repetNewPassword, "La nuova password deve essere almeno lunga 6 caratteri!");
            newPassword.focus();
            break;
        case "passwordsNotMatch":
            showError(repetNewPassword, "Le due password non coincidono!");
            repetNewPassword.focus();
            break;
        case "parametriNonCorretti":
            showError(repetNewPassword, "Parametri non corretti!");
            break;
        case "errore":
            showError(repetNewPassword, "Errore. Riprova più tardi");
            break;
        default:
            showError(repetNewPassword, "Errore. Riprova più tardi");
    }
}
