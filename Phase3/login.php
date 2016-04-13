<?php

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '0523gl');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'handyman');

// Make the connection:
$dbc = mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

$errors = array(); 
//require('include/mysqli_connect.php');  //connect to the database

//mysql_select_db(DB_NAME) or die( "Unable to select database");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	
	
	//Initialize an error array
	
	// check for an email address
	if (empty($_POST['login'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$login = mysqli_real_escape_string($dbc, trim($_POST['login']));
	}

	// check for password
	if (empty($_POST['password'])){
		$errors[] = 'You forgot to enter your password.';
	} else {
		$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
	}
	
	
	// check Clerk or Customer checked, if not checked, add to error; if checked, see which one is checked
	if (!isset($_POST['user'])) {
		$errors[] = 'Please choose Clerk or Customer to log in';
	} else {
		// check which is checked 
		if ($_POST['user'] == 'clerk') {
			$table = 'clerk';
			$direction = 'clerkmainmenu';
			
			
		}
		else {
			$table = 'customer';
			$direction = 'custmainmenu';
		}
	}
	
	echo $password, $login;
	echo $errors;
//	echo "$_POST['login']<br>";
//	echo $_POST['password'];	
//	echo trim($_POST['password']);
//	echo "$_POST['user']<br>";	
	// if everything ok, go on
	if (empty($errors)) {
		$query = "SELECT * FROM $table WHERE  Password = '$password' AND Username = '$login'";
		$result = @mysqli_query($dbc, $query); // run the queryy
		//mysqli_close($dbc); // close the database connection
/*		echo "$table<br>";
		echo "$direction<br>";	
		echo "$password<br>";
		echo "$login<br>";		
		*/echo "$query";
		
		if (mysqli_num_rows($result)){ // run successful
			/*
			session_start();
			$_SESSION['login'] = $login;
			
			header("Location: $direction");
			exit();
			*/
			echo "success";
			
		} else {
			$errors[] = "No such user exists";
		}
	}
	
	
} // end of $_SERVER['REQUEST_METHOD'] == 'POST'

?>


<!DOCTYPE html>

<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="css/handystylesheet.css" >
			     
	
	</head>
	
	<body>
		<form name = "login" method = "post" action = "login.php">
		
			<p>
				<label for="login" class = "question">Login</label>
				<input id="login" name="login" type = "text" placeholder = "Enter your email address" size = 50 required autofocus />
					
			</p>
			
			<p>
				<label for="password" class = "question">Password</label>
				<input type = "Password" name="password" id="password" placeholder = "Enter your password" size = 50 required  />
					
			</p>
			
			<p class = "userchoice"> 
				<label for="clerk">Clerk</label>
				<input type = "radio" id = "clerk" name = "user" value="clerk">
				<label for="customer"> Customer</label>
				<input type = "radio" id = "customer" name = "user" value="customer">
			
			</p>
			
			<div>
				<input type = "submit" value = "Enter" class="submit">
			</div>
		
		
		
		</form>
		<?php
		
			if (!empty($errors)) {
				echo '<h3>Error!</h3>';
				foreach ($errors as $msg){
					echo "- $msg<br>\n";
				}
				
			}
		?>
	
	
	</body>

</html>