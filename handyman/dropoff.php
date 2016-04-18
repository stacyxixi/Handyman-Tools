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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {



	if (empty($_POST['rnumber'])){
            $errorMsg = "Please provide reservation number.";
        }
        else{
            $rnumber = mysql_real_escape_string($_POST['rnumber']);
            $clerk = mysql_real_escape_string($_SESSION['clerk']);
            $query = "SELECT * FROM reservation WHERE Reservation_Number = '$rnumber'";
            $result = mysql_query($query);

            if (mysql_num_rows($result) == 0) {
                $errorMsg = "Reservation not exist, please try again.";
            }
//            $dropoff = "SELECT * FROM reservation WHERE Reservation_Number = '$rnumber' and Dropoff_clerk is NULL";
//            $resultd = mysql_query($dropoff);
//            if (mysql_num_rows($resultd) == 0) {
//                $errorMsg = "Reservation was dropped off.";
//            }
            
            if (empty($errorMsg)) {

			/* login successful */
                $queryx = "UPDATE RESERVATION SET Dropoff_clerk = '$clerk' WHERE Reservation_Number = '$rnumber'"; 
                $resultx = mysql_query($queryx);

                
                $_SESSION['rnumber'] = $rnumber;
                header('Location: rentalreceipt.php');


                /* redirect to the profile page */



                exit();

		}
        }
    }
?>

<html xmlns="http://www.w3.org/1999/xhtml">

	

	<head>

		<title>HandyMan Drop-Off Reservation</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

  

	<body>



		<div id="main_container">

<!--			<div id="header">

				<div class="logo"><img src="images/HandyMan_logo.gif" border="0" alt="" title="" /></div>       

			</div>-->

     

			<div class="center_content">

			

				<div class="text_box">

		 

					<form action="dropoff.php" method="post">

				  

						<div class="title">HandyMan DropOff Reservation</div>

							<div class="reservation_form_row">

							<label class="reservation_label">Reservation Number:</label>

							<input type="text" name="rnumber" class="reservation_number_input" />

						</div>

                                                <input type="submit" form="form1" value="Enter"/>                             

				  

					<form/>

				  

					<?php

					if (!empty($errorMsg)) {

						print "<div class='login_form_row' style='color:red'>$errorMsg</div>";

					}

					?>                    

						   

				</div>

			

				<div class="clear"><br/></div> 

			   

			</div>    


		</div>

	</body>

</html>