<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	



  $barCode = $_POST['barCode'];

	$productName 		= $_POST['productName'];
  // $productImage 	= $_POST['productImage'];
  $quantity 			= $_POST['quantity'];
  $rate 					= $_POST['rate'];
  $brandName 			= "0"; //$_POST['brandName'];
  $categoryName 	= "0"; //$_POST['categoryName'];
  $productStatus 	= "1"; //$_POST['productStatus'];

  $descuento 	= "0"; //$_POST['descuento'];

$varDate = $_POST['expirationDate'];


//echo "<script>console.log( 'Debug Objects: fecha de expiracion: " . "$varDate" . "' );</script>";

if (!empty($varDate)){
	$date = str_replace('/', '-', $varDate);
	$expirationDate = date('Y-m-d', strtotime($date));
}



$expirationDate = !empty($expirationDate) ? "'$expirationDate'" : "NULL";


//echo "<script>console.log( 'Debug Objects: fecha de expiracion: " . "$expirationDate" . "' );</script>";

//print_r($_POST);
	
	
	$type = explode('.', $_FILES['productImage']['name']);
	$type = $type[count($type)-1];		
	$url = '../assests/images/stock/'.uniqid(rand()).'.'.$type;


	if($_FILES['productImage']['size'] == 0) {
		// No file was selected for upload, your (re)action goes here
		$type = "png";
		$url = "../assests/images/photo_default.png";
	}

	//echo "<script>console.log( 'Debug Objects: $type ' );</script>";

	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		//echo "<script>console.log( 'Debug Objects: tipo del archivo: $type' );</script>";

		//if(is_uploaded_file($_FILES['productImage']['tmp_name'])) {			
			//echo "<script>console.log( 'Debug Objects: is_uploaded_file' );</script>";

			//if(move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {
				
				//echo "<script>console.log( 'Debug Objects: move_uploaded_file' );</script>";

				$sql = "INSERT INTO product (bar_code, product_name, product_image, brand_id, categories_id, quantity, rate, active, status, expiration_date, discount) 
				VALUES ('$barCode', '$productName', '$url', '0', '0', '$quantity', '$rate', '1', 1, $expirationDate, 0)";

				//echo "<script>console.log( 'Debug Objects: $expirationDate' );</script>";

				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Producto Agregado";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Ocurrio un Error";
				}

			//}	else {
			//	return false;
			//}	// /else	
		//} // if
	} // if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST