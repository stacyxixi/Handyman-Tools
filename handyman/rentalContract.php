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


if (!isset($_SESSION['clerk'])) {

	header('Location: login.php');

	exit();

}

if (!isset($_SESSION['rnumber'])) {

	header('Location: clerkMenu.php');

	exit();

}
$rnumber = $_SESSION['rnumber'];
$clerk = $_SESSION['clerk'];


$queryx = "SELECT R.Reservation_number, R.Pickup_clerk, R.Request_customer, R.Pickup_creditcard_number, R.start_date, R.End_date, T.tool_ID, T.abbrdesc from Reservation as R inner join reserve on R.reservation_number = reserve.reservation_number inner join tool as T on T.Tool_ID = reserve.Tool_ID where R.reservation_number = '$rnumber'";

$resultx = mysql_query($queryx);


if (!$resultx) {

	print "<p class='error'>Errorx: " . mysql_error() . "</p>";

	exit();
}


$rowx = mysql_fetch_array($resultx);

$customer = $rowx['Request_customer'];

$queryz = "SELECT fname, lname from customer where username = '$customer'";

$resultz = mysql_query($queryz);

if (!$resultz) {

	print "<p class='error'>Errorx: " . mysql_error() . "</p>";

	exit();
}

$rowz = mysql_fetch_array($resultz);


$queryy = "SELECT sum(T.rental*DATEDIFF(R.end_date,R.start_date)) as rent, sum(T.deposit) as depo from RESERVATION as R inner join RESERVE on R.reservation_number = reserve.reservation_number inner join TOOL as T on T.Tool_ID = reserve.Tool_ID where R.reservation_number = '$rnumber'";

$resulty = mysql_query($queryy);

if (!$resulty) {

	print "<p class='error'>Errorx: " . mysql_error() . "</p>";

	exit();
}

$rowy = mysql_fetch_array($resulty);

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>Handyman Rental Contract</title>

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
                                    <div class="title"><font size="5"><i>HandyMan Tools Rental Contract</i></font></div>
					<div class="features">   

						

						<div class="profile_section">

							

							<table width="80%">

								<tr>

									<td class="item_label">Reservation Number:</td>

									<td><?php print $rowx['Reservation_number']; ?></td>
                                                                        <td class="item_label">Clerk On Duty:</td>

									<td><?php print $rowx['Pickup_clerk']; ?></td>

								</tr>

								<tr>

									<td class="item_label">Customer Name:</td>

									<td><?php print $rowz['fname'] . ' ' . $rowz['lname'];?></td>
                                                                        <td class="item_label">Credit Card Number:</td>

									<td><?php print $rowx['Pickup_creditcard_number']; ?></td>

								</tr>

								<tr>

									<td class="item_label">Start Date:</td>

									<td><?php print $rowx['start_date'];?></td>
                                                                        <td class="item_label">End Date:</td>

									<td><?php print $rowx['End_date']; ?></td>

								</tr>

							</table>
                                                        
                                                        

							

						</div>
                                                <br>
                                                <br>
                                                                                               
                                            <div class="title"><font size="4"><b>Tool Rented:</b></font></div>
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
                                                                    $querya = "SELECT T.tool_ID, T.abbrdesc from TOOL as T inner join reserve on T.Tool_id = reserve.tool_ID inner join RESERVATION as R on R.reservation_number = reserve.reservation_number where R.reservation_number = '$rnumber'";
                                                                    $resulta = mysql_query($querya);
                                                                    if (!$resultx) {

                                                                        $emptyMsg = "No tools are found.";
                                                                        print "{$emptyMsg}";
                                                                        exit();

                                                                    }
                                                                    $i = 1;
                                                                    while ($rowa = mysql_fetch_array($resulta)){
                                                                        print '<tr>'; 
                                                                        print '<td align="center">'.$i.'.'."</td>";
                                                                        print '<td align="center">'.$rowa['tool_ID']."</td>";
                                                                        print '<td align="center">'.$rowa['abbrdesc']."</td>";
                                                                        print '<tr>';
                                                                        $i++;
                                                                    }
                                                                ?>
                                                            </tbody>

							</table>
                                                        
							

						</div>
                                                <div class="text"><font size="4"><b>Deposit Held:</b><?php print $rowy['rent']; ?></font></div>
                                                <div class="text"><font size="4"><b>Estimated Rental:</b><?php print $rowy['depo']; ?></font></div>                                            
                                            
                                                <div class="title">
                                                    <table width="40%">
                                                        <tr>
                                                            <td><font size="4"><b>Signature:</b></font></td>
                                                        </tr>
                                                        
                                                    </table>
                                                    <hr></hr>
                                                    
                                                    
                                                </div>
                                                </br>

                                                <div>
                                                     <script type="text/javascript">

                                                    function submitAction(act) {
                                                         document.sample.action = act;
                                                         document.sample.submit();
                                                    }
                                                    </script>
                                                    <form name ="sample" action="Profile.php">
                                                        <br>
                                                        <input type="button" value = "Back" style="width:200px" onClick="submitAction('clerkMenu.php')"></input>
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