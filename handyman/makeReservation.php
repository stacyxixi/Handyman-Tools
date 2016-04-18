<?php

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'handyman');
// Make the connection:
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
$errorMsg = "";

?>

<html>
    <head>
        
       

    </head> 
    <body>
        <h1>Make Reservation</h1>
        <label>Type of Tool</label>
        <select id="toolType"></select>
        <br>
        <label>Tool</label>
        <select id="tool"></select>
        <script src="scripts/jquery-1.12.3.min.js"></script>
        <script src ="scripts/script.js"></script>
    </body>
    
</html>