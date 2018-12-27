function checkAccountSelect(option){
	var inputElements = $("#form-fornitore, #form-fornitore > *");

	if (option == "Cliente") {
		$("#form-fornitore input").each(function(){
			$(this).prop("required", false);
		});

		inputElements.fadeOut();
	}
	else {
		$("#form-fornitore  input").each(function(){
			$(this).prop("required", true);
		});

		$("#sitoweb").prop("required", false);
		inputElements.fadeIn();
	}
}

$(document).ready(function() {
    $('#sel').on('change', function() {
		checkAccountSelect(this.value);
	});

    checkAccountSelect($("#sel").val());
});
