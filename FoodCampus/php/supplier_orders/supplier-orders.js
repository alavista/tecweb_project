$(document).ready(function() {

	$(".deliver-order").click(function(e) {
		$this = $(this);
		console.log("deliver-order.php?id=" + $(this).attr("value"));
		$.ajax({
			type: "GET",
			url: "deliver-order.php?id=" + $(this).attr("value"),
			processData: true,
	        contentType: true,
			success: function(msg)
			{
				$this.removeClass("btn-primary");
				$this.removeClass("deliver-order");
				$this.text("Consegnato");
				$this.addClass("disabled");
				$this.addClass("btn-success");
			},
			error: function()
			{
				console.log("errore consegna ordine");
			}
		});
	});
});