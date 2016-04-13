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

/* if form was submitted, then save new data */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {



	/* validate form */
    if (empty($_POST["fname"])) {
        $errorMsg = "First Name is required";
    } 
    else {
        $name =  mysql_real_escape_string($_POST["fname"]);
      // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $errorMsg = "Only letters and white space allowed"; 
      }
    }

    if (empty($_POST["lname"])) {
        $errorMsg = "Last Name is required";
    } 
    else {
        $name =  mysql_real_escape_string($_POST["lname"]);
      // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $errorMsg = "Only letters and white space allowed"; 
      }
    }

    if (empty($_POST["email"])) {
      $errorMsg = "Email is required";
    } else {
      $email =  mysql_real_escape_string($_POST["email"]);
      // check if e-mail address is well-formed
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Invalid email format"; 
      }
    }
    
    if (empty($_POST["areacodeworkphone"])) {
        $errorMsg = "work phone number is required";
    } 
    else {
        $work_area_code =  mysql_real_escape_string($_POST["areacodeworkphone"]);
        $work_area_code = trim($work_area_code);
        if (!preg_match("/^[0-9]{3}$/",$work_area_code)) {
        $errorMsg = "Incorrect format of phone number"; 
        }
      }
    
    
    if (empty($_POST["workphonenumber"])) {
        $errorMsg = "work phone number is required";
    } 
    else {
        $work_area_code =  mysql_real_escape_string($_POST["workphonenumber"]);
        $work_area_code = str_replace(' ', '', $work_area_code);
        if (!preg_match("/^[0-9]{7}$/",$work_area_code)) {
        $errorMsg = "Incorrect format of phone number"; 
        }        
      }
    
    
    
    if (empty($_POST["areacodehomephone"])) {
        $errorMsg = "home phone number is required";
    } 
    else {
        $home_area_code =  mysql_real_escape_string($_POST["areacodehomephone"]);
        $home_area_code = str_replace(' ', '', $home_area_code);
        if (!preg_match("/^[0-9]{3}$/",$home_area_code)) {
        $errorMsg = "Incorrect format of phone number"; 
        }
      }
    
    
    if (empty($_POST["homephonenumber"])) {
        $errorMsg = "home phone number is required";
    } 
    else {
        $home_area_code =  mysql_real_escape_string($_POST["homephonenumber"]);
        $home_area_code = str_replace(' ', '', $home_area_code);
        if (!preg_match("/^[0-9]{7}$/",$home_area_code)) {
        $errorMsg = "Incorrect format of phone number"; 
        }
      }
    

    $password =  mysql_real_escape_string($_POST['password']);
    $confirmpassword =  mysql_real_escape_string($_POST['confirmpassword']);
    if ($password != $confirmpassword){
        $errorMsg = "password is not confirmed"; 
    }
    $email = mysql_real_escape_string($_POST['email']);
    $query = "SELECT * FROM CUSTOMER WHERE Username = '$email'";
    $result = mysql_query($query);
    if (mysql_num_rows($result)!=0) {
        $errorMsg = "email has been used!"; 
    }

// need to check phone number is number    
    
    
    if (empty($errorMsg)){
        $email =  mysql_real_escape_string($_POST['email']);
        $fname =  mysql_real_escape_string($_POST['fname']);
        $lname =  mysql_real_escape_string($_POST['lname']);
        $work_area_code =  mysql_real_escape_string($_POST['areacodeworkphone']);
        $work_local_number =  mysql_real_escape_string($_POST['workphonenumber']);
        $home_area_code =  mysql_real_escape_string($_POST['areacodehomephone']);
        $home_local_number =  mysql_real_escape_string($_POST['homephonenumber']);
        $address =  mysql_real_escape_string($_POST['address']);

        $query = "INSERT INTO CUSTOMER 
                (Username, password, fname, lname, work_area_code, work_local_number, home_area_code, Home_local_number, address) 
                VALUES 
                ('$email', '$password', '$fname', '$lname', '$work_area_code', '$work_local_number', '$home_area_code', '$home_local_number', '$address')";
        if (!mysql_query($query)) {

                print '<p class="error">Error: Failed to update user profile. ' . mysql_error() . '</p>';

        }    
        else{
            header('Location: login.php');
            exit();
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

		<title>handyman create Profile</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

	

	<body>



		<div id="main_container">
			
			<div class="center_content">

			

				<div class="center_left">

					<div class="features">   

						

						<div class="profile_section">

							

							<form name="profileform" action="createProfile.php" method="post">
                                                        
                                                            <div class="title"><font size="20"><b>Create Profile</b></font></div>
                                                        <br>
                                                            <div class="text"><font size="5"><b>Handyman Tools Rental requires a valid profile for every user before they make reservation.</b></font>
                                                                
                                                        </div>
                                                        <br>

							<table width="80%">

								<tr>

									<td class="item_label">Email(Login)</td>

									<td>

										<input type="text" name="email" />										

									</td>

								</tr>

								<tr>

									<td class="item_label">Password</td>

									<td>

										<input type="password" name="password" />	

									</td>

								</tr>
								<tr>

									<td class="item_label">Confirm Password</td>

									<td>

										<input type="password" name="confirmpassword" />	

									</td>

								</tr>
								<tr>

									<td class="item_label">First Name</td>

									<td>

										<input type="text" name="fname" />	

									</td>

								</tr> 
								<tr>

									<td class="item_label">Last Name</td>

									<td>

										<input type="text" name="lname" />	

									</td>

								</tr>                                                             
								<tr>

									<td class="item_label">Home Phone</td>

									<td>

										<input type="text" name="areacodehomephone" size ="3" maxlength="3"/>	
                                                                                <input type="text" name="homephonenumber" size ="10" maxlength="7"/>

									</td>

								</tr> 
								<tr>

									<td class="item_label">Work Phone</td>

									<td>

										<input type="text" name="areacodeworkphone" size ="3" maxlength="3" />
                                                                                <input type="text" name="workphonenumber" size ="10" maxlength="7"/>

									</td>

								</tr>    
								<tr>

									<td class="item_label">Address</td>

									<td>
                                                                                <textarea name="address" cols="40" rows="5" ></textarea>

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