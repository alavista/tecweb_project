$(function() {
    $("#submitReview").click(function() {
        var clientEmail = $.cookie("user_email");
        if (!clientEmail) {
            window.location = "login.php";
        }
        var valutationReview = $("#valutationReview").val();
        var commentReview = $("#commentReview").val();
        var titleReview = $("#titleReview").val();
        var idSupplier = getIdSupplier();
        var inputWithfocus = false;
        $(":input[required]").each(function() {
            var elem = $(this);
            showOrRemoveError(elem, STANDARD_ERROR_MESSAGGE);
            if (((elem.val() === "" && elem.next(".validation").length != 0) ||
                    (elem.val() === "" && elem.next(".validation").length == 0)) && !inputWithfocus) {
                elem.focus();
                inputWithfocus = true;
            }
        });

        //commentReview.trim() check that the string is not empty or contains only withspace
        if (valutationReview >= 0 && commentReview.trim() && titleReview.trim() && idSupplier >= 0) {
            $.post("../php/addReview.php", {
                idSupplier: idSupplier,
                clientEmail: clientEmail,
                title: titleReview,
                comment: commentReview,
                valutation: valutationReview
            }, function(data, status) {
                data = JSON.parse(data);
                if (data.status.localeCompare("ERROR") == 0) {
                    managmentGeneralError($("#newReview"), data.inf);
                } else if (data.status.localeCompare("OK") == 0) {
                    $("#commentReview").val("");
                    $("#titleReview").val("");
                    $("#numberReview").html(data.numberReview);
                    $("#starAverageRating").html("");
                    $("#starAverageRating").html("<input class='rating rating-loading' data-min='0' data-max='5' data-step='1' value='" + data.averageRating + "' data-size='lg' data-showcaption=false disabled/>");
                    $("#averageRating").html(data.averageRating + " su 5 stelle");
                    if ($("#dividerFromReviews").hasClass("notVisible")) {
                        $("#dividerFromReviews").removeClass("notVisible");
                    }
                    $("#mediasReviews").append(data.newReview);
                    loadStars();
                }
            });
        }
    });
});
