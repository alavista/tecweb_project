$(document).ready(function() {

	$("form").on("submit", function(e) {
		var url = window.location.href;
		$pwd_input = $("input[name='password']");
		if(!($pwd_input.val() === $pwd_input.attr("defaultValue"))) {
            $pwd_input.val(hex_sha512($pwd_input.val()));
            $pwd_input.attr("defaultValue", $pwd_input.val());
        }
		var action = "";
		
		var formData = new FormData($("#insert-update-form")[0]);
		if($("input[name=immagine]").val()) {
	        var img = $("input[name=immagine]")[0].files[0];
	        formData.append("image", img);
	    }
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