$(function() {
    $("#newSupplierVatNumber").hide();

    $("#changeVatNumber").click(function() {
        $("#newVatNumber").val($("#vatNumber").html());
        switchFromDivToDiv("userName", "newSupplierVatNumber");
    });

    $("#saveVatNumber").click(function() {
        var vatNumber = $("#newVatNumber").val();
        $("#vatNumberError").html("");
        if ($.isNumeric(vatNumber)) {
            vatNumber = parseInt(vatNumber);
            if (vatNumber >= 0 && digits_count(vatNumber) == 11) {
                $.post("../php/changeVatNumber.php", {
                    idSupplier: getId(),
                    vatNumber: vatNumber
                }, function(data, status) {
                    data = JSON.parse(data);
                    if (data.status.localeCompare("ERROR") == 0) {
                        managmentVatNumberError(data.inf);
                    } else if (data.status.localeCompare("OK") == 0) {
                        $("#vatNumber").html($("#newVatNumber").val());
                        $("#vatNumberError").html("");
                        switchFromDivToDiv("newSupplierVatNumber", "userName");
                    }
                });
            } else {
                managmentVatNumberError("partitaIvaNonCorretta");
            }
        } else {
            managmentVatNumberError("partitaIvaNonCorretta");
        }
    });

    $("#cancelChangeVatNumber").click(function() {
        $("#vatNumberError").html("");
        switchFromDivToDiv("newSupplierVatNumber", "userName");
    });

});

function managmentVatNumberError(error) {
    switch (error) {
        case "partitaIvaNonCorretta":
            $("#vatNumberError").html("<div class='text-danger validation'><i class='fas fa-times'> Devi inserire un numero composto da 11 cifre!</i></div>");
            $("#newVatNumber").focus();
            break;
        case "parametriNonCorretti":
            $("#vatNumberError").html("<div class='text-danger validation'><i class='fas fa-times'> Parametri non corretti!</i></div>");
            break;
        case "errore":
            $("#vatNumberError").html("<div class='text-danger validation'><i class='fas fa-times'> Errore. Riprova più tardi!</i></div>");
            break;
        default:
            $("#vatNumberError").html("<div class='text-danger validation'><i class='fas fa-times'> Errore. Riprova più tardi!</i></div>");
            break;
    }
}

function digits_count(n) {
    var count = 0;
    if (n >= 1){
        ++count;
    }
    while (n / 10 >= 1) {
        n /= 10;
        ++count;
    }
    return count;
}
