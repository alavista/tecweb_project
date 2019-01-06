$(document).ready(function(){

	$("#submit").click(function() {
		var url = window.location.href;
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

});

$.urlParam = function(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	return results[1] || 0;
}