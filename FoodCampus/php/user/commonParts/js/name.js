$(function() {
    $("#newUserName").hide();

    $("#changeName").click(function() {
        switchFromDivToDivAndSetValueTextbox("newName", "name", "userName", "newUserName");
    });

    $("#saveName").click(function() {
        checkTextUpdateUserInformationAndSwitchFromDivToDiv("newName", "name", "nome", "newUserName", "userName", getUserType().localeCompare("cliente") == 0 ? "../commonParts/php/changeUserInformation.php" : "../../commonParts/php/changeUserInformation.php", function(inf) {
            if (getUserType().localeCompare("cliente") == 0) {
                var name = inf.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                        return letter.toUpperCase();
                    });
                $("#name").html(name);
            } else {
                $("#name").html(inf.toUpperCase());
            }
        }, function(inf) {
            managmentGeneralError($("#newName"), inf);
        });
    });

    $("#cancelChangeName").click(function() {
        switchFromDivToDivAndRemoveError("newName", "newUserName", "userName");
    });
});
