<?php 

session_start();

require_once 'db_connect.php';

 //echo $_SESSION['userId'];
date_default_timezone_set('America/Santiago');  
if(!$_SESSION['userId']) {
	header('location:../index.php');	
}






//echo "<script>console.log( 'Debug Objects: " . $_SERVER['REQUEST_URI'] . "' );</script>";
?>