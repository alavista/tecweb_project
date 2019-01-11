var fieldId = getUserType().localeCompare("fornitore") == 0 ? "IDFornitore" : getUserType().localeCompare("cliente") == 0 ? "IDCliente" : "";

$(function() {
    var userId = getId();
    if (userId != NOT_PRESENT) {
        load_unseen_notification();
        $("#notification").click(function() {
            $("#numberNotification").html("0");
            load_unseen_notification("yes");
        });
        setInterval(function(){
            load_unseen_notification();;
        }, 5000);
    }
});

function load_unseen_notification(view = "") {
    $.post("/tecweb_project/FoodCampus/php/navbar/fetchNotifications.php", {
        userId: getId(),
        fieldId: fieldId,
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
