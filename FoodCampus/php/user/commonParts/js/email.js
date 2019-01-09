$(function() {
    $("#newUserEmail").hide();

    $("#changeEmail").click(function() {
        switchFromDivToDivAndSetValueTextbox("newEmail", "email", isClient() ? "userEmail" : "userName", "newUserEmail");
    });

    $("#saveEmail").click(function() {
        var regex = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
        var emailTag = $("#newEmail");
        removeError(emailTag);
        if (regex.test((emailTag).val()) === false) {
            managmentEmailError(emailTag, "emailNonValida");
        } else {
            updateUserInformationAndSwitchFromDivToDiv("newEmail", "email", "email", emailTag.val(), "newUserEmail", isClient() ? "userEmail" : "userName", getUserType().localeCompare("cliente") == 0 ? "../commonParts/php/changeEmail.php" : "../../commonParts/php/changeEmail.php", function(inf) {
                $("#email").html(emailTag.val());
            }, function(inf) {
                managmentEmailError(emailTag, inf);
            });
        }
    });

    $("#cancelChangeEmail").click(function() {
        switchFromDivToDivAndRemoveError("newEmail", "newUserEmail", isClient() ? "userEmail" : "userName");
    });
});

function managmentEmailError(elem, error) {
    switch (error) {
        case "emailNonValida":
            showError(elem, "Indirizzo Email non valido!");
            elem.focus();
            break;
        case "emailEsistente":
            showError(elem, "Questa email esiste già!");
            elem.focus();
            break;
        case "parametriNonCorretti":
            showError(elem, "Parametri non corretti!");
            break;
        case "errore":
            showError(elem, "Errore. Riprova più tardi!");
            break;
        break;
        default:
            showError(elem, "Errore. Riprova più tardi!");
            break;
    }
}

function isClient() {
    return getUserType().localeCompare("cliente") == 0;
}
