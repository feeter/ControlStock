<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {
	$productId = $_POST['productId'];
	$productName 		= $_POST['editProductName']; 
  $quantity 			= $_POST['editQuantity'];
  $rate 					= $_POST['editRate'];
  $brandName 			= $_POST['editBrandName'];
  $categoryName 	= $_POST['editCategoryName'];
  $productStatus 	= $_POST['editProductStatus'];

  $barCode       = $_POST['editBarCode'];
  $descuento       = $_POST['editDescuento'];
  $varDate = $_POST['editExpirationDate'];
  
  //print_r($_POST);

  

  
  if (!empty($varDate)){
    $date = str_replace('/', '-', $varDate);
    $expirationDate = date('Y-m-d', strtotime($date));
  }
  $expirationDate = !empty($expirationDate) ? "'$expirationDate'" : "NULL";

	echo "<script>console.log( 'Debug Objects: $expirationDate' );</script>";

	$sql = "UPDATE product 
  SET product_name = '$productName', 
  brand_id = '$brandName', 
  categories_id = '$categoryName', 
  quantity = '$quantity', 
  rate = '$rate', 
  active = '$productStatus', 
  status = 1, 
  bar_code = '$barCode', 
  expiration_date = $expirationDate,
  discount = $descuento
  WHERE product_id = $productId ";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Actualizacion realizada.";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error mientras se actualiza la informacion del producto.";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);
 
