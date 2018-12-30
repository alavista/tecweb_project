function loadCategories() {
    $.post("products_research.php", {request:"categorie"} , function (result) {
        /*$.each(result, function(i, field) {
            $("div").append(field + " ");
        });*/
        console.log("fatto");
    });
}

$(document).ready(function() {
    loadCategories();
});
