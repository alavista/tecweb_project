function showError(element, errorTag, errorMessage) {
    $(".alert.alert-danger").remove();
    if (($("#" + errorTag)).length === 0) {
        element.after("<div id=" + errorTag + " class='alert alert-danger errorElement'>"
                        + errorMessage + "</div>");
    }
    event.preventDefault();
}

function checkEmail() {
    var regex = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
    var emailTag = $("#email");
    var errorTagId = "alertemail";

    $("#" + errorTagId).remove();

    if (regex.test((emailTag).val()) === false && $("#" + errorTagId).val() !== "") {
        showError(emailTag, errorTagId, "Indirizzo Email non valido");
        return false;
    }
    return true;
}

$(document).ready(function() {
    $("#submitbtn").on("click", function() {
        checkEmail();
    });
});
