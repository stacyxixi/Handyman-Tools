<?php


error_reporting(E_ALL ^ E_DEPRECATED);

/* connect to database */	

$connect = mysql_connect("localhost", "root", "");

if (!$connect) {

	die("Failed to connect to database");

}

mysql_select_db("handyman") or die( "Unable to select database");

session_start();

if (!isset($_SESSION['clerk'])) {

	header('Location: login.php');

	exit();

}
if (!isset($_SESSION['tool_ID'])) {

	header('Location: selltool.php');
	exit();
}

$queryx ="SELECT Purchase_price " .
		 "FROM TOOL " .
		 "WHERE Tool_ID = '{$_SESSION['tool_ID']}'";                

$resultx = mysql_query($queryx);

if (!$resultx) {

	print "<p class='error'>Errorx: " . mysql_error() . "</p>";

	exit();
}

$rowx = mysql_fetch_array($resultx);
$sale_price = $rowx['Purchase_price'] * 0.5;
$formatted_sale_price = sprintf('%0.2f', $sale_price);

if (!$rowx) {

	print "<p>Error: No data returned from database.  Administrator login NOT supported.</p>";

	print "<a href='logout.php'>Logout</a>";

	exit();
}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>Handyman Sale Price</title>

		<link rel="stylesheet" type="text/css" href="style.css" />                                

	</head>	

	<body>

		<div id="main_container">

			<div class="center_content">			

				<div class="center_left">
                    
					<div class="title"><font size="5"><b><?php print "The request has been succesfully submitted. The sale price is {$formatted_sale_price}.";?> </b></font></div>
 				
                                            <div>
                                                     <script type="text/javascript">

                                                    function submitAction(act) {
                                                         document.sample.action = act;
                                                         document.sample.submit();
                                                    }
                                                    </script>
                                                    <form name ="sample" action="salePrice.php">
                                                        <br>
                                                        <input type="button" value = "Back to Clerk Menu" style="width:200px" onClick="submitAction('clerkMenu.php')"></input>
                                                    </form>
                                            </div>                                           

					 </div> 

				</div> 				

				<div class="clear"></div> 

			</div>    

		</div>

	</body>

</html>