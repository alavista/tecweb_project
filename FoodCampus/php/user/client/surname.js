$(function() {
    $("#newUserSurname").hide();

    $("#changeSurname").click(function() {
        switchFromDivToDivAndSetValueTextbox("newSurname", "surname", "userName", "newUserSurname");
    });

    $("#saveSurname").click(function() {
        checkTextUpdateUserInformationAndSwitchFromDivToDiv("newSurname", "surname", "cognome", "newUserSurname", "userName", "../commonParts/php/changeUserInformation.php", function(inf) {
            var surname = inf.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                    return letter.toUpperCase();
                });
            $("#surname").html(surname);
        }, function(inf) {
            managmentGeneralError($("#newSurname"), inf);
        });
    });

    $("#cancelChangeSurname").click(function() {
        switchFromDivToDivAndRemoveError("newSurname", "newUserSurname", "userName");
    });
});
