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

//$start_date = '2020-01-01';
//$end_date = '2020-01-05';
//$Tool_Type ='Hand Tools';
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (!empty($_GET['start_date'])){
            $start_date =$_GET["start_date"];
            $_SESSION['start_date'] = $start_date;
        }
    if (!empty($_GET['end_date'])) {

            $end_date =$_GET["end_date"];
            $_SESSION['end_date'] = $end_date;
	}
    if (!empty($_GET['tool1'])) {

            $tool1 =$_GET["tool1"];
            $_SESSION['tool1'] = $tool1;
            header('Location: reservationSum.php');
	}
    
    
    
    
}

//if ($_SERVER['REQUEST_METHOD'] == 'POST'){
//    if (!empty($_POST["tool1"])){
//            $_SESSION['tool1'] = $_POST["tool1"];
//            
//            exit();
//        }
//    
//    
//    
//    
//}




?>

<html>
    <head>
        
       

    </head> 
    <body>
        <h1>Make Reservation</h1>
        <form action = "makeReservation.php" method ="get">
        <table>
            <tbody>
                <tr>
                    <td>Start Date</td>
                    <td><input type = text name ="start_date"></input></td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td><input type = text name ="end_date"></input></td>
                </tr>
                <tr>
                    
                    <td><input type = submit id = "update" value = "update"></input></td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
            <th>Type of Tool</th>
            <th>Tool</th>
            </thead>
            
            <tbody id="toollist">
                
                <tr>
                    <td><select id="toolType" name="toolType"></select></td>
                    <td><select id="tool" name="tool1"></select></td>
                </tr>
                
            </tbody>
            
        </table>       
        <script src="scripts/jquery-1.12.3.min.js"></script>
        <script src ="scripts/script.js"></script>
        
        
            <input type="submit" form = "form1" value="Calculate Total"/>  
        </form>
    </body>
    
</html>