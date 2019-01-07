var sorting = "Voto Fornitore (decrescente)";

function loadSuppliers() {

    $(".noresult").remove();
    $(".suppliers_error").remove();
    $("#result_content").hide();

    $.post("suppliers_research.php", {request:"suppliers", category:"category", vegan:$("#vegan_checkbox").is(':checked'), celiac:$("#celiac_checkbox").is(':checked'), sort:sorting})
        .done(function(data) {
            var suppliers = JSON.parse(data);
            if (suppliers.status.localeCompare("error") == 0) {
                $("#result_content").append("<div class='suppliers_error alert alert-danger' style='margin-top: 8px;text-align: center;'><strong>Errore: </strong>"
                                                +suppliers.data+"</div>");
            } else if (suppliers.status.localeCompare("ok") == 0) {

                if (suppliers.data.length === 0) {
                    $("#result_content").append("<div class='noresult'>Nessun fornitore trovato con i parametri di ricerca forniti</div>");
                    $(".noresult").hide().fadeIn(250);
                } else {
                    var html_code = "";
                    for(var i = 0; i < suppliers.data.length; i++) {
                    	html_code += "<div style='margin-bottom: 35px'><a href=/tecweb_project/FoodCampus/php/suppliers/php/supplier.php?id="
                        + suppliers.data[i]["IDFornitore"] + ">"
                        + suppliers.data[i]["fnome"]
                        + "<img id='image" + i + "' class='zoom img-fluid img-thumbnail img-responsive' alt='' src='../../res/suppliers/" + (suppliers.data[i]["fimmagine"] != null ? suppliers.data[i]["fimmagine"] : 'default.jpg') + "'>" + "</a>"
                        + "<div id='starAverageRating" +  i  +"'><input class='rating rating-loading' data-min='0' data-max='5' data-step='1' value='" + suppliers.data[i]["valutazione_media"] + "' data-size='lg' data-showcaption=false disabled/></div>"
                        + "<p id='averageRating" + i + "'><strong>" + suppliers.data[i]["valutazione_media"] + "</strong> su 5 stelle (" + suppliers.data[i]["nrec"] + " voti)</p>"
                        + "</div>";
                    }

                    loadStars();

                    $("#result_content").html(html_code).fadeIn(250);

                    /*$("html, body").animate({
                        scrollTop: $("table").offset().top
                    }, 1000);*/
                }
            }
        })
        .fail(function(xhr, textStatus, errorThrown) {
            $("#result_content").html("<div class='alert alert-danger' style='margin-top: 8px;'><strong>ATTENZIONE:</strong>"
                                        + xhr.responseText + "</div>");
        });
}

$(document).ready(function() {

    loadSuppliers();

    $("#sort_selection").on('change', function() {
        sorting = $(this).val();
		loadSuppliers();
	});

    $('#vegan_checkbox').on('change', function() {
		loadSuppliers();
	});

    $('#celiac_checkbox').on('change', function() {
		loadSuppliers();
	});

});
