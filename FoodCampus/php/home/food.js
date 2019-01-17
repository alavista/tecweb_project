$(function() {
    $("#pizza").click(function() {
        setFoodSession("Pizza")
    });

    $("#sandwich").click(function() {
        setFoodSession("Panino")
    });

    $("#piada").click(function() {
        setFoodSession("Piada")
    });

    $("#sushi").click(function() {
        setFoodSession("Sushi")
    });

    $("#firstDish").click(function() {
        setFoodSession("Primo")
    });

    $("#secondDish").click(function() {
        setFoodSession("Secondo")
    });

    $("#sweet").click(function() {
        setFoodSession("Dolce")
    });
});

function setFoodSession(food) {
    $.post("setFoodSession.php", {
        food: food
    }, function(data, status) {
        console.log(data);
        data = JSON.parse(data);
        if (data.status.localeCompare("OK") == 0) {
            window.location = "../products_research/products_research_index.php";
        } else {
            showError($("#carouselError"), "Errore. Riprova più tardi!");
        }
    });
}
