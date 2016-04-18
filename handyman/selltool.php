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
$today = date("Y-m-d", strtotime("now"));

session_start();

if (!isset($_SESSION['clerk'])) {

	header('Location: login.php');

	exit();

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	/* validate form */
    if (empty($_POST["toolID"])) {
        $errorMsg = "All input fields are required";
    }
	
    elseif (!ctype_digit($_POST["toolID"])){
		$errorMsg = "Tool ID should only contain numbers";
	}
	
	else {
		$tool_ID = $_POST["toolID"];
				
		$query = "SELECT * FROM TOOL WHERE TooL_ID = '$tool_ID'";
		$result = mysql_query($query);
		
		if (mysql_num_rows($result) == 0) {

            $errorMsg = "The TOOL ID does not exist"; 
        }  
		
		else {			
		
			$queryx = "SELECT Tool_ID FROM TOOL WHERE Is_sold = 'N' AND TooL_ID = '$tool_ID'
                     AND tool_ID NOT IN  
                     (SELECT tool.tool_id FROM tool, reserve, reservation 
                      WHERE reservation.start_date< '$today' and reservation.end_date>'$today' 
					  and reserve.reservation_number = reservation.reservation_number and tool.tool_id = reserve.tool_id)
                     AND tool_ID NOT IN  
                     (SELECT tool_id from service_order 
                      WHERE start_date < '$today' and end_date> '$today')";
			
			$resultx = mysql_query($queryx);
			
			if (mysql_num_rows($resultx) == 0) {

				$errorMsg = "The requested tool is not available for sale"; 
			}
			
			
			else{
				
				$query = "UPDATE TOOL SET Is_sold = 'Y' WHERE TooL_ID = '$tool_ID'"; 
				
				if (!mysql_query($query)) {

					print '<p class="error">Error: Failed to sell tool. ' . mysql_error() . '</p>';
				} 
				else {
					$_SESSION['tool_ID'] = $tool_ID;
                    
					header('Location: salePrice.php');			                   					
					exit();
				}
			}

		}

		
	}
}
 
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>handyman Sell Tool</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	

	<body>



		<div id="main_container">
			
			<div class="center_content">

			

				<div class="center_left">

					<div class="features">   

						

						<div class="profile_section">

							

							<form name="selltoolform" action="selltool.php" method="post">
                                                        
                                                            <div class="title"><font size="20"><b>Sell Tool</b></font></div>
                                                        <br>
                                                            

							<table width="30%">

								<tr>

									<td class="item_label">Tool ID</td>

									<td>

										<input type="text" name="toolID" />										

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
