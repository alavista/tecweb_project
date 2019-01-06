$(document).ready(function(){

	$(".table-request-button").click(function(){
        $(".table-request-button").removeClass("active");
        $(this).addClass("active");
        $("#result").empty();
        $("#result-op").empty();
        ajaxGetRequestTable("result", "php/db-table-request.php?table=" + $(this).val());
	});

	$(".enable-supplier-button").click(function(){
		ajaxGetRequestAdminOperation("result", "php/enable-supplier-request.php?supplier=" + $(this).val(), $(this).val());
	});

	$(".unlock-customer-button").click(function(){
		ajaxGetRequestAdminOperation("result", "php/unlock-customer-request.php?customer=" + $(this).val(), $(this).val());
	});

    $(".unlock-supplier-button").click(function(){
        ajaxGetRequestAdminOperation("result", "php/unlock-supplier-request.php?supplier=" + $(this).val(), $(this).val());
    });

});

$(document).on("click", ".delete-row-button", function() {
    ajaxGetRequestAdminOperation("result-op", "php/delete-table-row.php?table=" + $(".btn-group-vertical > .active").val() + "&id=" + $(this).val(), $(this).val());  
});

function ajaxGetRequestTable(elementName, url) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $("#result").append(this.responseText);
            //document.getElementById(elementName).innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function ajaxGetRequestAdminOperation(elementName, url, id) {
	if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 400)) {
            document.getElementById(elementName).innerHTML = this.responseText;
        }
        if(this.status == 200) {
            var s = "#" + id;
            $(s).hide();
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

