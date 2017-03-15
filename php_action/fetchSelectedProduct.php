<?php 	

require_once 'core.php';

//Utilizado en pagina de Venta y Mantenedor de Productos

//echo "<script>console.log( 'Debug Objects: product ID: sss' );</script>";

$productName = $_POST['productName'];
$barCode = $_POST['barCode'];

$productId = $_POST['productId'];
  
$sql = "SELECT 
product_id, 
bar_code, 
product_name, 
product_image, 
brand_id, 
categories_id, 
quantity,
rate,
active,
status,
bar_code,
expiration_date,
discount
FROM product 
WHERE (bar_code = '$barCode' ) 
OR (product_name = '$productName')
OR (product_id = '$productId')";



$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

//echo "<script>console.log( 'Debug Objects: product nombreee:  " . $row[2] . " ' );</script>";

$connect->close();

echo json_encode($row);