function checkAccountSelect(option){
	var inputElements = $("#form-fornitore, #form-fornitore > *");

	if (option == "Cliente") {
		$("#form-fornitore input").each(function(){
			$(this).prop("required", false);
		});

		inputElements.fadeOut();

		$("#ClientBasic, #ClientBasic *").each(function(){
			$(this).prop("required", true);
		});
		$("#ClientBasic").fadeIn();
	}
	else {
		$("#form-fornitore  input").each(function(){
			$(this).prop("required", true);
		});

		$("#sitoweb").prop("required", false);
		inputElements.fadeIn();

		$("#ClientBasic, #ClientBasic *").each(function(){
			$(this).prop("required", false);
		});
		$("#ClientBasic").fadeOut();
	}
}

$(document).ready(function() {
    $('#sel').on('change', function() {
		checkAccountSelect(this.value);
	});

    checkAccountSelect($("#sel").val());
});
