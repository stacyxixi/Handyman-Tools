<?php


/* connect to database */	

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'handyman');
// Make the connection:
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
$errorMsg = "";
session_start();


$start_date = '2020-01-01';
$end_date = '2020-01-05';
$Tool_Type ='Hand Tools';

$tools = array();

$query = "SELECT Tool_ID, Abbrdesc, Deposit, Rental FROM tool WHERE Is_sold = 'N' and Tool_Type = '$Tool_Type' and Tool_ID not in (select tool.Tool_ID from tool, reserve, reservation where ((reservation.start_date< '$start_date' and reservation.end_date> '$start_date') or(reservation.start_date< '$end_date' and reservation.end_date> '$end_date')) and reserve.reservation_number = reservation.reservation_number and tool.Tool_ID = reserve.Tool_ID) and tool_id not in (select tool_id from service_order where (start_date< '$start_date' and end_date> '$start_date') or (start_date< '$end_date' and end_date> '$end_date'))";
$result = mysqli_query($dbc,$query);
while ($row = mysqli_fetch_array($result)){
    array_push($tools, $row['Abbrdesc']);
}
echo json_encode($tools);
        
?>