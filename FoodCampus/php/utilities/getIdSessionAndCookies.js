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
