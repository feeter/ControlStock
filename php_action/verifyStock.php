<?php 	

require_once 'core.php';


$barCode = $_POST['barCode'];
$toBuy = $_POST['toBuy'];
$return = true;

$sql = "SELECT quantity FROM product WHERE bar_code = $barCode";

$result = $connect->query($sql);


 while($row = $result->fetch_array()) {
    $cantRegistrada = $row[0];

    if ($toBuy > $cantRegistrada){
        $return = false;
    }

 }

$connect->close();

echo json_encode($return);