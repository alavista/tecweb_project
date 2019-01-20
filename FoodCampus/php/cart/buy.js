$(document).ready(function() {

	$("form").on("submit", function(e) {
		e.preventDefault();

		var time = $("input[name=delivery-time]").val().split(':');
		var generalParam = "&customer=" + $("#IDCustomer").attr("value") +
			"&payment=" + $("input[name='payment-method']:checked").val() +
			"&hour=" + time[0] + 
			"&minute=" + time[1];

		$(".order-table").each(function(){
			
			var orderParam = "?products=";
			$(this).children("tbody").children(".product-row").each(function(){
				orderParam += $(this).attr("id")+",";
			});
			orderParam = orderParam.slice(0,-1);
			orderParam += "&quantities=";
			$(this).children("tbody").children(".product-row").each(function(){
				orderParam += $(this).parent().children("tr").children(".quantity").attr("value")+",";
			});
			orderParam = orderParam.slice(0,-1);
			orderParam += "&supplier=" + $(this).attr("id");

			console.log("request-order.php" + orderParam + generalParam);

			$.ajax({
				type: "GET",
				url: "request-order.php" + orderParam + generalParam,
				processData: true,
		        contentType: true,
				success: function(msg)
				{
					window.location.href = "../home/home.php?order_success=1";
				},
				error: function()
				{
					console.log("errore comletamento ordine");
					$("#result-order-request").append("<div class='alert alert-danger' role='alert'>Ordine non completato con successo</div>");
				}
			});
		});
		
	});

});