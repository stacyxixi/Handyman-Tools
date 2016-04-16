<?php


error_reporting(E_ALL ^ E_DEPRECATED);

/* connect to database */	

$connect = mysql_connect("localhost", "root", "");

if (!$connect) {

	die("Failed to connect to database");

}

mysql_select_db("handyman") or die( "Unable to select database");

$errorMsg = "";
$emptyMsg = "";

session_start();

if (!isset($_SESSION['email'])) {

	header('Location: login.php');

	exit();

}

$Tool_Type = $_SESSION['tooltype'];
$start_date = $_SESSION['startdate'];
$end_date = $_SESSION['enddate'];
//$start_date = strtotime($start_date);
//$end_date = strtotime($end_date);
//$start_date = date("Y-m-d 00:00:00", $start_date);
//$end_date = date("Y-m-d 00:00:00", $end_date);

$query = "SELECT Tool_ID, Abbrdesc, Deposit, Rental FROM tool WHERE Is_sold = 'N' and Tool_Type = 'Hand Tools' and Tool_ID not in (select tool.Tool_ID from tool, reserve, reservation where ((reservation.start_date< '$start_date' and reservation.end_date> '$start_date') or(reservation.start_date< '$end_date' and reservation.end_date> '$end_date')) and reserve.reservation_number = reservation.reservation_number and tool.Tool_ID = reserve.Tool_ID) and tool_id not in (select tool_id from service_order where (start_date< '$start_date' and end_date> '$start_date') or (start_date< '$end_date' and end_date> '$end_date'))";

$resultx = mysql_query($query);

if (!$resultx) {

    $emptyMsg = "No tools are found.";
    print "{$emptyMsg}";
    exit();

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['view_details'])){
        if (empty($_POST['Tool_ID'])){
            $errorMsg = "Please provide Tool ID.";
        } 
        else{
            $_SESSION['Tool_ID'] = $_POST['Tool_ID'];
            header('Location: tooldetails.php');
            exit();
        }
        
        
        
    }
    if (isset($_POST['back_to_main'])){
        header('Location: customerMenu.php');
        exit();
    }
    
}




?>

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>Handyman Customer Profile</title>

		<link rel="stylesheet" type="text/css" href="style.css" />
                <style>
                table.transaction {
                    border-collapse: collapse;
                }

                table.transaction, table.transaction td, table.transaction th {
                    border: 1px solid black;
                }
                </style>
                

	</head>

	

	<body>



		<div id="main_container">

			<div class="center_content">

			

				<div class="center_left">
                                    <div class="title"><font size="5"><b>Tool Availability</b></font></div>
					<div class="features">   
						<div class="trasaction_section">

							

							<table class="transaction" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tool ID</th>
                                                                    <th>Abbr. Description</th>		
                                                                    <th>Deposit ($)</th>
                                                                    <th>Price/Day ($)</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                            <?php
                                                                while ($rowx = mysql_fetch_array($resultx)){
                                                                    print '<tr>'; 
                                                                    print '<td>'. $rowx['Tool_ID']."</td>";
                                                                    print '<td>'. $rowx['Abbrdesc'].'</td>';
                                                                    print '<td>'. $rowx['Deposit'].'</td>';
                                                                    print '<td>'. $rowx['Rental'].'</td>';
                                                                    print '<tr>';
                                                                }
                                                            ?>
                                                            </tbody>

							</table>
                                                        
							

						</div>
                                            <br></br>
                                            <hr>
                                                <div>
                                                    <form name ="sample" action="ToolAvailability.php" method = "post">
                                                        <div class="login_form_row">

							<label class="login_label">Part#:</label>

							<input type="text" name="Tool_ID" class="login_input" />
                                                        <input type="submit" name= "view_details" value = "View_Details"></input>

                                                        </div> 
                                                        <br>
                                                        <input type="submit" name= "back_to_main" value = "Back to Main"></input>
                                                    </form>
                                                </div>
                                                <!-- FIX THIS SECTION -->

						<!-- add code to show the user's education information -->												

									

					 </div> 

					

				</div> 

				

				<div class="clear"></div> 

			

			</div>    

		</div>



	</body>

</html>