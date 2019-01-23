function showError(element, errorTag, errorMessage) {
    $(".alert.alert-danger").remove();
    if (($("#" + errorTag)).length === 0) {
        element.after("<div id=" + errorTag + " class='alert alert-danger errorElement'>"
                        + errorMessage + "</div>");
    }
    event.preventDefault();
}

function checkPasswordValidity() {
    var pwd = $("#pwd");
    var errorTagId = "alertpwd";
    var message = "";

    if (pwd.val().length < 6) {
        message = "La password deve essere lunga almeno 6 caratteri";
        showError(pwd, errorTagId, message);
        return false;
    }

    return true;
}

function checkPasswords() {
    var pwd = $("#pwd");
    var pwdconfirm = $("#confirm-pwd");
    var errorTagId = "alertpwd";
    var message = "";

    if (pwd.val() !== pwdconfirm.val()) {
        message = "Le due password non sono uguali";
        showError(pwdconfirm, errorTagId, message);
        return false;
    }

    return true;
}

$(document).ready(function() {
    $("#submitbtn").on("click", function() {
        if ($("#pwd").val() !== "" && $("#confirm-pwd").val()) {
            if (checkPasswordValidity() && checkPasswords()) {
                var p = document.createElement("input");
                $("form").append(p);
                p.name = "c-p";
                p.type = "hidden"
                p.value = hex_sha512($("#confirm-pwd").val());
                // Assicurati che la password non venga inviata in chiaro.
                $("#confirm-pwd").removeAttr("required");
                $("#confirm-pwd").val("");

                formhash($("form"), $("#pwd"));
            }
        }
    });
});
