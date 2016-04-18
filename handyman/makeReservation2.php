<?php
	/* 
	 * To change this license header, choose License Headers in Project Properties.
	 * To change this template file, choose Tools | Templates
	 * and open the template in the editor.
	 */
	error_reporting(E_ALL ^ E_DEPRECATED);
	/* connect to database */	
	$connect = mysql_connect("localhost", "root", "");
	if (!$connect) {
		die("Failed to connect to database");
	}
	mysql_select_db("handyman") or die( "Unable to select database");
	$errorMsg = "";
	session_start();

	if (!isset($_SESSION['email'])) {
		header('Location: login.php');
		exit();
	}
	$customer = $_SESSION['email'];
?>


<?php 
   $flag = 0;
   if (isset($_POST["back"])) {
	   header('Location: customerMenu.php');
	   exit;
   }
   else if (isset($_POST["available_tool"])) {
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];	 
		$start_date2 = strtotime($start_date);		
		$end_date2 = strtotime($end_date);
		if (empty($start_date || $end_date)) {
			echo "<font color = 'red'>ERROR: Must input both start date and end date. </font color><br />";
			echo "<font color = 'red'>Try again </font color><br />";
			break;
		} else {
                $name1 =  mysql_real_escape_string($_POST["start_date"]);
				$name2 =  mysql_real_escape_string($_POST["end_date"]);
                if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$name1) ||
				    !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$name2) ){
                echo "<font color = 'red'>ERROR: Please provide valid start date yyyy-mm-dd </font color><br />"; 
                } 
				else if (strtotime($end_date) < strtotime($start_date)) {
					echo "<font color = 'red'> ERROR: End date need to be after start date. </font color> <br />";
				} else if (strtotime($start_date) < strtotime(date("Y/m/d"))) {
					echo "<font color = 'red'> ERROR: Start date can not be before today. </font color> <br />";
				} else {
					$query = "SELECT Tool_ID, Tool_Type, Abbrdesc, Rental, Deposit
					          FROM tool
							  WHERE Is_sold = 'N' and Tool_ID NOT IN (
						      SELECT Tool_ID
							  FROM reservation AS R1 INNER JOIN reserve AS R2
							  ON R1.Reservation_Number = R2.Reservation_Number
							  WHERE (DATEDIFF(R1.Start_date, '$end_date') <= 0 AND DATEDIFF(R1.Start_date, '$start_date') >= 0 OR 
							        (DATEDIFF(R1.End_date, '$end_date') <= 0 AND DATEDIFF(R1.End_date, '$start_date') >= 0))
							  UNION
							  SELECT Tool_ID
							  FROM service_order AS S
							  WHERE (DATEDIFF(S.Start_date, '$end_date') <= 0 AND DATEDIFF(S.Start_date, '$start_date') >= 0 OR 
							        (DATEDIFF(S.End_date, '$end_date') <= 0 AND DATEDIFF(S.End_date, '$start_date') >= 0))							  
									)";
				    $result = mysql_query($query, $connect);
				    $flag = 1; 
				}	
        }	
   }
?>



<html lang="en">
  <head>
     <title>Make Reservation</title>
  </head>  
  <body>
  
    <form action="makeReservation.php" method="post">
	<br />
	 Start Date: <input type= "date" name="start_date" value="" /><br />
	 End Date: <input type="date" name="end_date" value="" /><br />
		
	<br />
	 <input type="submit" name="available_tool" value="Show Available Tools" />
	 <input type="submit" name="back" value="Main Menu" />
	 <br />
	 <hr />
	 
	</form>	
	
	
  </body>
 </html>
 
 <?php 
     if ($flag == 1) {
		 echo "Tool available between " . $start_date . " and " . $end_date . " are: " . "<br />";
		 echo "<br />";
		 if (!$result) {
			   die("<font color = 'red'>database query failed. " . mysql_error($connect)) . "</font color>";
		   }
		 $row_num = 1;
		 while($row = mysql_fetch_assoc($result)) {
			 // output data from each row
			 //echo $row["Tool_ID"];
			 echo "<input type=\"checkbox\" name=\"formDoor[]\" value=\"$row_num\" />" . $row["Tool_ID"]. ", ".
			      $row["Tool_Type"]. ", ". $row["Abbrdesc"]. ", $". $row["Rental"]. "<br />";
			 echo "<br />";
			 $row_num += 1;
			 
		 }
		 echo "<input type=\"submit\" name=\"make_reserve\" value=\"Calculate Total\" /> ";
	 }
 ?>