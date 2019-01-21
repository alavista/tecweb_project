$(function() {
    var isPageAllNotifications = false;
    if (window.location.pathname.indexOf("notification") >= 0) {
        isPageAllNotifications = true;
    }
    setTimeout(function() {
        if (getId() != NOT_PRESENT) {
            $("#notification").click(function() {
                $(".list-group-item.link-class").remove();
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
                var i;
                for (i = 0; i < data.numberNewNotifications; i++) {
                    Push.create(data.notificationTitle, {
                        body: data.newNotifications["notificationBody" + i],
                        icon: "/tecweb_project/FoodCampus/res/other/icon.png",
                        onClick: function() {
                            if (userType.localeCompare("cliente") == 0) {
                                window.focus();
                                this.close();
                            } else {
                                if (getUserType().localeCompare("fornitore") == 0) {
                                    window.location = "/tecweb_project/FoodCampus/php/supplier_orders/supplier-orders.php?id=" + getId();
                                }
                                window.focus();
                                this.close();
                            }
                        }
                    });
                    if (isPageAllNotifications) {
                        $("#medias").prepend("<div class='media border p-3'><div class='media-body'><h4>" + data.notificationTitle + "</h4><p>" + data.newNotifications["notificationBody" + i] + "</p>");
                    }
                }
            }
        }
    });
}
