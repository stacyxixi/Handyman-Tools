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

	if (!isset($_SESSION['Tool_ID'])) {
		header('Location: CheckAvailability1.php.php');
		exit();
	}
	$Tool_ID = $_SESSION['Tool_ID'];
?>


<?php 
   if (isset($_POST["back"])) {
	   header('Location: customerMenu.php');
	   exit;
   }
   else {
	   $query = "SELECT Tool_ID, Abbrdesc, Fulldesc, Tool_Type, Deposit, Rental
	             FROM tool
				 WHERE Tool_ID = $Tool_ID";
	   $result = mysql_query($query, $connect);
		    
	   // test if there was a query error
	   if (!$result) {
		   die("<font color = 'red'>database query failed. " . mysql_error($connect)) . "</font color>";
	   }
	   echo "Details of Tool with Tool_ID " . $Tool_ID . ": ";
		while($row = mysql_fetch_assoc($result)) {
			 // output data from each row
			 var_dump($row);
			 echo "<hr />";
		}
   }
?>



<html lang="en">
  <head>
     <title>Tool Details</title>
  </head>  
  <body>
  
    <form action="tooldetails.php" method="post">
	 
	 <input type="submit" name="back" value="Main Menu" />
	</form>	
	
  </body>
 </html>