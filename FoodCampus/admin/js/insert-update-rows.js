$(document).ready(function(){

	$("#submit").click(function() {
		var url = window.location.href;
		if($("input[name='password']").length) {
			$("input[name='password']").val(hex_sha512($("input[name='password']").val()));
		}
		if(url.indexOf("id") >= 0) {
			$.ajax({
				type: "POST",
				url: "php/update-row-request.php?id=" + $.urlParam('id'),
				data: $("form").serialize(),
				dataType: "html",
				success: function(msg)
				{
					$("#result").html(msg);
				},
				error: function()
				{
					alert("Chiamata fallita, si prega di riprovare...");
				}
			});
		} else {
			$.ajax({
				type: "POST",
				url: "php/insert-row-request.php",
				data: $("form").serialize(),
				dataType: "html",
				success: function(msg)
				{
					$("#result").html(msg);
				},
				error: function()
				{
					alert("Chiamata fallita, si prega di riprovare...");
				}
			});
		}
	});

	$("#profileImage").click(function() {
        var newImage= $("#profileImage");
        var fd = new FormData();
        var files = $('#newImage')[0].files[0];
        var isClient = $("input[name='table']").val() == "cliente"
        fd.append('file',files);
        removeError(newImage);
        console.log(getUserType());
        console.log(getId());
        $.ajax({
            url: '../php/user/commonParts/php/changeImage.php',
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

});

$.urlParam = function(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	return results[1] || 0;
}