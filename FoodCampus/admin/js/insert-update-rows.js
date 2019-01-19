$(document).ready(function() {

	$("form").on("submit", function(e) {
		var url = window.location.href;
		if($("input[name='password']").length) {
			$("input[name='password']").val(hex_sha512($("input[name='password']").val()));
		}
		var action = "";
		/*
		if(url.indexOf("id") >= 0) {
			action = "php/update-row-request.php?id=" + $.urlParam('id');
		} else {
			action = "php/insert-row-request.php";
		}
		$("#insert-update-form").attr("action", url);
		*/
		
		var formData = new FormData($("#insert-update-form")[0]);
        var img = $("input[name=immagine]")[0].files[0];
        formData.append("image", img);
		if(url.indexOf("id") >= 0) {
			$.ajax({
				type: "POST",
				url: "php/update-row-request.php?id=" + $.urlParam('id'),
				processData: false,
                contentType: false,
				data: formData,
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
				processData: false,
                contentType: false,
				data: formData,
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
		e.preventDefault();
	});

});

$.urlParam = function(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	return results[1] || 0;
}