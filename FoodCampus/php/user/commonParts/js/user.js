$(function() {
    $.ajax({
        type: "POST",
        url: "../commonParts/php/getIdSession.php",
        success: function(data) {
            $.session.set("user_id", data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.ajax({
                type: "POST",
                url: "../../commonParts/php/getIdSession.php",
                success: function(data) {
                    $.session.set("user_id", data);
                }
            });
        }
    });

    $.ajax({
        type: "POST",
        url: "../commonParts/php/getUserTypeSession.php",
        success: function(data) {
            $.session.set("user_type", data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $.ajax({
                type: "POST",
                url: "../../commonParts/php/getUserTypeSession.php",
                success: function(data){
                    $.session.set("user_type", data);
                }
            });
        }
    });
});
