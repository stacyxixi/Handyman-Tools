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

<html lang="en">
  <head>
     <title>Generate Report</title>
  </head>  
  <body>
  
    <form action="report.php" method="post">
	Please enter the month and year you are interested in.
	<br />
	 Month: $ <input type="numeric" name="month" value="" /><br />
	 Year: $ <input type="numeric" name="year" value="" /><br />
	<br/>
	 <input type="submit" name="tool_report" value="Tool Report" />
	 <input type="submit" name="customer_report" value="Customer Report" />
	 <input type="submit" name="clerk_report" value="Clerk Report" />
	</form>	
	
  </body>
 </html>
