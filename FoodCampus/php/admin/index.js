$(document).ready(function(){

    var url = window.location.href;
    if(url.search("manage-database") != -1) {
        console.log(url.search("manage-database"));
        $("#managerDB a").addClass("active");
    } else {
        if(url.search("enable-supplier") != -1) {
            $("#enableSupplier a").addClass("active");
        } else {
            if(url.search("blocked-supplier") != -1) {
                $("#blockedSupplier a").addClass("active");
            } else {
                if(url.search("blocked-customer") != -1) {
                    $("#blockedCustomer a").addClass("active");
                }
            }   
        }
    }

	$("#managerDB").click(function(){
	});

	$(".enable-button").click(function(){
		ajaxGetRequest("esito", "enable-request.php?supplier=" + $(this).val(), $(this).val());
	});

	$(".unlock-customer-button").click(function(){
		ajaxGetRequest("esito", "unlock-customer-request.php?customer=" + $(this).val(), $(this).val());
	});

    $(".unlock-supplier-button").click(function(){
        ajaxGetRequest("esito", "unlock-supplier-request.php?supplier=" + $(this).val(), $(this).val());
    });

});

function ajaxGetRequest(elementName, url, id) {
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
            var s = "#" + id;
            $(s).hide();
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

