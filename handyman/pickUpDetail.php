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
if (!isset($_SESSION['rnumber'])) {

	header('Location: pickUp.php');

	exit();

}

$rnumber = $_SESSION['rnumber'];
$clerk = $_SESSION['clerk'];





if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['viewdetail'])) {
        if (empty($_POST['Tool_ID'])){
            $errorMsg = "Please provide tool id.";
        }
        else{
            session_start();
            $_SESSION['Tool_ID'] = $_POST['Tool_ID'];
            header('Location: tooldetails.php');
            exit();
        }

    }
    elseif (isset($_POST['complete'])) {
        if (empty($_POST['creditcard'])){
            $errorMsg = "Please provide credit card.";
        } 
        else {
            $name =  mysql_real_escape_string($_POST["creditcard"]);
            if (!preg_match("/^[0-9]{16}$/",$name)){
            $errorMsg = "Please provide valid credit card number"; 
            }
        }
        
        
        if (empty($_POST['expdate'])){
            $errorMsg = "Please provide expiration date.";
        }else {
            $name =  mysql_real_escape_string($_POST["expdate"]);
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$name)){
            $errorMsg = "Please provide valid expiration date yyyy-mm-dd"; 
            }
        }
        
        if (check_date($_POST['expdate'])){
            $errorMsg = "Credit Card Expired";
        }
        
//        to check whether the reservation is being picked up
//        $pickuped = "SELECT * FROM reservation WHERE Reservation_Number = '$rnumber' and Pickup_clerk is NULL";
//        $resultp = mysql_query($pickuped);
//        if (mysql_num_rows($resultp) == 0) {
//                $errorMsg = "Reservation was picked up.";
//        }
        
 
        if (empty($errorMsg)){
            $credit_card_number = $_POST["creditcard"];
            $Expiration_date = $_POST['expdate'];
            $Expiration_date=date('Y-m-d', strtotime($Expiration_date));
            $update_query = "UPDATE reservation SET Pickup_creditcard_number = '$credit_card_number', Pickup_creditcard_expdate = '$Expiration_date',Pickup_clerk = '$clerk' WHERE Reservation_Number = '$rnumber'";
            $resultu = mysql_query($update_query);
            header('Location: rentalContract.php');
            exit();

        }
        
        
        

    }

}

function check_date($expdate)
{
  // Convert to timestamp
  $to_check = strtotime($expdate);
  $curdate = strtotime(date("Y/m/d"));

  // Check that user date is between start & end
  return ($to_check < $curdate);
}

    
    
    



?>

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>Handyman PickUpReservation</title>

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
                                    <div class="title"><font size="5"><b>Reservation</b><?php print '  '.$rnumber; ?></font></div>
                                    <hr>
					<div class="features">   

                                                <div class="title"><font size="4"><b>Tool Required:</b></font></div>
                                                <br>
                                                
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
                                                                    $queryx = "SELECT T.tool_ID, T.abbrdesc from TOOL as T inner join reserve on T.Tool_id = reserve.tool_ID inner join RESERVATION as R on R.reservation_number = reserve.reservation_number where R.reservation_number = '$rnumber'";
                                                                    $resultx = mysql_query($queryx);
                                                                    if (!$resultx) {

                                                                        $emptyMsg = "No tools are found.";
                                                                        print "{$emptyMsg}";
                                                                        exit();

                                                                    }
                                                                    $i = 1;
                                                                    while ($rowx = mysql_fetch_array($resultx)){
                                                                        print '<tr>'; 
                                                                        print '<td align="center">'.$i.'.'."</td>";
                                                                        print '<td align="center">'.$rowx['tool_ID']."</td>";
                                                                        print '<td align="center">'.$rowx['abbrdesc']."</td>";
                                                                        print '<tr>';
                                                                        $i++;
                                                                    }
                                                                ?>
                                                            </tbody>

							</table>
                                                        
							

						</div>
                                                <?php
                                                $queryy = "SELECT sum(T.rental*(DATEDIFF(R.end_date,R.start_date))) as rent, sum(T.deposit) as depo from RESERVATION as R inner join RESERVE on R.reservation_number = reserve.reservation_number inner join tool as T on T.Tool_id = reserve.tool_ID where R.reservation_number = '$rnumber'";
                                                $resulty = mysql_query($queryy);
                                                $rowy = mysql_fetch_array($resulty)
                                                ?>
                                                <div class="text"><font size="4"><b>Deposit Required:</b><?php print $rowy['depo']; ?></font></div>
                                                <div class="text"><font size="4"><b>Estimated Cost:</b><?php print $rowy['rent']; ?></font></div>
                                                <hr>
                                                <div>
                                                    <form action= "pickUpDetail.php" method ="post">
                                                    <table width="50%">
                                                        <tbody>
                                                            <tr>
                                                                <td><label class="Tool_ID">Tool ID</label></td>
                                                                <td><input type="text" name="Tool_ID" class="Tool_ID" /></td>
                                                                <td><input type="submit" name="viewdetail" value = "view detail"/></td>
  
                                                            </tr> 
                                                        </tbody>
                                                    </table>
                                                        <hr>
                                                    <table width="50%">
                                                        <tbody>                                                            
                                                            <tr>
                                                                <td><label class="creditcard">Credit Card Number</label></td>
                                                                <td><input type="text" name="creditcard" class="login_input" /></td>
                                                            </tr> 



                                                            <tr>
                                                                <td><label class="expiration">Expiration Date</label></td>
                                                                <td><input type="text" name="expdate" class="login_input" /></td>
                                                            </tr>       

                                                            <tr>
                                                                <td><input type="submit" name="complete" value = "Complete Pick-Up"/></td>                                                                
                                                            </tr>
                                                        </tbody>
                                                    </table>                                                        
                                                    </form>
                                                    <?php

                                                    if (!empty($errorMsg)) {

                                                            print "<div class='login_form_row' style='color:red'>$errorMsg</div>";

                                                    }

                                                    ?>     
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