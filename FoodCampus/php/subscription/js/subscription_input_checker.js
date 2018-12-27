var formValid = false;

function focusOnField(field) {
    $("html, body").animate({
        scrollTop: field.offset().top - 200
    }, 750);
}

function showError(element, errorTag, errorMessage){
    if (($("#" + errorTag)).length === 0) {
        element.after("<div id=" + errorTag + " class='alert alert-danger' style='margin-top: 8px;'>"
                        + errorMessage + "</div>");
    }
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

function checkInputs(){
    var inputFields = new Array();
    var valid = true;

    $(".alert").remove();

    $(":input[required]:visible").each(function() {
        var elem = $(this);

        if (elem.val() === "") {
            valid = false;
            inputFields.push(elem);

            if (elem.next(".validation").length === 0) {
                elem.after("<div class='text-danger validation'>Questo campo è obbligatorio</div>");
            }
        }
        else {
            elem.siblings(".validation").remove();

            switch (elem.attr('id')) {
                case ("email"):
                    if (!checkEmail()) {
                        valid = false;
                        inputFields.push(elem);
                    }
                break;

                case ("pwd"):
                    if (!checkPasswordValidity()) {
                        valid = false;
                        inputFields.push(elem);
                    }
                break;

                case ("confirm-pwd"):
                    if ($("#pwd").val() !== "" && !checkPasswords()) {
                        valid = false;
                        inputFields.push(elem);
                    }
                break;
            }
        }
    });

    if(!valid) {
        focusOnField(inputFields[0]);
        formValid = false;
        event.preventDefault();
    } else {
        formValid = true;
    }
}

function checkShippingCost(currentCost) {
    console.log(currentCost);
    if (currentCost > 10) {
        return 10;
    } else if (currentCost < 0 || currentCost == "") {
        return 0;
    }
    else {
        return currentCost;
    }
}

$(document).ready(function() {
    $("#submitbtn").on("click", function() {
        checkInputs();
        if (formValid) {
            formhash($("form"), $("#pwd"));
        }
    });

    $("#costo-spedizione").on("input", function() {
        this.value = checkShippingCost(this.value);
    });

    $("#soglia-spedizione").on("input", function() {
        this.value =  checkShippingCost(this.value);
    });

});
