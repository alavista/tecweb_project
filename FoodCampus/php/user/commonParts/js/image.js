$(function() {
    $("#newUserImage").hide();

    $("#changeImage").click(function() {
        $("#newUserImage").show("slow");
    });

    $("#saveImage").click(function() {
        var newImage= $("#newImage");
        var fd = new FormData();
        var files = $('#newImage')[0].files[0];
        var isClient = getUserType().localeCompare("cliente") == 0;
        fd.append('file',files);
        removeError(newImage);
        console.log(getUserType());
        console.log(getId());
        $.ajax({
            url: isClient ? '../commonParts/php/changeImage.php' : '../../commonParts/php/changeImage.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                response = JSON.parse(response);
                if (response.status.localeCompare("ERROR") == 0) {
                    showError(newImage, response.inf);
                } else if (response.status.localeCompare("OK") == 0) {
                    $("#image").attr("src", isClient ? "../../../res/clients/" + response.inf : "../../../../res/suppliers/" + response.inf);
                    removeError(newImage);
                    $("#newUserImage").hide("slow");
                }
            },
        });
    });

    $("#cancelChangeImage").click(function() {
        removeError($("#newImage"));
        $("#newImage").val("");
        $("#newUserImage").hide("slow");
    });
});
