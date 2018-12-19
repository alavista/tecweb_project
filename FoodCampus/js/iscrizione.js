$(document).ready(function() {
    setCheckInputsHandler();
    checkPasswords();
    setAccountSelectHandler();
    checkAccountSelect($("#sel").val());
});

function setCheckInputsHandler(){
    $("#submitbtn").on("click", function() {

        var valid = true;
        var inputFields = new Array();

        $(":input[required]:visible").each(function() {
            var elem = $(this);

            if(elem.val() === "") {
                inputFields.push(elem);
                valid = false;
                if (elem.next(".validation").length === 0) {
                    elem.after("<div class='text-danger validation'>Questo campo è obbligatorio</div>");
                }
            }
            else {
                elem.next(".validation").remove();
            }
        });

        if(!valid) {
            $("html, body").animate({
                scrollTop: inputFields[0].offset().top - 200
            }, 9);
        }
    });
}

function setAccountSelectHandler(){
    $('#sel').on('change', function() {
		checkAccountSelect(this.value);
	});
}

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

function checkPasswords() {
    $("#submitbtn").on("click", function() {
        var pwdconfirm = $("#confirm-pwd");

        if ($("#pwd").val() !== pwdconfirm.val() && pwdconfirm.val() !== "" && $("#pwd").val() !== "") {
            if ($("#alertpwd").length === 0) {
                pwdconfirm.after("<div id='alertpwd' class='alert alert-danger' style='margin-top: 8px;'>Le password non sono uguali</div>");
            }
            return false;
        }
        else{
            $("#alertpwd").remove();
        }
    });
}