<?php 	

require_once 'core.php';


$productName = $_POST['productName'];
$barCode = $_POST['barCode'];
  

$sql = "SELECT bar_code, product_name, product_image, brand_id, categories_id, quantity, rate, active, status, bar_code, expiration_date 
FROM product 
WHERE (bar_code = '$barCode' ) 
OR (product_name = '$productName')";




$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);