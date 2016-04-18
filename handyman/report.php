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

	if (!isset($_SESSION['clerk'])) {
		header('Location: login.php');
		exit();
	}
?>

<?php 
   if (isset($_POST["back"])) {
	   header('Location: clerkMenu.php');
	   exit;
   } else if (isset($_POST["back2"])) {
	   header('Location: generatereport.php');
	   exit;
   } else {
	   $month = $_POST["month"];
	   $year = $_POST["year"];
	   $now = getdate();
	   if (empty($month) || empty($year)) {
		   echo "<font color = 'red'>ERROR: Please enter both month and year. </font color><br />";
	   } else if (($year > $now["year"]) || ($year == $now["year"] && $month > $now["mon"])) {
		   echo "<font color = 'red'>ERROR: Entered future month or year. </font color><br />";
	   }
	   
	   if (isset($_POST["tool_report"])) {
		  // generate tool report
		  $query = "SELECT T.Tool_ID, T.Abbrdesc, sum(DATEDIFF(R1.End_date, R1.Start_date)*T.Rental) AS profit,
					sum(IFNULL(S.Repair_cost,0)) + T.Purchase_price AS cost, sum(DATEDIFF(R1.End_date, R1.Start_date)*T.Rental)
					- sum(IFNULL(S.Repair_cost,0)) - T.Purchase_price AS total_profit
					FROM reservation AS R1 INNER JOIN reserve AS R2 ON R1.Reservation_Number =
					R2.Reservation_Number INNER JOIN tool as T ON T.Tool_ID = R2.Tool_ID LEFT JOIN service_order AS S
					ON S.Tool_ID = R2.Tool_ID
					WHERE month(R1.Start_date) = $month AND Year(R1.Start_date) = $year
					Group BY T.Tool_ID
					ORDER BY total_profit DESC";
		/*$query = "SELECT *
					FROM reservation AS R1 INNER JOIN reserve AS R2 ON R1.Reservation_Number =
					R2.Reservation_Number INNER JOIN tool as T ON T.Tool_ID = R2.Tool_ID LEFT JOIN service_order AS S
					ON S.Tool_ID = R2.Tool_ID
					WHERE month(R1.Start_date) = $month AND year(R1.Start_date) = $year";*/
		  $result = mysql_query($query, $connect);
		  // test if there was a query error
		   if (!$result) {
			   die("<font color = 'red'>database query failed. " . mysql_error($connect)) . "</font color>";
		   }
		   
			echo "Tool Report on " . $month . "/" . $year . ": ";
			while($row = mysql_fetch_assoc($result)) {
				 // output data from each row
				 var_dump($row);
				 echo "<hr />";
			}			
	   } else if (isset($_POST["customer_report"])) {
		   // generate customer report
		   $query = "SELECT C.Fname, C.Lname, C.Username, COUNT(R2.Tool_ID) AS num_tools
		             FROM reservation AS R1 INNER JOIN customer AS C ON R1.Request_customer = C.Username
					 INNER JOIN reserve AS R2 ON R1.Reservation_Number = R2.Reservation_Number
					 WHERE month(R1.Start_date) = $month AND year(R1.Start_date) = $year
					 GROUP BY C.Username
					 ORDER BY num_tools, C.Lname";
		   
		   $result = mysql_query($query, $connect);
		  // test if there was a query error
		   if (!$result) {
			   die("<font color = 'red'>database query failed. " . mysql_error($connect)) . "</font color>";
		   }
		   
			echo "Customer Report on " . $month . "/" . $year . ": ";
			while($row = mysql_fetch_assoc($result)) {
				 // output data from each row
				 var_dump($row);
				 echo "<hr />";
			}
	   }  else if (isset($_POST["clerk_report"])) {
		   // generate clerk report
		   $query = "SELECT U.clerk_name, U.num_pickup, U.num_dropoff, U.num_pickup + U.num_dropoff AS num_total
		             FROM (
					    (SELECT Pickup_Clerk AS clerk_name, COUNT(Pickup_Clerk) AS num_pickup, 0 AS num_dropoff
						FROM reservation AS R
						WHERE month(R.Start_date) = $month AND year(R.Start_date) = $year)
						UNION ALL
						(SELECT Dropoff_Clerk AS clerk_name, 0 AS num_pickup, COUNT(Dropoff_Clerk) AS num_dropoff 
						FROM reservation AS R
						WHERE month(R.End_date) = $month AND year(R.End_date) = $year)
					 ) AS U
					 WHERE U.clerk_name IS NOT NULL
					 GROUP BY U.clerk_name
					 ORDER BY num_total DESC";
		   /*$query = "
		                
					    (SELECT Pickup_Clerk AS clerk_name, COUNT(Pickup_Clerk) AS num_pickup, 0 AS num_dropoff
						FROM reservation AS R
						WHERE month(R.Start_date) = $month AND year(R.Start_date) = $year)
						UNION ALL
						(SELECT Dropoff_Clerk AS clerk_name, 0 AS num_pickup, COUNT(Dropoff_Clerk) AS num_dropoff 
						FROM reservation AS R
						WHERE month(R.End_date) = $month AND year(R.End_date) = $year)
					 ";*/
		   $result = mysql_query($query, $connect);
		  // test if there was a query error
		   if (!$result) {
			   die("<font color = 'red'>database query failed. " . mysql_error($connect)) . "</font color>";
		   }
		   
			echo "Customer Report on " . $month . "/" . $year . ": ";
			while($row = mysql_fetch_assoc($result)) {
				 // output data from each row
				 var_dump($row);
				 echo "<hr />";
			}
	   }
   }
?>


<html lang="en">
	<head>
	<title>Add New Tools</title>
	</head>  
	
	<body>
    
	<form action="report.php" method="post">
	<input type="submit" name="back" value="Main Menu" />
	<input type="submit" name="back2" value="Back" />
	</form>	
	
	</body>
 </html>
