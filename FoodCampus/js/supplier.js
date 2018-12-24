const STANDARD_ERROR_MESSAGGE = "Questo campo è obbligatorio";

$(document).ready(function() {
    loadStars();

    $('[data-toggle="popover"]').popover();

    $("#supplierName2").hide();
    $("#supplierCity2").hide();
    $("#supplierAddress2").hide();
    $("#supplierHouseNumber2").hide();
    $("#supplierShippingCosts2").hide();
    $("#supplierWebSite2").hide();

    $("#changeName").click(function() {
        switchFromDivToDivAndSetValueTextbox("newName", "name", "supplierName1", "supplierName2");
    });

    $("#saveName").click(function() {
        checkTextUpdateSupplierInformationAndSwitchFromDivToDiv("newName", "name", "nome", "supplierName2", "supplierName1", function(inf) {
            $("#name").html(inf.toUpperCase());
        });
    });

    $("#cancelChangeName").click(function() {
        switchFromDivToDivAndRemoveError("newName", "supplierName2", "supplierName1");
    });

    $("#changeCity").click(function() {
        switchFromDivToDivAndSetValueTextbox("newCity", "city", "supplierCity1", "supplierCity2");
    });

    $("#saveCity").click(function() {
        checkTextUpdateSupplierInformationAndSwitchFromDivToDiv("newCity", "city","citta", "supplierCity2", "supplierCity1", function(inf) {
            $("#city").html(inf);
        });
    });

    $("#cancelChangeCity").click(function() {
        switchFromDivToDivAndRemoveError("newCity", "supplierCity2", "supplierCity1");
    });

    $("#changeAddress").click(function() {
        switchFromDivToDivAndSetValueTextbox("newAddress", "address", "supplierAddress1", "supplierAddress2");
    })

    $("#saveAddress").click(function() {
        checkTextUpdateSupplierInformationAndSwitchFromDivToDiv("newAddress", "address","indirizzo_via", "supplierAddress2", "supplierAddress1", function(inf) {
            $("#address").html(inf);
        });
    });

    $("#cancelChangeAddress").click(function() {
        switchFromDivToDivAndRemoveError("newAddress", "supplierAddress2", "supplierAddress1");
    });

    $("#changeHouseNumber").click(function() {
        switchFromDivToDivAndSetValueTextbox("newHouseNumber", "houseNumber", "supplierHouseNumber1", "supplierHouseNumber2");
    })

    $("#saveHouseNumber").click(function() {
        var houseNumber = $("#newHouseNumber").val();
        var error = true;
        if ($.isNumeric(houseNumber)) {
            houseNumber = parseFloat(houseNumber);
            if (Number.isInteger(houseNumber) && houseNumber >= 0) {
                error = false;
                updateSupplierInformationAndSwitchFromDivToDiv("newHouseNumber", "houseNumber", "indirizzo_numero_civico", houseNumber, "supplierHouseNumber2", "supplierHouseNumber1", function(inf) {
                    $("#houseNumber").html(inf);
                });
            }
        }
        if (error) {
            showError($("#newHouseNumber"), "Devi inserire un numero civico maggiore o uguale a 0");
            $("#newHouseNumber").focus();
        }
    });

    $("#cancelChangeHouseNumber").click(function() {
        switchFromDivToDivAndRemoveError("newHouseNumber", "supplierHouseNumber2", "supplierHouseNumber1");
    });

    $("#changeShippingCosts").click(function() {
        var shippingCosts = $("#shippingCosts").html();
        //Rimuovo lo spazio ed il simbolo "€"
        shippingCosts = shippingCosts.substring(0, shippingCosts.length - 2);
        $("#newShippingCosts").val(shippingCosts);
        switchFromDivToDiv("supplierShippingCosts1", "supplierShippingCosts2");
    })

    $("#saveShippingCosts").click(function() {
        var shippingCosts = $("#newShippingCosts").val().replace(/,/,".");
        if ($.isNumeric(shippingCosts) && shippingCosts >= 0) {
            updateSupplierInformationAndSwitchFromDivToDiv("newShippingCosts", "shippingCosts", "costi_spedizione", shippingCosts, "supplierShippingCosts2", "supplierShippingCosts1", function(inf) {
                $("#shippingCosts").html(parseFloat(inf).toFixed(2) + " €");
            });
        } else {
            showError($("#newShippingCosts"), "Devi inserire un costo di spedizione maggiore o uguale a 0");
            $("#newShippingCosts").focus();
        }
    });

    $("#cancelChangeShippingCosts").click(function() {
        switchFromDivToDivAndRemoveError("newShippingCosts", "supplierShippingCosts2", "supplierShippingCosts1");
    });

    $("#changeWebSite").click(function() {
        switchFromDivToDivAndSetValueTextbox("newWebSite", "webSite", "supplierWebSite1", "supplierWebSite2");
    })

    $("#saveWebSite").click(function() {
        checkTextUpdateSupplierInformationAndSwitchFromDivToDiv("newWebSite", "webSite", "sito_web", "supplierWebSite2", "supplierWebSite1", function(inf) {
            $("#webSite").html(inf);
        });
    });

    $("#cancelChangeWebSite").click(function() {
        switchFromDivToDivAndRemoveError("newWebSite", "supplierWebSite2", "supplierWebSite1");
    });

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
            $.post("review.php", {
                idSupplier: idSupplier,
                clientEmail: clientEmail,
                title: titleReview,
                comment: commentReview,
                valutation: valutationReview
            }, function(data, status) {
                data = JSON.parse(data);
                $("#commentReview").val("");
                $("#titleReview").val("");
                $("#numberReview").html(data.numberReview);
                $("#averageRating").html(data.averageRating);
                $(".mediasReviews").prepend(data.newReview);
                loadStars();
            });
        }
    });
});

function getIdSupplier() {
    var idSupplier = -1;
    var urlParameters = window.location.search.substring(1).split('=');
    if (urlParameters[0] == "id") {
        idSupplier = urlParameters[1];
    }
    return idSupplier;
}

function switchFromDivToDiv(hideDiv, showDiv) {
    $("#" + hideDiv).fadeOut("slow", function() {
        $("#" + showDiv).fadeIn("slow");
    });
}

function switchFromDivToDivAndSetValueTextbox(idTextbox, idValue, hideDiv, showDiv) {
    $("#" + idTextbox).val($("#" + idValue).html())
    switchFromDivToDiv(hideDiv, showDiv);
}

function switchFromDivToDivAndRemoveError(idTextbox, hideDiv, showDiv) {
    removeError($("#" + idTextbox));
    switchFromDivToDiv(hideDiv, showDiv);
}

function showOrRemoveError(elem, message) {
    if (elem.val() === "" && elem.next(".validation").length == 0) {
        elem.after("<div class='text-danger validation'><i class='fas fa-times'> Questo campo è obbligatorio</i></div>");
    } else if (elem.val() != "" && elem.next(".validation").length != 0) {
        elem.next(".validation").remove();
    }
}

function showError(elem, message) {
    if (elem.next(".validation").length == 0) {
        elem.after("<div class='text-danger validation'><i class='fas fa-times'> " + message + "</i></div>");
    }
}

function removeError(elem) {
    elem.next(".validation").remove();
}

function updateSupplierInformationAndSwitchFromDivToDiv(newElem, elem, attribute, information, fromDiv, toDiv, callback) {
    $.post("changeSupplierInformation.php", {
        idSupplier: getIdSupplier(),
        attribute: attribute,
        information: information
    }, function(data, status) {
        data = JSON.parse(data);
        removeError($("#" + newElem));
        callback(data.inf);
        switchFromDivToDiv(fromDiv, toDiv);
    });
}

function checkTextUpdateSupplierInformationAndSwitchFromDivToDiv(newElem, elem, attribute, fromDiv, toDiv, callback) {
    var information = $("#" + newElem).val();
    if (information.trim()) {
        updateSupplierInformationAndSwitchFromDivToDiv(newElem, elem, attribute, information, fromDiv, toDiv, callback);
    } else {
        showError($("#" + newElem), STANDARD_ERROR_MESSAGGE);
        $("#" + newElem).focus();
    }
}

function loadStars() {
    !function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof module&&module.exports?module.exports=e(require("jquery")):e(window.jQuery)}(function(e){"use strict";e.fn.ratingLocales={},e.fn.ratingThemes={};var t,a;t={NAMESPACE:".rating",DEFAULT_MIN:0,DEFAULT_MAX:5,DEFAULT_STEP:.5,isEmpty:function(t,a){return null===t||void 0===t||0===t.length||a&&""===e.trim(t)},getCss:function(e,t){return e?" "+t:""},addCss:function(e,t){e.removeClass(t).addClass(t)},getDecimalPlaces:function(e){var t=(""+e).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);return t?Math.max(0,(t[1]?t[1].length:0)-(t[2]?+t[2]:0)):0},applyPrecision:function(e,t){return parseFloat(e.toFixed(t))},handler:function(e,a,n,r,i){var l=i?a:a.split(" ").join(t.NAMESPACE+" ")+t.NAMESPACE;r||e.off(l),e.on(l,n)}},a=function(t,a){var n=this;n.$element=e(t),n._init(a)},a.prototype={constructor:a,_parseAttr:function(e,a){var n,r,i,l,s=this,o=s.$element,c=o.attr("type");if("range"===c||"number"===c){switch(r=a[e]||o.data(e)||o.attr(e),e){case"min":i=t.DEFAULT_MIN;break;case"max":i=t.DEFAULT_MAX;break;default:i=t.DEFAULT_STEP}n=t.isEmpty(r)?i:r,l=parseFloat(n)}else l=parseFloat(a[e]);return isNaN(l)?i:l},_parseValue:function(e){var t=this,a=parseFloat(e);return isNaN(a)&&(a=t.clearValue),!t.zeroAsNull||0!==a&&"0"!==a?a:null},_setDefault:function(e,a){var n=this;t.isEmpty(n[e])&&(n[e]=a)},_initSlider:function(e){var a=this,n=a.$element.val();a.initialValue=t.isEmpty(n)?0:n,a._setDefault("min",a._parseAttr("min",e)),a._setDefault("max",a._parseAttr("max",e)),a._setDefault("step",a._parseAttr("step",e)),(isNaN(a.min)||t.isEmpty(a.min))&&(a.min=t.DEFAULT_MIN),(isNaN(a.max)||t.isEmpty(a.max))&&(a.max=t.DEFAULT_MAX),(isNaN(a.step)||t.isEmpty(a.step)||0===a.step)&&(a.step=t.DEFAULT_STEP),a.diff=a.max-a.min},_initHighlight:function(e){var t,a=this,n=a._getCaption();e||(e=a.$element.val()),t=a.getWidthFromValue(e)+"%",a.$filledStars.width(t),a.cache={caption:n,width:t,val:e}},_getContainerCss:function(){var e=this;return"rating-container"+t.getCss(e.theme,"theme-"+e.theme)+t.getCss(e.rtl,"rating-rtl")+t.getCss(e.size,"rating-"+e.size)+t.getCss(e.animate,"rating-animate")+t.getCss(e.disabled||e.readonly,"rating-disabled")+t.getCss(e.containerClass,e.containerClass)},_checkDisabled:function(){var e=this,t=e.$element,a=e.options;e.disabled=void 0===a.disabled?t.attr("disabled")||!1:a.disabled,e.readonly=void 0===a.readonly?t.attr("readonly")||!1:a.readonly,e.inactive=e.disabled||e.readonly,t.attr({disabled:e.disabled,readonly:e.readonly})},_addContent:function(e,t){var a=this,n=a.$container,r="clear"===e;return a.rtl?r?n.append(t):n.prepend(t):r?n.prepend(t):n.append(t)},_generateRating:function(){var a,n,r,i=this,l=i.$element;n=i.$container=e(document.createElement("div")).insertBefore(l),t.addCss(n,i._getContainerCss()),i.$rating=a=e(document.createElement("div")).attr("class","rating-stars").appendTo(n).append(i._getStars("empty")).append(i._getStars("filled")),i.$emptyStars=a.find(".empty-stars"),i.$filledStars=a.find(".filled-stars"),i._renderCaption(),i._renderClear(),i._initHighlight(),n.append(l),i.rtl&&(r=Math.max(i.$emptyStars.outerWidth(),i.$filledStars.outerWidth()),i.$emptyStars.width(r)),l.appendTo(a)},_getCaption:function(){var e=this;return e.$caption&&e.$caption.length?e.$caption.html():e.defaultCaption},_setCaption:function(e){var t=this;t.$caption&&t.$caption.length&&t.$caption.html(e)},_renderCaption:function(){var a,n=this,r=n.$element.val(),i=n.captionElement?e(n.captionElement):"";if(n.showcaption){if(a=n.fetchCaption(r),i&&i.length)return t.addCss(i,"caption"),i.html(a),void(n.$caption=i);n._addContent("caption",'<div class="caption">'+a+"</div>"),n.$caption=n.$container.find(".caption")}},_renderClear:function(){var a,n=this,r=n.clearElement?e(n.clearElement):"";if(n.showClear){if(a=n._getClearClass(),r.length)return t.addCss(r,a),r.attr({title:n.clearButtonTitle}).html(n.clearButton),void(n.$clear=r);n._addContent("clear",'<div class="'+a+'" title="'+n.clearButtonTitle+'">'+n.clearButton+"</div>"),n.$clear=n.$container.find("."+n.clearButtonBaseClass)}},_getClearClass:function(){var e=this;return e.clearButtonBaseClass+" "+(e.inactive?"":e.clearButtonActiveClass)},_toggleHover:function(e){var t,a,n,r=this;e&&(r.hoverChangeStars&&(t=r.getWidthFromValue(r.clearValue),a=e.val<=r.clearValue?t+"%":e.width,r.$filledStars.css("width",a)),r.hoverChangeCaption&&(n=e.val<=r.clearValue?r.fetchCaption(r.clearValue):e.caption,n&&r._setCaption(n+"")))},_init:function(t){var a,n=this,r=n.$element.addClass("rating-input");return n.options=t,e.each(t,function(e,t){n[e]=t}),(n.rtl||"rtl"===r.attr("dir"))&&(n.rtl=!0,r.attr("dir","rtl")),n.starClicked=!1,n.clearClicked=!1,n._initSlider(t),n._checkDisabled(),n.displayOnly&&(n.inactive=!0,n.showClear=!1,n.showcaption=!1),n._generateRating(),n._initEvents(),n._listen(),a=n._parseValue(r.val()),r.val(a),r.removeClass("rating-loading")},_initEvents:function(){var e=this;e.events={_getTouchPosition:function(a){var n=t.isEmpty(a.pageX)?a.originalEvent.touches[0].pageX:a.pageX;return n-e.$rating.offset().left},_listenClick:function(e,t){return e.stopPropagation(),e.preventDefault(),e.handled===!0?!1:(t(e),void(e.handled=!0))},_noMouseAction:function(t){return!e.hoverEnabled||e.inactive||t&&t.isDefaultPrevented()},initTouch:function(a){var n,r,i,l,s,o,c,u,d=e.clearValue||0,p="ontouchstart"in window||window.DocumentTouch&&document instanceof window.DocumentTouch;p&&!e.inactive&&(n=a.originalEvent,r=t.isEmpty(n.touches)?n.changedTouches:n.touches,i=e.events._getTouchPosition(r[0]),"touchend"===a.type?(e._setStars(i),u=[e.$element.val(),e._getCaption()],e.$element.trigger("change").trigger("rating.change",u),e.starClicked=!0):(l=e.calculate(i),s=l.val<=d?e.fetchCaption(d):l.caption,o=e.getWidthFromValue(d),c=l.val<=d?o+"%":l.width,e._setCaption(s),e.$filledStars.css("width",c)))},starClick:function(t){var a,n;e.events._listenClick(t,function(t){return e.inactive?!1:(a=e.events._getTouchPosition(t),e._setStars(a),n=[e.$element.val(),e._getCaption()],e.$element.trigger("change").trigger("rating.change",n),void(e.starClicked=!0))})},clearClick:function(t){e.events._listenClick(t,function(){e.inactive||(e.clear(),e.clearClicked=!0)})},starMouseMove:function(t){var a,n;e.events._noMouseAction(t)||(e.starClicked=!1,a=e.events._getTouchPosition(t),n=e.calculate(a),e._toggleHover(n),e.$element.trigger("rating.hover",[n.val,n.caption,"stars"]))},starMouseLeave:function(t){var a;e.events._noMouseAction(t)||e.starClicked||(a=e.cache,e._toggleHover(a),e.$element.trigger("rating.hoverleave",["stars"]))},clearMouseMove:function(t){var a,n,r,i;!e.events._noMouseAction(t)&&e.hoverOnClear&&(e.clearClicked=!1,a='<span class="'+e.clearCaptionClass+'">'+e.clearCaption+"</span>",n=e.clearValue,r=e.getWidthFromValue(n)||0,i={caption:a,width:r,val:n},e._toggleHover(i),e.$element.trigger("rating.hover",[n,a,"clear"]))},clearMouseLeave:function(t){var a;e.events._noMouseAction(t)||e.clearClicked||!e.hoverOnClear||(a=e.cache,e._toggleHover(a),e.$element.trigger("rating.hoverleave",["clear"]))},resetForm:function(t){t&&t.isDefaultPrevented()||e.inactive||e.reset()}}},_listen:function(){var a=this,n=a.$element,r=n.closest("form"),i=a.$rating,l=a.$clear,s=a.events;return t.handler(i,"touchstart touchmove touchend",e.proxy(s.initTouch,a)),t.handler(i,"click touchstart",e.proxy(s.starClick,a)),t.handler(i,"mousemove",e.proxy(s.starMouseMove,a)),t.handler(i,"mouseleave",e.proxy(s.starMouseLeave,a)),a.showClear&&l.length&&(t.handler(l,"click touchstart",e.proxy(s.clearClick,a)),t.handler(l,"mousemove",e.proxy(s.clearMouseMove,a)),t.handler(l,"mouseleave",e.proxy(s.clearMouseLeave,a))),r.length&&t.handler(r,"reset",e.proxy(s.resetForm,a),!0),n},_getStars:function(e){var t,a=this,n='<span class="'+e+'-stars">';for(t=1;t<=a.stars;t++)n+='<span class="star">'+a[e+"Star"]+"</span>";return n+"</span>"},_setStars:function(e){var t=this,a=arguments.length?t.calculate(e):t.calculate(),n=t.$element,r=t._parseValue(a.val);return n.val(r),t.$filledStars.css("width",a.width),t._setCaption(a.caption),t.cache=a,n},showStars:function(e){var t=this,a=t._parseValue(e);return t.$element.val(a),t._setStars()},calculate:function(e){var a=this,n=t.isEmpty(a.$element.val())?0:a.$element.val(),r=arguments.length?a.getValueFromPosition(e):n,i=a.fetchCaption(r),l=a.getWidthFromValue(r);return l+="%",{caption:i,width:l,val:r}},getValueFromPosition:function(e){var a,n,r=this,i=t.getDecimalPlaces(r.step),l=r.$rating.width();return n=r.diff*e/(l*r.step),n=r.rtl?Math.floor(n):Math.ceil(n),a=t.applyPrecision(parseFloat(r.min+n*r.step),i),a=Math.max(Math.min(a,r.max),r.min),r.rtl?r.max-a:a},getWidthFromValue:function(e){var t,a,n=this,r=n.min,i=n.max,l=n.$emptyStars;return!e||r>=e||r===i?0:(a=l.outerWidth(),t=a?l.width()/a:1,e>=i?100:(e-r)*t*100/(i-r))},fetchCaption:function(e){var a,n,r,i,l,s=this,o=parseFloat(e)||s.clearValue,c=s.starCaptions,u=s.starCaptionClasses;return o&&o!==s.clearValue&&(o=t.applyPrecision(o,t.getDecimalPlaces(s.step))),i="function"==typeof u?u(o):u[o],r="function"==typeof c?c(o):c[o],n=t.isEmpty(r)?s.defaultCaption.replace(/\{rating}/g,o):r,a=t.isEmpty(i)?s.clearCaptionClass:i,l=o===s.clearValue?s.clearCaption:n,'<span class="'+a+'">'+l+"</span>"},destroy:function(){var a=this,n=a.$element;return t.isEmpty(a.$container)||a.$container.before(n).remove(),e.removeData(n.get(0)),n.off("rating").removeClass("rating rating-input")},create:function(e){var t=this,a=e||t.options||{};return t.destroy().rating(a)},clear:function(){var e=this,t='<span class="'+e.clearCaptionClass+'">'+e.clearCaption+"</span>";return e.inactive||e._setCaption(t),e.showStars(e.clearValue).trigger("change").trigger("rating.clear")},reset:function(){var e=this;return e.showStars(e.initialValue).trigger("rating.reset")},update:function(e){var t=this;return arguments.length?t.showStars(e):t.$element},refresh:function(t){var a=this,n=a.$element;return t?a.destroy().rating(e.extend(!0,a.options,t)).trigger("rating.refresh"):n}},e.fn.rating=function(n){var r=Array.apply(null,arguments),i=[];switch(r.shift(),this.each(function(){var l,s=e(this),o=s.data("rating"),c="object"==typeof n&&n,u=c.theme||s.data("theme"),d=c.language||s.data("language")||"en",p={},h={};o||(u&&(p=e.fn.ratingThemes[u]||{}),"en"===d||t.isEmpty(e.fn.ratingLocales[d])||(h=e.fn.ratingLocales[d]),l=e.extend(!0,{},e.fn.rating.defaults,p,e.fn.ratingLocales.en,h,c,s.data()),o=new a(this,l),s.data("rating",o)),"string"==typeof n&&i.push(o[n].apply(o,r))}),i.length){case 0:return this;case 1:return void 0===i[0]?this:i[0];default:return i}},e.fn.rating.defaults={theme:"",language:"en",stars:5,filledStar:'<i class="fas fa-star"></i>',emptyStar:'<i class="far fa-star"></i>',containerClass:"",size:"md",animate:!0,displayOnly:!1,rtl:!1,showClear:!0,showcaption:!0,starCaptionClasses:{.5:"badge badge-pill badge-danger",1:"badge badge-pill badge-danger",1.5:"badge badge-pill badge-warning",2:"badge badge-pill badge-warning",2.5:"badge badge-pill badge-info",3:"badge badge-pill badge-info",3.5:"badge badge-pill badge-primary",4:"badge badge-pill badge-primary",4.5:"badge badge-pill badge-success",5:"badge badge-pill badge-success"},clearButton:'<i class="fa fa-minus-circle"></i>',clearButtonBaseClass:"clear-rating",clearButtonActiveClass:"clear-rating-active",clearCaptionClass:"label label-default",clearValue:null,captionElement:null,clearElement:null,hoverEnabled:!0,hoverChangeCaption:!0,hoverChangeStars:!0,hoverOnClear:!0,zeroAsNull:!0},e.fn.ratingLocales.en={defaultCaption:"{rating} Stars",starCaptions:{.5:"Mezza Stella",1:"Una Stella",1.5:"Una Stella E Mezzo",2:"Due Stelle",2.5:"Due Stelle E Mezzo",3:"Tre Stelle",3.5:"Tre Stelle E Mezzo",4:"Quattro Stelle",4.5:"Quattro Stelle E Mezzo",5:"Cinque Stelle"},clearButtonTitle:"Zero Stelle",clearCaption:"Zero Stelle"},e.fn.rating.Constructor=a,e(document).ready(function(){var t=e("input.rating");t.length&&t.removeClass("rating-loading").addClass("rating-loading").rating()})});
}
