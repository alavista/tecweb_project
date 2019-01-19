function searchProductsAndSuppliers(str) {

    $(".list-group-item.link-class").remove();

    $.post("/tecweb_project/FoodCampus/php/navbar/navbar_research.php", {request:"suppliers", string:str})
        .done(function(data) {

            var suppliers = JSON.parse(data);

            if (suppliers.status.localeCompare("error") == 0) {
                //Errore
            } else if (suppliers.status.localeCompare("ok") == 0) {

                if (suppliers.data.length === 0) {
                    //No results
                } else {
                    for (var i = 0; i < suppliers.data.length; i++) {
                        $("#result").append("<li class='list-group-item link-class'><div class='row'><div class='col search-item'><a style='font-size: 1.3rem' href=/tecweb_project/FoodCampus/php/user/suppliers/php/supplier.php?id=" + suppliers.data[i]["fid"] +"><strong>" + suppliers.data[i]["fnome"] + "</strong></a></div>"
                        + "<div class='col search-review'>"
                        + "<div id='starAverageRating" +  i  +"'><input class='rating rating-loading' data-min='0' data-max='5' data-step='1' value='" + ((suppliers.data[i]["valutazione_media"] === null) ? 0.0 : suppliers.data[i]["valutazione_media"].toFixed(1)) + "' data-size='lg' data-showcaption=false disabled/></div>"
                        + "<p id='averageRating" + i + "'><strong>" + ((suppliers.data[i]["valutazione_media"] === null) ? "/" : suppliers.data[i]["valutazione_media"].toFixed(1)) + "</strong> su 5 stelle</p>"
                        + "</div></div></li>");
                    }
                    loadStars();
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
                        $('#result').append('<li class="list-group-item link-class"><div class="row"><div class="col-5"><p style="font-size: 1.2rem" class="p-list list-group-item-heading">'
                                                + products.data[i]["pnome"] + "<br/>"
                                                + ((products.data[i]["vegano"] === 1) ? " (vegano) " : "")
                                                + ((products.data[i]["celiaco"] === 1) ? " (no glutine) " : "")
                                                + "</p>"
                                                + "<a href='/tecweb_project/FoodCampus/php/user/suppliers/php/supplier.php?id=" + products.data[i]["fid"] + "' class='list-group-item-text'>"
                                                + products.data[i]["fnome"] + " "
<<<<<<< HEAD
                                                + "</span>"
                                                + "<span data-toggle='popover' data-trigger='hover' data-content='I fornitori non possono acquistare'> <button type='button' id ="+products.data[i]["IDProdotto"]+" class='btn btn-deafult btn-kart add-cart'><i class='fas fa-cart-plus'></i></button></span>"
                                                + "</li>");
=======
                                                + "</a></div>"
                                                + "<div class='col search-item' style='font-size: 1.2rem'>"
                                                + "<strong>€ " + products.data[i]["prezzo"] + "</strong> "
                                                + "</div>"
                                                + "<div class='col search-btn'><span style='float: right' data-toggle='popover' data-trigger='hover' data-content='I fornitori non possono acquistare'> <button type='button' id='" + products.data[i]["pid"] + "' class='add-cart btn btn-deafult btn-kart'><i class='fas fa-cart-plus'></i></button></span>"
                                                + "</div>"
                                                + "</div></li>");
>>>>>>> e063e2b51a6f5e6d19953b3b9aeb5cbf0b75f99a
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

function checkFocus() {
    $(".list-group-item.link-class").remove();
}

$(document).ready(function() {
    $("#navbar-search").on("keyup", function() {
		searchProductsAndSuppliers(this.value);
	});

    $(document).click(function(e) {
        var container = $(".searchit");

        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            $(".list-group-item.link-class").remove();
        }
    });
});
