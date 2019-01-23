var sorting = "Voto Fornitore (decrescente)";
var checkboxes = new Array();

function setCheckBoxes() {
    for (var i = 0; i < checkboxes.length; i++) {
        $("#" + checkboxes[i].id).prop('checked', checkboxes[i].checked);
    }
}

function saveCheckBoxes() {

    var checkbox = {};
    checkboxes = new Array();

    $(".modal-checkbox").each(function(index) {
        checkbox.id = $(this).attr('id');
        checkbox.checked = $(this).is(':checked');
        checkboxes.push(checkbox);
        checkbox = {};
    });
}

function getRequiredCategories() {

    var checkboxes = $(".modal-checkbox");

    var requiredCategories = new Array();
    checkboxes.each(function(index) {
        if ($(this).is(':checked')) {
            requiredCategories.push(($(this).next("label").text()));
        }
    });

    return requiredCategories;
}

function loadSuppliers() {

    $(".noresult").remove();
    $(".suppliers_error").remove();
    $("#result_content").hide();

    var requiredCategories = getRequiredCategories();

    $.post("suppliers_research.php", {request:"suppliers", category:((requiredCategories != "") ? requiredCategories : "none"), vegan:$("#vegan_checkbox").is(':checked'), celiac:$("#celiac_checkbox").is(':checked'), sort:sorting})
        .done(function(data) {
            var suppliers = JSON.parse(data);
            if (suppliers.status.localeCompare("error") == 0) {
                $("#result_content").append("<div class='suppliers_error alert alert-danger'><strong>Errore: </strong>"
                                                +suppliers.data+"</div>");
            } else if (suppliers.status.localeCompare("ok") == 0) {

                if (suppliers.data.length === 0) {
                    $("#result_content").html("<div class='noresult'>Nessun fornitore trovato con i parametri di ricerca forniti</div>").fadeIn(250);
                } else {
                    var html_code = "";
                    for(var i = 0; i < suppliers.data.length; i++) {
                    	html_code += "<div class='suppliersInfoStyle'><a href=../user/suppliers/php/supplier.php?id="
                        + suppliers.data[i]["IDFornitore"] + ">"
                        + suppliers.data[i]["fnome"]
                        + "<img id='image" + i + "' class='zoom img-fluid img-thumbnail img-responsive' alt='Foto profilo del fornitore' src='../../res/suppliers/" + (suppliers.data[i]["fimmagine"] != null ? suppliers.data[i]["fimmagine"] : 'default.jpg') + "'>" + "</a>"
                        + "<div id='starAverageRating" +  i  +"'><label for='voto" + i +"' class='hidden'>Stelle voto fornitore</label><input input id='voto" + i + "' class='rating rating-loading' data-min='0' data-max='5' data-step='1' value='" + ((suppliers.data[i]["valutazione_media"] === null) ? 0.0 : suppliers.data[i]["valutazione_media"].toFixed(1)) + "' data-size='lg' data-showcaption=false disabled/></div>"
                        + "<p id='averageRating" + i + "'><span class='resultReviewValue'>" + ((suppliers.data[i]["valutazione_media"] === null) ? "/" : suppliers.data[i]["valutazione_media"].toFixed(1)) + "</span> su 5 stelle (" + suppliers.data[i]["nrec"] + " voti)</p>"
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
            $("#result_content").html("<div class='alert alert-danger errorElement'><strong>ATTENZIONE:</strong>"
                                        + xhr.responseText + "</div>");
        });
}

$(document).ready(function() {

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

    $("#outAllButton").on("click", function() {
		$(".modal-checkbox").prop('checked', false);
	});

    $("#selectAllButton").on("click", function() {
		$(".modal-checkbox").prop('checked', true);
	});

    $("#savebutton").on("click", function() {
        saveCheckBoxes();
        loadSuppliers();
	});

    $("#myModal").on("hidden.bs.modal", function () {
        setCheckBoxes();
    });

    saveCheckBoxes();

    loadSuppliers();

});
