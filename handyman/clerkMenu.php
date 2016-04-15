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
         <input type="button" value = "Pick-Up Reservation" style="width:200px" onClick="submitAction('pickUp.php')"> 
         <br>
         <br>
         <input type="button" value = "Drop-Off Reservation" style="width:200px" onClick="submitAction('dropoff.php')">
         <br>
         <br>
         <input type="button" value = "Service Order" style="width:200px" onClick="submitAction('serviceOrder.php')">
         <br>
         <br>
         <input type="button" value = "Add New Tool" style="width:200px" onClick="submitAction('addnewtool.php')">
         <br> 
         <br>
         <input type="button" value = "Sell Tool" style="width:200px" onClick="submitAction('selltool.php')">
         <br> 
         <br>
         <input type="button" value = "Generate Reports" style="width:200px" onClick="submitAction('generatereport.php')">
         <br>          
    </form>
    <form method="post" action="logout.php">
        <input type="submit" value = "Exit" style="width:200px">
    </form>
</body>
</html>

