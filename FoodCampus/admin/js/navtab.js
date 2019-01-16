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
});