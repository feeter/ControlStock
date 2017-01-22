<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	



  $barCode = $_POST['barCode'];

	$productName 		= $_POST['productName'];
  // $productImage 	= $_POST['productImage'];
  $quantity 			= $_POST['quantity'];
  $rate 					= $_POST['rate'];
  $brandName 			= $_POST['brandName'];
  $categoryName 	= $_POST['categoryName'];
  $productStatus 	= $_POST['productStatus'];


$var = $_POST['expirationDate'];
$date = str_replace('/', '-', $var);
$expirationDate = date('Y-m-d', strtotime($date));


//print_r($_POST);
	


	$type = explode('.', $_FILES['productImage']['name']);
	$type = $type[count($type)-1];		
	$url = '../assests/images/stock/'.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if(is_uploaded_file($_FILES['productImage']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {
				
				$sql = "INSERT INTO product (bar_code, product_name, product_image, brand_id, categories_id, quantity, rate, active, status, expiration_date) 
				VALUES ('$barCode', '$productName', '$url', '$brandName', '$categoryName', '$quantity', '$rate', '$productStatus', 1, '$expirationDate')";

				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Producto Agregado";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Ocurrio un Error";
				}

			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST