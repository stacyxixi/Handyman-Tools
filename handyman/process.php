<?php
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'handyman');
// Make the connection:
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
$errorMsg = "";

session_start();
$Tool_Type =$_GET['type'];
$tools = array();
if (isset($_SESSION['start_date']) && isset($_SESSION['end_date'])) {
    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];
    $query = "SELECT distinct Tool_ID, Abbrdesc FROM tool WHERE Is_sold = 'N' and Tool_Type = '$Tool_Type' and Tool_ID not in (select tool.Tool_ID from tool, reserve, reservation where ((reservation.start_date<= '$start_date' and reservation.end_date>= '$start_date') or (reservation.start_date<= '$end_date' and reservation.end_date>= '$end_date')) and reserve.reservation_number = reservation.reservation_number and tool.Tool_ID = reserve.Tool_ID and tool.tool_id not in (select tool_id from service_order where (start_date<= '$start_date' and end_date>= '$start_date') or (start_date<= '$end_date' and end_date>= '$end_date')))";
    $result = mysqli_query($dbc,$query);
    while ($row = mysqli_fetch_array($result)){
        $data = $row['Tool_ID'].":".$row['Abbrdesc'];
        array_push($tools, $data);
    }

	

}





echo json_encode($tools);


?>