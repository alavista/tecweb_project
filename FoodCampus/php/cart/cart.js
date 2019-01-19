
	$(document).on("click", ".add-cart", function(e){
		$.ajax({
			type: "GET",
			url: "/tecweb_project/FoodCampus/php/cart/add-product.php?product_added=" + e.target.id + "&quantity=1",
			processData: true,
            contentType: true,
			success: function(msg)
			{
				var data = jQuery.parseJSON(msg);
				console.log(data['num_prod']);
			},
			error: function()
			{
				console.log("chiamata ajax fallita");
			}
		});
	});

