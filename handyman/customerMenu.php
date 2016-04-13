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

?>
<html>  
<head>

	<title>handyman customer Main Menu</title>

	<link rel="stylesheet" type="text/css" href="style.css" />

</head>
    
<body>
    <script type="text/javascript">

    function submitAction(act) {
         document.sample.action = act;
         document.sample.submit();

    }
    </script>
    <form name ="sample" action="customerMenu.php">
         <input type="button" value = "View Profile" style="width:200px" onClick="submitAction('Profile.php')"> 
         <br>
         <br>
         <input type="button" value = "Check Tool Availability" style="width:200px" onClick="submitAction('CheckAvailability1.php')">
         <br>
         <br>
         <input type="button" value = "Make Reservation" style="width:200px" onClick="submitAction('makeReservation.php')">
         <br>           
    </form>
    <form method="post" action="logout.php">
        <input type="submit" value = "Exit" style="width:200px">
    </form>
</body>
</html>

