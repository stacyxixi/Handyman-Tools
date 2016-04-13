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



/* FIX this query - add the column 'hometown' to the SELECT clause */

$queryx = "SELECT username, fname, lname, home_area_code, Home_local_number, work_area_code, work_local_number, address " .
		 "FROM customer " .
		 "WHERE customer.username = '{$_SESSION['email']}'";
                 



$resultx = mysql_query($queryx);



if (!$resultx) {

	print "<p class='error'>Errorx: " . mysql_error() . "</p>";

	exit();
}


$rowx = mysql_fetch_array($resultx);



if (!$rowx) {

	print "<p>Error: No data returned from database.  Administrator login NOT supported.</p>";

	print "<a href='logout.php'>Logout</a>";

	exit();

}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

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
                                    <div class="title"><font size="5"><b>Profile</b></font></div>
                                    <hr>
					<div class="features">   

						

						<div class="profile_section">

							

							<table width="50%">

								<tr>

									<td class="item_label">Email Address:</td>

									<td><?php print $rowx['username']; ?></td>

								</tr>

								<tr>

									<td class="item_label">Name:</td>

									<td><?php print $rowx['fname'] . ' ' . $rowx['lname'];?></td>

								</tr>

								<tr>

									<td class="item_label">Home Phone:</td>

									<td><?php print '('.$rowx['home_area_code'].')' . ' ' . substr($rowx['Home_local_number'],0,3).'-'.substr($rowx['Home_local_number'],3,4);?></td>

								</tr>
								<tr>

									<td class="item_label">Work Phone:</td>

									<td><?php print '('.$rowx['work_area_code'].')' . ' ' . substr($rowx['work_local_number'],0,3).'-'.substr($rowx['work_local_number'],3,4);?></td>

								</tr>

							</table>
                                                        
                                                        

							

						</div>
                                            <hr>
                                                <br>
                                                <div class="title"><font size="4"><b>Reservation History</b></font></div>
                                                <br>
                                                <div class="title">*****************************</div>
                                                </br>
						<div class="trasaction_section">

							

							<table class="transaction" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Res #</th>
                                                                    <th>Tools</th>		
                                                                    <th>Start</th>
                                                                    <th>End</th>
                                                                    <th>Rental Price</th>
                                                                    <th>Deposit</th>
                                                                    <th>Pick-up Clerk</th>
                                                                    <th>Drop-off Clerk</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                            <?php
                                                                $queryy = "SELECT R.reservation_number, T.abbrdesc, R.start_date, R.end_date, T.rental*(DATEDIFF(R.end_date,R.start_date)) as Rental_price, T.deposit, R.Pickup_clerk, R.Dropoff_clerk " .
                                                                    "FROM Reservation as R " .
                                                                    "inner join reserve on " .
                                                                    "R.reservation_number = reserve.reservation_number " .
                                                                    "inner join tool as T on " .
                                                                    "T.Tool_id = reserve.tool_ID " .
                                                                    "where R.Request_customer = '{$_SESSION['email']}'";
                                                                $resulty = mysql_query($queryy);
                                                                if (!$resulty) {

                                                                    $emptyMsg = "No transactions found.";
                                                                    print "{$emptyMsg}";
                                                                    exit();

                                                                }
                                                                while ($rowy = mysql_fetch_array($resulty)){
                                                                    print '<tr>'; 
                                                                    print '<td>'. $rowy['reservation_number']."</td>";
                                                                    print '<td>'. $rowy['abbrdesc'].'</td>';
                                                                    print '<td>'. $rowy['start_date'].'</td>';
                                                                    print '<td>'. $rowy['end_date'].'</td>';
                                                                    print '<td>'. $rowy['Rental_price'].'</td>';
                                                                    print '<td>'. $rowy['deposit'].'</td>';
                                                                    print '<td>'. $rowy['Pickup_clerk'].'</td>';
                                                                    print '<td>'. $rowy['Dropoff_clerk'].'</td>';
                                                                    print '<tr>';
                                                                }
                                                            ?>
                                                            </tbody>

							</table>
                                                        
							

						</div>
                                                <div>
                                                     <script type="text/javascript">

                                                    function submitAction(act) {
                                                         document.sample.action = act;
                                                         document.sample.submit();
                                                    }
                                                    </script>
                                                    <form name ="sample" action="Profile.php">
                                                        <br>
                                                        <input type="button" value = "Back" style="width:200px" onClick="submitAction('customerMenu.php')"></input>
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