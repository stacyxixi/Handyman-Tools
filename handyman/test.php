<form action="?" method="get"> ID Number: <input
type="text" name="idnumber" /><br/>
<input type="submit" value="Whats my
email address" /> </form> 

<html>
<head>
<title>Dynamic Form</title>
<script language="javascript">
var i = 1;
function changeIt()
{
my_div.innerHTML = my_div.innerHTML +"<br><input type='text' name='mytext'+ i>"
i++;
}
</script>
</head>
<body>

<form name="form" action="post" method="">
<input type="text" name=t1>
<input type="button" value="test" onClick="changeIt()">
<div id="my_div"></div>
</body>


<?php
if (!empty($start_date) && !empty($end_date) && !empty($Tool_Type)){
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $Tool_Type = $_GET['Tool_Type'];
//                                                            echo $_GET['Tool_Type'];
    $query = "SELECT Tool_ID, Abbrdesc, Deposit, Rental FROM tool WHERE Is_sold = 'N' and Tool_Type = '$Tool_Type' and Tool_ID not in (select tool.Tool_ID from tool, reserve, reservation where ((reservation.start_date< '$start_date' and reservation.end_date> '$start_date') or(reservation.start_date< '$end_date' and reservation.end_date> '$end_date')) and reserve.reservation_number = reservation.reservation_number and tool.Tool_ID = reserve.Tool_ID) and tool_id not in (select tool_id from service_order where (start_date< '$start_date' and end_date> '$start_date') or (start_date< '$end_date' and end_date> '$end_date'))";
    $result = mysql_query($query); // Run your query

    echo '<select name="tool_info" id = i>'; // Open your drop down box

    // Loop through the query results, outputing the options one by one
    while ($row = mysql_fetch_array($result)) {
       echo '<option value="'.'Part#'.$row['Tool_ID'].':'.$row['Abbrdesc'].'</option>';
    }

    echo '</select>';

}
else{
    echo '<select></select>';                                                                
}