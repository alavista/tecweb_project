const NOT_PRESENT = -1;

$(function() {
    $.ajax({
        type: "POST",
        url: "/tecweb_project/FoodCampus/php/utilities/getIdSession.php",
        success: function(data) {
            $.session.set("user_id", data);
        }
    });

    $.ajax({
        type: "POST",
        url: "/tecweb_project/FoodCampus/php/utilities/getUserTypeSession.php",
        success: function(data) {
            $.session.set("user_type", data);
        }
    });
});

function getId() {
    var cookieId = $.cookie("user_id");
    var sessionId = $.session.get("user_id");
    var id = NOT_PRESENT;
    if (cookieId) {
        id = cookieId;
    } else if (sessionId != NOT_PRESENT) {
        id = sessionId;
    }
    return id;
}

function getUserType() {
    var cookieClientOrSupplier = $.cookie("user_type");
    var sessionClientOrSupplier = $.session.get("user_type");
    var type = "";
    if (cookieClientOrSupplier) {
        type = cookieClientOrSupplier.localeCompare("Fornitore") == 0 ? "fornitore" : cookieClientOrSupplier.localeCompare("Cliente") == 0 ? "cliente" : "";
    } else if (sessionClientOrSupplier.localeCompare("notDefined") != 0) {
        type = sessionClientOrSupplier.localeCompare("fornitore") == 0 ? "fornitore" : sessionClientOrSupplier.localeCompare("cliente") == 0 ? "cliente" : "";
    }
    return type;
}
