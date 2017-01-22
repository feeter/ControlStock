<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$productId = $_POST['productId'];

if($productId) { 

	$sqlImage = "SELECT product_image FROM product WHERE product_id = $productId";

	$resultImage = $connect->query($sqlImage);
	
	$row = $resultImage->fetch_row();

	if (strpos($row[0], 'sin-image'))
	{


	}
	else
	{
		$filename = $row[0];
		if (file_exists($filename)) {
			unlink($filename);
		}
	}




 $sql = "DELETE FROM product WHERE product_id = {$productId}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Producto Eliminado";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error mientras se elimina el producto.";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST