<?php 	

require_once 'core.php';

$userId = $_POST['userId'];

$sql = "SELECT user_id, username, password, email, profile_id FROM users WHERE user_id = $userId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);