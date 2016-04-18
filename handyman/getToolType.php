<?php

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'handyman');
// Make the connection:
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
$errorMsg = "";
session_start();

$types = array();

$query = "SELECT distinct Tool_Type from tool";

$result = mysqli_query($dbc,$query);
while ($row = mysqli_fetch_array($result)){
    array_push($types, $row['Tool_Type']);
}
echo json_encode($types);

        
?>