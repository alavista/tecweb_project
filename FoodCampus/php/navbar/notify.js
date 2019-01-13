$(function() {
    var isPageAllNotifications = false;
    if (window.location.pathname.indexOf("notification") >= 0) {
        isPageAllNotifications = true;
    }
    setTimeout(function() {
        if (getId() != NOT_PRESENT) {
            $("#notification").click(function() {
                $("#numberNotification").html("0");
                load_unseen_notification("yes", isPageAllNotifications);
            });
            setInterval(function(){
                load_unseen_notification("", isPageAllNotifications);
            }, 5000);
        }
    }, 1000);
});

function load_unseen_notification(view = "", isPageAllNotifications = false) {
    var userType = getUserType();
    $.post("/tecweb_project/FoodCampus/php/navbar/fetchNotifications.php", {
        userId: getId(),
        fieldId: userType.localeCompare("fornitore") == 0 ? "IDFornitore" : userType.localeCompare("cliente") == 0 ? "IDCliente" : "",
        view: view,
        numberNotification: $("#numberNotification").html()
    }, function(data, status) {
        data = JSON.parse(data);
        if (data.status.localeCompare("OK") == 0) {
            $(".dropdown-menu").html(data.notification);
            if (data.numberNotSeenNotification > 0) {
                $("#numberNotification").html(data.numberNotSeenNotification);
            }
            if (data.newNotification.localeCompare("yes") == 0) {
                Push.create(data.notificationTitle, {
                    body: data.notificationBody,
                    icon: "/tecweb_project/FoodCampus/res/other/icon.png",
                    onClick: function() {
                        if (userType.localeCompare("cliente") == 0) {
                            window.focus();
                            this.close();
                        } else {
                            window.location = "#";
                            window.focus();
                            this.close();
                        }
                    }
                });
                if (isPageAllNotifications) {
                    $("#medias").prepend("<div class='media border p-3'><div class='media-body'><h4>" + data.notificationTitle + "</h4><p>" + data.notificationBody + "</p>");
                }
            }
        }
    });
}
