<?php

/* 
 * Created by xwang738 on 04/14/16
 */

error_reporting(E_ALL ^ E_DEPRECATED);

/* connect to database */	

$connect = mysql_connect("localhost", "root", "");

if (!$connect) {

	die("Failed to connect to database");

}

mysql_select_db("handyman") or die( "Unable to select database");


$errorMsg = "";

/* if form was submitted, then update database with the service order */

session_start();

if (!isset($_SESSION['clerk'])) {

	header('Location: login.php');

	exit();

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	/* validate form */
    if (empty($_POST["toolID"])or empty($_POST["startingdate"]) or empty($_POST["endingdate"]) or empty ($_POST["repaircost"])) {
        $errorMsg = "All input fields are required";
    }
	
    elseif (!ctype_digit($_POST["toolID"])){
		$errorMsg = "Tool ID should only contain numbers";
	}
	
	elseif (!ctype_digit($_POST["repaircost"])){
		$errorMsg = "The repair cost should only contain numbers";
	}
	
	elseif ((!is_date($_POST["startingdate"]))or!(is_date($_POST["endingdate"]))){
		$errorMsg = "Both starting date and ending date should be valid dates";		
	}
	
	elseif (strtotime($_POST["startingdate"]) < strtotime("now")){
		$errorMsg = "Staring date should be no earlier than current date";		
	}
	
	elseif (strtotime($_POST["startingdate"]) > strtotime($_POST["endingdate"])){
		$errorMsg = "Starting date should be no later than ending date";		
	}
	
	else {
		$tool_ID = $_POST["toolID"];
		$start_date = date("Y-m-d", strtotime($_POST["startingdate"]));
		$end_date = date("Y-m-d", strtotime($_POST["endingdate"]));
		$cost = floatval($_POST["repaircost"]);
		
		$query = "SELECT * FROM TOOL WHERE TooL_ID = '$tool_ID'";
		$result = mysql_query($query);
		
		if (mysql_num_rows($result) == 0) {

            $errorMsg = "The TOOL_ID does not exit"; 
        }  
		
		else {				
		
			$query = "SELECT Tool_ID 
					  FROM TOOL 
					  WHERE Is_sold = 'N' AND Tool_ID = '$tool_ID' AND Tool_ID NOT IN 
					 (SELECT tool.Tool_Id FROM tool, reserve, reservation
					  WHERE ((reservation.start_date < '$start_date' and reservation.end_date >'$start_date') or 
					  (reservation.start_date < '$end_date' and reservation.end_date > '$end_date')) AND 
					  reserve.reservation_number = reservation.reservation_number AND tool.tool_id = reserve.tool_id) 
					  AND Tool_ID NOT IN 
					 (SELECT Tool_ID FROM service_order
					  WHERE (start_date < '$start_date' and end_date > '$start_date') or
					  (start_date < '$end_date' and end_date > '$end_date'))";
			
			$result = mysql_query($query);
			
			if (mysql_num_rows($result) == 0) {

				$errorMsg = "The requested tool is not available for service order"; 
			}
			
			
			else{
				$query = "INSERT INTO Service_order(Tool_ID, Start_date, end_date, repair_cost) 
						 VALUES('$tool_ID', '$start_date', '$end_date', $cost)";
				
				if (!mysql_query($query)) {

					print '<p class="error">Error: Failed to submit service order. ' . mysql_error() . '</p>';
				} 
				else {
					header('Location: clerkMenu.php');
					exit();
				}
			}

		}

		
	}
}
 
function is_date( $str ) { 

	$stamp = strtotime( $str ); 

	if (!is_numeric($stamp)) { 

		return false; 

	} 

	$month = date( 'm', $stamp ); 

	$day   = date( 'd', $stamp ); 

	$year  = date( 'Y', $stamp ); 

  

	if (checkdate($month, $day, $year)) { 

		return true; 

	} 

	return false; 

} 



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>handyman Service Order</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	

	<body>



		<div id="main_container">
			
			<div class="center_content">

			

				<div class="center_left">

					<div class="features">   

						

						<div class="serviceorder_section">

							

							<form name="serviceorderform" action="serviceOrder.php" method="post">
                                                        
                                                            <div class="title"><font size="20"><b>Service Order Request</b></font></div>
                                                        <br>
                                                            

							<table width="30%">

								<tr>

									<td class="item_label">Tool ID</td>

									<td>

										<input type="text" name="toolID" />										

									</td>

								</tr>

								<tr>

									<td class="item_label">Starting Date</td>

									<td>

										<input type="text" name="startingdate" />	

									</td>

								</tr>
								<tr>

									<td class="item_label">Ending Date</td>

									<td>

										<input type="txt" name="endingdate" />	

									</td>

								</tr>
								<tr>

									<td class="item_label">Estimated Cost of Repair $</td>

									<td>

										<input type="text" name="repaircost" />	

									</td>

								</tr> 
                                                       

   
                                                        

							</table>

							

							<input type="submit" form="form1" value="Submit"/> 

							

							</form>
                                                        <?php

                                                                if (!empty($errorMsg)) {

                                                                    print "<div class='login_form_row' style='color:red'>$errorMsg</div>";

                                                                }

                                                        ?> 							
						

						</div>			

					 </div> 					

				</div> 				

				<div class="clear"></div>			

			</div>    

		</div>

	</body>

</html>