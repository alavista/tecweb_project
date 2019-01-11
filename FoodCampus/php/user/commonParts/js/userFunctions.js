const STANDARD_ERROR_MESSAGGE = "Questo campo è obbligatorio";

function switchFromDivToDiv(hideDiv, showDiv) {
    $("#" + hideDiv).fadeOut("slow", function() {
        $("#" + showDiv).fadeIn("slow");
    });
}

function switchFromDivToDivAndSetValueTextbox(idTextbox, idValue, hideDiv, showDiv) {
    $("#" + idTextbox).val($("#" + idValue).html())
    switchFromDivToDiv(hideDiv, showDiv);
}

function switchFromDivToDivAndRemoveError(idTextbox, hideDiv, showDiv) {
    removeError($("#" + idTextbox));
    switchFromDivToDiv(hideDiv, showDiv);
}

function showOrRemoveError(elem, message) {
    if (elem.val() === "" && elem.next(".validation").length == 0) {
        elem.after("<div class='text-danger validation'><i class='fas fa-times'> Questo campo è obbligatorio</i></div>");
    } else if (elem.val() != "" && elem.next(".validation").length != 0) {
        elem.next(".validation").remove();
    }
}

function showError(elem, message) {
    if (elem.next(".validation").length == 0) {
        elem.after("<div class='text-danger validation'><i class='fas fa-times'> " + message + "</i></div>");
    }
}

function removeError(elem) {
    elem.next(".validation").remove();
}

function updateUserInformationAndSwitchFromDivToDiv(newElem, elem, attribute, information, fromDiv, toDiv, filePhp, callbackSuccess, callbackError) {
    $.post(filePhp, {
        userId: getId(),
        table: getUserType(),
        attribute: attribute,
        information: information
    }, function(data, status) {
        data = JSON.parse(data);
        if (data.status.localeCompare("ERROR") == 0) {
            callbackError(data.inf);
        } else if (data.status.localeCompare("OK") == 0) {
            removeError($("#" + newElem));
            callbackSuccess(data.inf);
            switchFromDivToDiv(fromDiv, toDiv);
        }
    });
}

function checkTextUpdateUserInformationAndSwitchFromDivToDiv(newElem, elem, attribute, fromDiv, toDiv, filePhp, callbackSuccess, callbackError) {
    var information = $("#" + newElem).val();
    if (information.trim()) {
        updateUserInformationAndSwitchFromDivToDiv(newElem, elem, attribute, information, fromDiv, toDiv, filePhp, callbackSuccess, callbackError);
    } else {
        showError($("#" + newElem), STANDARD_ERROR_MESSAGGE);
        $("#" + newElem).focus();
    }
}

function managmentGeneralError(elem, error) {
    switch (error) {
        case "parametriNonCorretti":
            showError(elem, "Parametri non corretti!");
            break;
        case "errore":
            showError(elem, "Errore. Riprova più tardi!");
            break;
        default:
            showError(elem, "Errore. Riprova più tardi!");
            break;
    }
}
