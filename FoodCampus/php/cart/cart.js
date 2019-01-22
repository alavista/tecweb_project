$(document).on("click", ".add-cart", function(e){
	$.ajax({
		type: "GET",
		url: "/tecweb_project/FoodCampus/php/cart/add-product.php?product_added=" + e.target.id + "&quantity=1",
		processData: true,
        contentType: true,
		success: function(msg)
		{
			var data = jQuery.parseJSON(msg);
			$("#prod-num").text(data['num_prod']);
		},
		error: function()
		{
			console.log("chiamata ajax fallita");
		}
	});
});

function refresh_product_number() {
	var num_prod = 0;
	$(".quantity-input").each(function() {
		num_prod = num_prod + parseInt($(this).val(), 10); 
	});
	$("#prod-num").text(num_prod);
}

$(document).ready(function(){
	$(".quantity-input").change(function() {
		if($.isNumeric($(this).val())) {
			$(".buy-button").removeClass("disabled");
			$id = $(this).attr('product');
			$.ajax({
				type: "GET",
				url: "change-quantity-product.php?product=" + $id + "&quantity=" + $(this).val(),
				processData: true,
		        contentType: true,
				success: function(msg)
				{
					refresh_product_number();
				},
				error: function()
				{
					console.log("chiamata ajax fallita");
				}
			});
		} else {
			$(".buy-button").addClass("disabled");
		}
	});

	$(".remove-product").click(function(e){
		$id = $(this).val(); 
		$.ajax({
			type: "GET",
			url: "remove-product.php?product_removed=" + $id,
			processData: true,
	        contentType: true,
			success: function(msg)
			{
				var data = jQuery.parseJSON(msg);
				if(data['empty_cart'] == true) {
					window.location.href = "../home/home.php";
				}
				$("#"+$id).fadeOut();
				$("#"+$id+" .quantity-input").val(0);
				refresh_product_number();
			},
			error: function()
			{
				console.log("chiamata ajax fallita");
			}
		});
	});

}); 
