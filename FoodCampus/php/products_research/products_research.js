var sorting = "Voto Fornitore (decrescente)";
var currentCategory="";

function searchProducts(category) {

    currentCategory = category;

    $("#resultsField  h2, .form-group").removeAttr("hidden");
    $(".noresult").remove();
    $(".category_error").remove();
    $("#result_content").hide();

    $.post("products_research.php", {request:"products", category:category, vegan:$("#vegan_checkbox").is(':checked'), celiac:$("#celiac_checkbox").is(':checked'), sort:sorting})
        .done(function(data) {

            var products = JSON.parse(data);

            if (products.status.localeCompare("error") == 0) {
                $("#categoryField").append("<div class='category_error alert alert-danger' style='margin-top: 8px;text-align: center;'><strong>Errore: </strong>"
                                                +products.data+"</div>");
            } else if (products.status.localeCompare("ok") == 0) {

                $("table").removeAttr("hidden");
                $("#result_content").removeAttr("hidden");

                if (products.data.length === 0) {
                    $("#result_content").hide();
                    $("#resultsField > div").append("<div class='noresult'>Nessun prodotto trovato nella categoria " + category + "</div>");
                    $(".noresult").hide().fadeIn(250);
                } else {
                    var html_code = "";
                    for(var i = 0; i < products.data.length; i++){
                    	html_code += '<tr><td>'+products.data[i]["pnome"]
                                                            +'</td><td>'+"€ " + products.data[i]["costo"]+'</td><td><a href=/tecweb_project/FoodCampus/php/suppliers/php/supplier.php?id='+products.data[i]["IDFornitore"]+'>'+products.data[i]["fnome"]
                                                            +"</a></td><td>"+((products.data[i]["valutazione_media"] === null) ? "/" : "<strong>"+products.data[i]["valutazione_media"]+"</strong><br/>"+" ("+products.data[i]["nrec"]+" voto/i)")
                                                            +"<td><span data-toggle='popover' data-trigger='hover' data-content='I fornitori non possono acquistare'> <button type='button' class='btn btn-deafult btn-kart'><i class='fas fa-cart-plus'></i></button></span>"
                                                            +'</td></tr>';
                    }

                    $("table tbody").html(html_code);

                    if (products.isSupplier) {
                        $("span").popover({ trigger: "hover" }).data("I Fornitori non possono comprare");
                        $(".btn-kart").prop("disabled",true);
                        $(".btn-kart").css("pointer-events", "none");
                    }

                    $("#result_content").fadeIn(250);

                    /*$("html, body").animate({
                        scrollTop: $("table").offset().top
                    }, 1000);*/
                }
            }
        })
        .fail(function(xhr, textStatus, errorThrown) {
            $("#categoryField").html("<div class='alert alert-danger' style='margin-top: 8px;'><strong>ATTENZIONE:</strong>"
                                        + xhr.responseText + "</div>");
        });
}

function loadCategories() {
    $.post("products_research.php", {request:"categories"})
        .done(function(data) {

            var categories = JSON.parse(data);

            if (categories.status.localeCompare("error") == 0) {
                $("#categoryField").append("<div class='alert alert-danger' style='margin-top: 8px;text-align: center;'><strong>Errore: </strong>"
                                                +categories.data+"</div>");
            } else if (categories.status.localeCompare("ok") == 0) {
                $.each(categories.data, function(i) {
                    $("#categoryField").append("<button type='submit' id='" + categories.data[i].nome
                                                + "' class='category-btn btn btn-primary btn-lg'>" + categories.data[i].nome + "</button>");
                    $("#" + categories.data[i].nome).click(function() {
                        searchProducts($("#" + categories.data[i].nome).text());
                    });
                });

                $(".category-btn").focus(function() {
                    $(".category-btn").removeClass("btn-danger");
                    $(".category-btn").addClass("btn-primary");
                    $(this).removeClass("btn-primary");
                    $(this).addClass("btn-danger");
            	});
            }
        })
        .fail(function(xhr, textStatus, errorThrown) {
            $("#categoryField").html("<div class='alert alert-danger' style='margin-top: 8px;'><strong>ATTENZIONE:</strong>"
                                        + xhr.responseText + "</div>");
        });
}

$(document).ready(function() {
    loadCategories();

    $("#sort_selection").on('change', function() {
        sorting = $(this).val();
		searchProducts(currentCategory);
	});

    $('#vegan_checkbox').on('change', function() {
		searchProducts(currentCategory);
	});

    $('#celiac_checkbox').on('change', function() {
		searchProducts(currentCategory);
	});

});
