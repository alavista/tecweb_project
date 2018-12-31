$(function() {
    $("#newSupplierImage").hide();

    $("#changeImage").click(function() {
        switchFromDivToDiv("supplierImage", "newSupplierImage");
    });

    $("#saveImage").click(function() {
        var newImage= $("#newImage");
        var idSupplier = getId();
        var fd = new FormData();
        var files = $('#newImage')[0].files[0];
        fd.append('file',files);
        removeError(newImage);
        $.ajax({
            url: '../php/changeImage.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                response = JSON.parse(response);
                if (response.status.localeCompare("ERROR") == 0) {
                    showError(newImage, response.inf);
                } else if (response.status.localeCompare("OK") == 0) {
                    $("#image").attr("src", response.inf);
                    removeError(newImage);
                    switchFromDivToDiv("newSupplierImage", "supplierImage");
                }
            },
        });
    });

    $("#cancelChangeImage").click(function() {
        $("#newImage").val("");
        switchFromDivToDivAndRemoveError("newImage", "newSupplierImage", "supplierImage");
    });
});
