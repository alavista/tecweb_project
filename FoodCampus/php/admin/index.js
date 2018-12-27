$(document).ready(function(){

    var url = window.location.href;
    if(url.search("manage-database") != -1) {
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

	$(".table-request-button").click(function(){
        $(".table-request-button").removeClass("active");
        $(this).addClass("active");
        console.log("db-table-request.php?table=" + $(this).val());
        ajaxGetRequestTable("result", "db-table-request.php?table=" + $(this).val());
	});

	$(".enable-button").click(function(){
		ajaxGetRequestAdminOperation("result", "enable-request.php?supplier=" + $(this).val(), $(this).val());
	});

	$(".unlock-customer-button").click(function(){
		ajaxGetRequestAdminOperation("result", "unlock-customer-request.php?customer=" + $(this).val(), $(this).val());
	});

    $(".unlock-supplier-button").click(function(){
        ajaxGetRequestAdminOperation("result", "unlock-supplier-request.php?supplier=" + $(this).val(), $(this).val());
    });

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
            document.getElementById(elementName).innerHTML = this.responseText;
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

