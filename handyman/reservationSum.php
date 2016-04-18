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

$t = $_SESSION["tools"];
$tools = explode(",", $t);




$startdate = $_SESSION["start_date"];
$enddate = $_SESSION["end_date"];
$formatted_startdate = new DateTime ($startdate);
$formatted_enddate = new DateTime ($enddate);		
$dateDiff = $formatted_startdate -> diff ($formatted_enddate);
$daysRented = $dateDiff -> d;

$totalRental = 0.0;
$totalDeposit = 0.0;

foreach ($tools as $tool){
	$query = "SELECT Deposit, Rental FROM TOOL WHERE TooL_ID = '$tool'";
    $result = mysql_query($query);
	
	if (!$result) {
	print "<p class='error'>Errorx: " . mysql_error() . "</p>";
	exit();
    }
	
	$row = mysql_fetch_array($result);
    $totalRental += $row['Rental'] * $daysRented;
	$totalDeposit += $row['Deposit'];
}

$totalRental = sprintf('%0.2f', $totalRental);
$totalDeposit = sprintf('%0.2f', $totalDeposit);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>ResSummary</title>

		<link rel="stylesheet" type="text/css" href="style.css" />
                <style>
                table.transaction {
                    border-collapse: collapse;
                }

                table.transaction, table.transaction td, table.transaction th {
                    border: 1px solid black;
                }

                hr { 
                    display: block;
                    margin-top: 0em;
                    margin-bottom: 0.5em;
                    margin-left: 7em;
                    margin-right: 60em;
                    border-style: inset;
                    border-width: 1px;
                } 

                </style>               

	</head>	

	<body>

		<div id="main_container">

			<div class="center_content">			

				<div class="center_left">
                    
					<div class="title"><font size="5"><i>Reservation Summary</i></font></div>
					
					<div class="Summary">   
					    <div class="title"><font size="4"><b>Tools Desired:</b></font></div>
						
                            <div class="reservation">
                                                        <table width="50%">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Tools ID</th>	
                                                                    <th>Abbr.Desc</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
																
																$i = 1;
																foreach ($tools as $tool){
																	$queryx = "SELECT Abbrdesc FROM TOOL WHERE TooL_ID = '$tool'";
																	$resultx = mysql_query($queryx);
																	if (!$result) {
																		print "<p class='error'>Errorx: " . mysql_error() . "</p>";
																		exit();
																	}
																	$rowx = mysql_fetch_array($resultx);												
																	
																     
																	print '<tr>'; 
                                                                    print '<td align="center">'.$i.'.'."</td>";
                                                                    print '<td align="center">'.$tool."</td>";
                                                                    print '<td align="center">'.$rowx['Abbrdesc']."</td>";
                                                                    print '<tr>';
                                                                    $i++;
                                                                }
                                                                ?>
                                                            </tbody>
														</table>
 
						</div>

												<div class="text"><font size="4"><b>Start Date:</b><?php print $startdate; ?></font></div>
                                                <div class="text"><font size="4"><b>End Date:</b><?php print $enddate; ?></font></div>                                            
                                                <div class="text"><font size="4"><b>Total Rental Price:</b><?php print ' $'. $totalRental; ?></font></div>
                                                <div class="text"><font size="4"><b>Total Deposit Required:</b><?php print ' $'. $totalDeposit; ?></font></div>                               
												
                                                </br>

                                                <div>
                                                     <script type="text/javascript">

                                                    function submitAction(act) {
                                                         document.sample.action = act;
                                                         document.sample.submit();
                                                    }
                                                    </script>
                                                    <form name ="sample" action="reservationSum.php">
                                                        <br>
                                                        <input type="button" value = "Submit" style="width:200px" onClick="submitAction('reservationFinal.php')"></input>
														<input type="button" value = "Reset" style="width:200px" onClick="submitAction('makeReservation.php')"></input>
														
                                                    </form>
                                                </div>
                                             											

									

					 </div> 

					

				</div> 

				

				<div class="clear"></div> 

			

			</div>    

		</div>



	</body>

</html>