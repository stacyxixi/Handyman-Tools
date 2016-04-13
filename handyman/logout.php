<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    session_start();
    session_unset();
    session_destroy();
    if (isset($_SESSION['email'])){
        header("location:fuck.php");
    }else{
        header("location:login.php");
    }
    exit();

?>


