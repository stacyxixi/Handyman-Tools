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
?>