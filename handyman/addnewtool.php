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
	$clerk = $_SESSION['clerk'];
?>


<?php 
   if (isset($_POST["submit"])) {
	   $abbr_desc = $_POST["abbr_desc"];
	   $purchase_price = $_POST["purchase_price"];
	   $rental_price = $_POST["rental_price"];
	   $deposit = $_POST["deposit"];
	   $full_desc = $_POST["full_desc"];
	   $tool_type = $_POST["toolType"];
	   $accessories = $_POST["accessories"];
	   if ($tool_type != "power_tool"  && !empty($accessories)) {
		   echo "<font color = 'red'>Input accessories for non power tool.<br />";
		   echo "Please check and reinput the information of the tool.</font color>";
	   }
	   else {
		   $query = "INSERT INTO tool (";
		   $query .= "Abbrdesc, Fulldesc, Tool_Type, Purchase_price, Deposit, Rental, Add_clerk";
		   $query .= ") VALUES (";
		   $query .= " '{$abbr_desc}', '{$full_desc}', '{$tool_type}', {$purchase_price}, {$deposit}, 
		                {$rental_price}, '{$clerk}'";
		   $query .= ")";
		   $result = mysql_query($query, $connect);
		   
		   $acc_array = explode(";", $accessories);
		   $tool_id = mysql_insert_id();
		   
		   foreach ($acc_array as $acc) {
			   $query2 = "INSERT INTO accessories (";
			   $query2 .= "Tool_ID, Accessories";
			   $query2 .= ") VALUES (";
		       $query2 .= "{$tool_id} ,'{$acc}'";
			   $query2 .= ")";
			   $result2 = mysql_query($query2, $connect);
		   }
		   // test if there was a query error
		   if ($result && $result2) { 
			  header("Location: " . "addnewtool.php");
			  exit;
		   } else {
			   die("<font color = 'red'>database query failed. " . mysql_error($connect)) . "</font color>";
		   }
			
		}
   }
   else if (isset($_POST["back"])) {
	   header('Location: clerkMenu.php');
	   exit;
   }
?>



<html lang="en">
  <head>
     <title>Add New Tools</title>
  </head>  
  <body>
  
    <form action="addnewtool.php" method="post">
	 Abbreviated Description: <input type= "text" name="abbr_desc" value="" /><br />
	 Purchase Price: $ <input type="numeric" name="purchase_price" value="" /><br />
	 Rental Price (per day): $ <input type="numeric" name="rental_price" value="" /><br />
	 Deposit Amount: $ <input type="numeric" name="deposit" value="" /><br />
	 Full Description: <input style="height:100px; width:400px" type= "text" name="full_desc" value="" /><br />
	 <p>
	Tool Type: <br />
	<select name="toolType">
	  <option value="">Select...</option>
	  <option value="constr_tool">Construction</option>
	  <option value="hand_tool">Hand tool</option>
	  <option value="power_tool">Power tool</option>
	</select>
	</p>
	If new item is a power tool, input accessories separated by ";":
	<br />
	<input style="height:30px; width:400px" type= "text" name="accessories" value="" /><br />
	 <br />
	 <input type="submit" name="submit" value="Submit" />
	 <input type="submit" name="back" value="Main Menu" />
	</form>	
	
  </body>
 </html>