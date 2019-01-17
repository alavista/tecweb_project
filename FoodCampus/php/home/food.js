$(function() {
    $("#pizza").click(function() {
        setFoodSession("pizza")
    });

    $("#sandwich").click(function() {
        setFoodSession("sandwich")
    });

    $("#piada").click(function() {
        setFoodSession("piada")
    });

    $("#sushi").click(function() {
        setFoodSession("sushi")
    });

    $("#firstDish").click(function() {
        setFoodSession("firstDish")
    });

    $("#secondDish").click(function() {
        setFoodSession("secondDish")
    });

    $("#sweet").click(function() {
        setFoodSession("sweet")
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
