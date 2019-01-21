<link rel="stylesheet" type="text/css" title="stylesheet" href="/tecweb_project/FoodCampus/php/cookie/cookie.css">
<script src="/tecweb_project/FoodCampus/php/cookie/cookie.js"></script>
<?php
    if(!isset($_COOKIE["comply_cookie"])) {
      echo "<nav class='nav-cookies navbar navbar-expand-xl navbar-dark fixed-top navbar-custom'>
                <div id='cookies'>
                    <p>
                        Il nostro sito usa i cookie.<br/>Continuando ad usare il sito, assumiamo la tua autorizzazione per l'utilizzo dei cookie.
                    </p>
                    <div class='d-flex justify-content-center form-group'>
                        <button type='button' id='cookie-btn' class='btn btn-warning' style='font-weight: bold;'><strong>OK</strong></button>
                    </div>
                </div>
            </nav>";
    }
?>
