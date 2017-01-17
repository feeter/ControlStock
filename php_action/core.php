<?php 

session_start();

require_once 'db_connect.php';

 //echo $_SESSION['userId'];

if(!$_SESSION['userId']) {
	header('location:../index.php');	
}


$profileId = '';
$urlActual = '';
$urlActual = $_SERVER['REQUEST_URI'];
$profileId = $_SESSION['profile'];

$tieneAcceso = false;

$sqlProfile = "SELECT b.page_url FROM functions a inner join page b on a.page_id = b.page_id WHERE profile_id = $profileId;";
$result = $connect->query($sqlProfile);

while($row = $result->fetch_array()) {
	$url = $row[0];

	//echo "<script>console.log( 'Debug Objects: " .  . "' );</script>";
	if (strpos($urlActual,$url) !== false) {
		//echo "<script>console.log( 'Debug Objects: " . "SI" . "' );</script>";
		$tieneAcceso = true;
		
	}


}
//echo "<script>console.log( 'Debug Objects: " . "NO" . "' );</script>";
//   if (!$tieneAcceso){
//  	//echo "<script>console.log( 'Debug Objects: " . "SI" . "' );</script>";
//   	header('location: logout.php');
//   } else {

// }




//echo "<script>console.log( 'Debug Objects: " . $_SERVER['REQUEST_URI'] . "' );</script>";
?>