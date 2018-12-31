function searchProducts(category) {
    $.post("products_research.php", {reqest:"products", value:category})
        .done(function(data) {
            console.log(data);
            var categories = JSON.parse(data);
            console.log(categories);
            /*$.each(categories, function(i) {
                $("#categoryField").append("<button type='submit' id='" + categories[i].nome
                                            + "' class='btn btn-primary btn-lg'>" + categories[i].nome + "</button>");
                $("#" + categories[i].nome).click(function() {
                    searchProducts($("#" + categories[i].nome).text());
                });
            });*/
        })
        .fail( function(xhr, textStatus, errorThrown) {
            $("#categoryField").html("<div class='alert alert-danger' style='margin-top: 8px;'><strong>ATTENZIONE:</strong>"
                                        + xhr.responseText + "</div>");
        });
}

function loadCategories() {
    $.post("products_research.php", {reqest:"categories"})
        .done(function(data) {
            var categories = JSON.parse(data);

            $.each(categories, function(i) {
                $("#categoryField").append("<button type='submit' id='" + categories[i].nome
                                            + "' class='btn btn-primary btn-lg'>" + categories[i].nome + "</button>");
                $("#" + categories[i].nome).click(function() {
                    searchProducts($("#" + categories[i].nome).text());
                });
            });
        })
        .fail( function(xhr, textStatus, errorThrown) {
            $("#categoryField").html("<div class='alert alert-danger' style='margin-top: 8px;'><strong>ATTENZIONE:</strong>"
                                        + xhr.responseText + "</div>");
        });
}

$(document).ready(function() {
    loadCategories();
});
