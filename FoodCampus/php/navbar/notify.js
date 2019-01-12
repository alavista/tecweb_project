$(function() {
    setTimeout(function() {
        if (getId() != NOT_PRESENT) {
            $("#notification").click(function() {
                $("#numberNotification").html("0");
                load_unseen_notification("yes");
            });
            setInterval(function(){
                load_unseen_notification();;
            }, 5000);
        }
    }, 1000);
});

function load_unseen_notification(view = "") {
    var userType = getUserType();
    $.post("/tecweb_project/FoodCampus/php/navbar/fetchNotifications.php", {
        userId: getId(),
        fieldId: userType.localeCompare("fornitore") == 0 ? "IDFornitore" : userType.localeCompare("cliente") == 0 ? "IDCliente" : "",
        view: view
    }, function(data, status) {
        data = JSON.parse(data);
        if (data.status.localeCompare("OK") == 0) {
            $(".dropdown-menu").html(data.notification);
            if (data.numberNotSeenNotification > 0) {
                $("#numberNotification").html(data.numberNotSeenNotification);
            }
        }
    });
}
