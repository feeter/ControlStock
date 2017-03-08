<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$userId = $_POST['userId'];

if($userId) { 

 $sql = "DELETE FROM users  WHERE user_id = $userId";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Usuario eliminado satisfactoriamente";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error mientras se realizaba la eliminacion";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST