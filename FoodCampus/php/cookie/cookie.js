$(document).ready(function() {
    $("#cookie-btn").click(function() {
        days = 365; //number of days to keep the cookie
        myDate = new Date();
        myDate.setTime(myDate.getTime()+(days*24*60*60*1000));
        document.cookie = "comply_cookie =comply_yes; expires =" + myDate.toGMTString() + "; path=/"; //creates the cookie: name|value|expiry
        $(".nav-cookies").slideUp("slow");
    });
});
