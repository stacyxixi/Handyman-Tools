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

$username = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['start_date'])){
        $errorMsg = "Please provide start date.";
    }else {
                $name =  mysql_real_escape_string($_POST["start_date"]);
                if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$name)){
                $errorMsg = "Please provide valid start date yyyy-mm-dd"; 
                }
            }
    if (empty($_POST['end_date'])) {

        $errorMsg = "Please provide end date.";		
    }else {
                $name =  mysql_real_escape_string($_POST["end_date"]);
                if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$name)){
                $errorMsg = "Please provide valid end date yyyy-mm-dd"; 
                }
            }
    if (check_date($_POST['end_date'], $_POST['start_date'])){
        $errorMsg = "end date need to be after start date";
    }
    
    if (past_date($_POST['start_date'])){
            $errorMsg = "start date can not be before today";
        }
    
    if (empty($errorMsg)){
        switch($_POST['radio_group1']){
            case "Hand Tools":
                $Tool_Type = "Hand Tools";
                break;
            case "Construction Equipment":
                $Tool_Type = "Construction Equipment";
                break;
            case "Power Tools":
                $Tool_Type = "Power Tools";
                break;
        }
        $start_date = $_POST['start_date'];
        
        $end_date = $_POST['end_date']; 
        
        
        $_SESSION['tooltype'] = $Tool_Type;
        $_SESSION['startdate'] = $start_date;
        $_SESSION['enddate'] = $end_date;
        header('Location: ToolAvailability.php');
//        echo $_SESSION['startdate'];
    }

exit();       
}
//exit();




      




function check_date($start, $end)
{
  // Convert to timestamp
  $s = strtotime($start);
  $e = strtotime($end);

  // Check that user date is between start & end
  return ($s < $e);
}

function past_date($expdate)
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

		<title>HandyMan Check Tool Availability</title>

		<link rel="stylesheet" type="text/css" href="style.css" />

	</head>

  

	<body>



		<div id="main_container">

<!--			<div id="header">

				<div class="logo"><img src="images/HandyMan_logo.gif" border="0" alt="" title="" /></div>       

			</div>-->

     

			<div class="center_content">

			

				<div class="text_box">

		 

                                    <form action="CheckAvailability1.php" method="post">

				  

                                            <div class="title"><b>Select Tool Category</b></div>
                                                <hr>
                                                <input type="radio" name="radio_group1" value="Hand Tools" checked ="checked" />Hand Tools
                                                <br>
                                                <input type="radio" name="radio_group1" value="Construction Equipment" />Construction Equipment
                                                <br>
                                                <input type="radio" name="radio_group1" value="Power Tools" />Power Tools
                                                <hr>
                                                      
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td><label class="start_date">Start Date:</label></td>
                                                                <td><input type="text" name="start_date" class="start_date" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="end_date">End_date:</label></td>
                                                                <td><input type="text" name="end_date" class="End_date" /></td>
                                                            </tr>										

                                                        </tbody>
                                                    </table>
                                                <input type="submit" form="form1" value="Submit"/>

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