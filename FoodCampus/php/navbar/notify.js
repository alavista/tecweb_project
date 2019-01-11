$(function() {
    load_unseen_notification();

    $(document).on("click", "#notification", function() {
        $("#numberNotification").html("");
        load_unseen_notification("yes");
    });

    setInterval(function(){
        load_unseen_notification();;
    }, 5000);
}

function load_unseen_notification(view = "") {
    $.post("fetchNotifications.php", {
        userId: getId(),
        fieldId: getUserType().localeCompare("fornitore") == 0 ? "IDFornitore" : "IDCliente",
        view: view
    }, function(data, status) {
        data = JSON.parse(data);
        console.log(data);
        $("#notification").html(data.notification);
        if (data.unseen_notification > 0) {
            $("#numberNotification").html(data.unseen_notification);
        }
    });
}
