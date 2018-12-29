$(function() {
    loadStars();
    $('[data-toggle="popover"]').popover();

    $.post("../php/getIdSession.php", {
    }, function(data, status) {
        data = JSON.parse(data);
        $.session.set("user_id", data);
    });

});
