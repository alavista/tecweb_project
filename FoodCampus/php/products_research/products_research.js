function searchProducts(category) {
    $("#resultsField > div > h2").removeAttr("hidden");
    $("#resultsField > div > h2~:not(table, table *)").remove();
    $("table").hide();

    $.post("products_research.php", {reqest:"products", value:category})
        .done(function(data) {
            var products = JSON.parse(data);

            if (products.status.localeCompare("error") == 0) {
                $("#categoryField").append("<div class='alert alert-danger' style='margin-top: 8px;text-align: center;'><strong>Errore: </strong>"
                                                +products.data+"</div>");
            } else if (products.status.localeCompare("ok") == 0) {

                $("table").removeAttr("hidden");

                if (products.data.length === 0) {
                    $("#resultsField > div > :not(h2)").hide();
                    $("#resultsField > div").append("<div class='noresult'>Nessun prodotto trovato nella categoria " + category + "</div>");
                    $(".noresult").hide().fadeIn(250);
                } else {
                    var html_code = "";
                    for(var i = 0; i < products.data.length; i++){
                    	html_code += '<tr><td>'+products.data[i]["pnome"]+'</td><td>'+products.data[i]["cnome"]
                                                            +'</td><td>'+"€ " + products.data[i]["costo"]+'</td><td>'+products.data[i]["fnome"]
                                                            +'</td><td>'+((products.data[i]["valutazione_media"] === null) ? "/" : products.data[i]["valutazione_media"])
                                                            +'</td><td>'+products.data[i]["nrec"]
                                                            +'</td></tr>';
                    }
                    $("table tbody").html(html_code);
                    $("#resultsField >  div :not(h2)").fadeIn(250);
                }
            }
        })
        .fail(function(xhr, textStatus, errorThrown) {
            $("#categoryField").html("<div class='alert alert-danger' style='margin-top: 8px;'><strong>ATTENZIONE:</strong>"
                                        + xhr.responseText + "</div>");
        });
}

function loadCategories() {
    $.post("products_research.php", {reqest:"categories"})
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
            }
        })
        .fail(function(xhr, textStatus, errorThrown) {
            $("#categoryField").html("<div class='alert alert-danger' style='margin-top: 8px;'><strong>ATTENZIONE:</strong>"
                                        + xhr.responseText + "</div>");
        });
}

$(document).ready(function() {
    loadCategories();
});
