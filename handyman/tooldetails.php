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

if (!isset($_SESSION['email']) and !isset($_SESSION['clerk'])) {

	header('Location: login.php');

	exit();

}

$Tool_ID = $_SESSION['Tool_ID'];

$query = "SELECT T.Tool_ID, T.AbbrDesc, T.FullDesc, T.Purchase_Price, T.Deposit, T.Rental, A.ACCESSORIES From TOOL AS T LEFT JOIN accessories AS A ON T.Tool_ID = A.Tool_ID WHERE T.Tool_ID = '$Tool_ID'";

$result = mysql_query($query);

if (!$result) {

    $emptyMsg = "No tool found.";
    print "{$emptyMsg}";
//    exit();

} 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['email'])){
        header('Location: customerMenu.php');
    }
    if (isset($_SESSION['clerk'])){
        header('Location: pickUpDetail.php');
    }
    
    
    exit();
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
                                    <div class="title"><font size="5"><b>Tool Details</b></font></div>
					<div class="features">   
						<div class="trasaction_section">

							

							<table class="transaction" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tool ID</th>
                                                                    <th>Abbr. Description</th>
                                                                    <th>Full Description</th>
                                                                    <th>Purchase Price</th>
                                                                    <th>Deposit ($)</th>
                                                                    <th>Price/Day ($)</th>
                                                                    <th>Accessories</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                            <?php
                                                                while ($rowx = mysql_fetch_array($result)){
                                                                    print '<tr>'; 
                                                                    print '<td>'. $rowx['Tool_ID']."</td>";
                                                                    print '<td>'. $rowx['AbbrDesc'].'</td>';
                                                                    print '<td>'. $rowx['FullDesc'].'</td>';
                                                                    print '<td>'. $rowx['Purchase_Price'].'</td>';
                                                                    print '<td>'. $rowx['Deposit'].'</td>';
                                                                    print '<td>'. $rowx['Rental'].'</td>';
                                                                    print '<td>'. $rowx['ACCESSORIES'].'</td>';
                                                                    print '<tr>';
                                                                }
                                                            ?>
                                                            </tbody>

							</table>
                                                        
							

						</div>
                                            <br></br>
                                            <hr>
                                                <div>
                                                    <form name ="sample" action="tooldetails.php" method = "post">
                                                        <br>
                                                        <input type="submit" name= "back_to_main" value = "Back"></input>
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