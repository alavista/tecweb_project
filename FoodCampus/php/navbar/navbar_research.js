function searchProductsAndSuppliers(str) {

    $(".list-group-item.link-class").remove();

    $.post("/tecweb_project/FoodCampus/php/navbar/navbar_research.php", {request:"suppliers", string:str})
        .done(function(data) {

            var products = JSON.parse(data);

            if (products.status.localeCompare("error") == 0) {
                //Errore
            } else if (products.status.localeCompare("ok") == 0) {

                if (products.data.length === 0) {
                    //No results
                } else {
                    for (var i = 0; i < products.data.length; i++){
                        $("#result").append("<li class='list-group-item link-class'><a href=/tecweb_project/FoodCampus/php/user/suppliers/php/supplier.php?id=" + products.data[i]["fid"] +">" + products.data[i]["fnome"] + "</li>");
                    }
                }
            }
    })
    .fail(function(xhr, textStatus, errorThrown) {
        //xhr.responseText
    });

    $.post("/tecweb_project/FoodCampus/php/navbar/navbar_research.php", {request:"products", string:str})
        .done(function(data) {

            var products = JSON.parse(data);

            if (products.status.localeCompare("error") == 0) {
                //Errore
            } else if (products.status.localeCompare("ok") == 0) {

                if (products.data.length === 0) {
                    //No results
                } else {
                    for (var i = 0; i < products.data.length; i++){
                        $('#result').append('<li class="list-group-item link-class"><span>'
                                                + products.data[i]["pnome"] + " "
                                                + ((products.data[i]["vegano"] === 1) ? " (vegano) " : "")
                                                + ((products.data[i]["celiaco"] === 1) ? " (no glutine) " : "")
                                                + "</span>"
                                                + "<span>"
                                                + "€ " + products.data[i]["prezzo"] + " "
                                                + "</span>"
                                                + "<span>"
                                                + products.data[i]["fnome"] + " "
                                                + "</span>"
                                                + "<span data-toggle='popover' data-trigger='hover' data-content='I fornitori non possono acquistare'> <button type='button' class='btn btn-deafult btn-kart'><i class='fas fa-cart-plus'></i></button></span>"
                                                + "</li>");
                    }

                    if (products.isSupplier) {
                        //$("span").popover({ trigger: "hover" }).data("I Fornitori non possono comprare");
                        $(".btn-kart").prop("disabled",true);
                        $(".btn-kart").css("pointer-events", "none");
                    }
                }
            }
    })
    .fail(function(xhr, textStatus, errorThrown) {
        //xhr.responseText
    });
}

$(document).ready(function() {
    $("#navbar-search").on("keyup", function() {
		searchProductsAndSuppliers(this.value);
	});
});
