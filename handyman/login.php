<?php
/* 
 * Create On 4-8-2016
 * Author grunt.xbo
 */


error_reporting(E_ALL ^ E_DEPRECATED);

/* connect to database */	

$connect = mysql_connect("localhost", "root", "");

if (!$connect) {

	die("Failed to connect to database");

}

mysql_select_db("handyman") or die( "Unable to select database");



$errorMsg = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {



	if (empty($_POST['email'])){
            $errorMsg = "Please provide email.";
        }
        else if (empty($_POST['password'])) {

            $errorMsg = "Please provide password.";		
	}

	else {
		$email = mysql_real_escape_string($_POST['email']);

		$password = mysql_real_escape_string($_POST['password']);

		
                switch($_POST['radio_group1']){
                    case "customer":
                        $query = "SELECT * FROM customer WHERE Username = '$email' AND password = '$password'";
                        break;
                    case "clerk":
                        $query = "SELECT * FROM clerk WHERE Username = '$email' AND password = '$password'";
                        break;
                }
		

		$result = mysql_query($query);

		

		if (mysql_num_rows($result) == 0) {

			/* login failed */
                    switch($_POST['radio_group1']){
                        case "customer":
                            header('Location: createProfile.php');
                            break;
                        case "clerk":
                            $errorMsg = "Login failed.  Please try again.";
                            break;
                        case null:
                            $errorMsg = "Login failed.  Please try select type of user.";
                            break;
                        default:
                            $errorMsg = "Login failed.  Please try again.";
                    }
		}

		else {

			/* login successful */

			session_start();

			
                        switch($_POST['radio_group1']){
                            case "customer":
                                $_SESSION['email'] = $email;
                                header('Location: customerMenu.php');
                                break;
                            case "clerk":
                                $_SESSION['clerk'] = $email;
                                header('Location: clerkMenu.php');
                                break;
                            default:
                        }                  
			
			/* redirect to the profile page */

			

			exit();

		}

		

	}



}

  

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">

	

	<head>

		<title>HandyMan Login</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

  

	<body>



		<div id="main_container">

<!--			<div id="header">

				<div class="logo"><img src="images/HandyMan_logo.gif" border="0" alt="" title="" /></div>       

			</div>-->

     

			<div class="center_content">

			

				<div class="text_box">

		 

					<form action="login.php" method="post">

				  

						<div class="title">HandyMan Login</div>

							<div class="login_form_row">

							<label class="login_label">Login:</label>

							<input type="text" name="email" class="login_input" />

						</div>

										

						<div class="login_form_row">

							<label class="login_label">Password:</label>

							<input type="password" name="password" class="login_input" />

						</div>                                     

						
                                                <input type="radio" name="radio_group1" value="customer" checked ="checked" />customer
                                                <input type="radio" name="radio_group1" value="clerk" />clerk<br />
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