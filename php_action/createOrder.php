<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');

 //print_r($valid);

if($_POST) {	


  $orderDate 						= date('Y-m-d H:i:s');
  $clientName 					= $_POST['clientName'];
  $clientContact 				= $_POST['clientContact'];
  $subTotalValue 				= $_POST['subTotalValue'];
  //$vatValue 						=	$_POST['vatValue'];
  //$totalAmountValue     = $_POST['totalAmountValue'];
  $discount 						= $_POST['discount'];
  $grandTotalValue 			= $_POST['grandTotalValue'];
  $paid 								= $_POST['paid'];
  $dueValue 						= $_POST['dueValue'];
  $paymentType 					= $_POST['paymentType'];
  $paymentStatusValue 				= $_POST['paymentStatusValue'];

  

	$sql = "INSERT INTO orders (order_date, client_name, client_contact, sub_total, discount, grand_total, paid, due, payment_type, payment_status, order_status) VALUES ('$orderDate', '$clientName', '$clientContact', '$subTotalValue', '$discount', '$grandTotalValue', '$paid', '$dueValue', $paymentType, $paymentStatusValue, 1)";
	
	
	$order_id;
	$orderStatus = false;
	if($connect->query($sql) === true) {
		$order_id = $connect->insert_id;
		$valid['order_id'] = $order_id;	

		$orderStatus = true;
	}

		
	
	$orderItemStatus = false;

	

	for($x = 0; $x < count($_POST['barCodeValue']); $x++) {	
		

		// echo "<script>console.log( 'Debug Objects: " . "INICIO" . "' );</script>";
		
		$updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.bar_code = ".$_POST['barCodeValue'][$x]."";
		// echo "<script>console.log( 'Debug Objects: sql:" . "$updateProductQuantitySql" . "' );</script>";
		$updateProductQuantityData = $connect->query($updateProductQuantitySql);
		
		$updateProductQuantityResult = $updateProductQuantityData->fetch_row();	
		//while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
			$updateQuantity = $updateProductQuantityResult[0] - $_POST['quantity'][$x];							
				
			// echo "<script>console.log( 'Debug Objects: barCode:" . $_POST['barCodeValue'][$x] . "' );</script>";
			
			// echo "<script>console.log( 'Debug Objects: cantidad Actualizada: " . $updateQuantity . "' );</script>";	
			// update product table
			// echo "<script>console.log( 'Debug Objects: barCodeValue: " . $_POST['barCodeValue'][$x] . "' );</script>";	
			$updateProductTable = "UPDATE product SET quantity = '".$updateQuantity."' WHERE bar_code = \'".$_POST['barCodeValue'][$x]."\'";
			// echo "<script>console.log( 'Debug Objects: SQL: UPDATE product SET quantity = $updateQuantity WHERE bar_code = \'" . $_POST['barCodeValue'][$x] . "\' ' );</script>";

			$connect->query($updateProductTable);

			

			// add into order_item

			// echo "<script>console.log( 'Debug Objects: orderId: " . $order_id . "' );</script>";	
			// echo "<script>console.log( 'Debug Objects: productId: " . $_POST['productIdValue'][$x] . "' );</script>";	
			// echo "<script>console.log( 'Debug Objects: quantity: " . $_POST['quantity'][$x] . "' );</script>";	
			// echo "<script>console.log( 'Debug Objects: rate: " . $_POST['rateValue'][$x] . "' );</script>";	
			// echo "<script>console.log( 'Debug Objects: total: " . $_POST['totalValue'][$x] . "' );</script>";	

			$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status) 
			VALUES ('$order_id', '".$_POST['productIdValue'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)"; 



			//echo "<script>console.log( 'Debug Objects: " . $orderItemSql . "' );</script>";	

			$connect->query($orderItemSql);		

			// echo "<script>console.log( 'Debug Objects: COUNT BAR CODE: ".count($_POST['barCodeValue']) . "' );</script>";

			if($x == count($_POST['barCodeValue'])) {
				$orderItemStatus = true;
			}	

			//echo "<script>console.log( 'Debug Objects: " . "fin del while" . "' );</script>";	
		//} // while	
	} // /for quantity

	$valid['success'] = true;
	$valid['messages'] = "Venta Realizada.";		
	 //print_r($valid);
	$connect->close();
	
	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);