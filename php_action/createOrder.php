<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');

 //print_r($valid);

if($_POST) {	


  $orderDate 						= date('Y-m-d H:i:s');
  $clientName 					= $_POST['clientName'];
  $clientContact 				= $_POST['clientContact'];
  //$subTotalValue 				= $_POST['subTotalValue'];
  //$discount 						= $_POST['discount'];
  $grandTotalValue 			= $_POST['grandTotalValue'];
  $paid 								= $_POST['paid'];
  $dueValue 						= $_POST['dueValue'];
  //$paymentType 					= $_POST['paymentType']; se quita el 18/02/2017 y se inserta por defecto con valor 0
  $paymentStatusValue 				= $_POST['paymentStatusValue'];
  $userSeller 				= $_SESSION['userId'];

  

	$sql = "INSERT INTO orders (order_date, client_name, client_contact, grand_total, paid, due, payment_type, payment_status, order_status, user_id) 
					VALUES ('$orderDate', '$clientName', '$clientContact', '$grandTotalValue', '$paid', '$dueValue', '0', '$paymentStatusValue', '1', $userSeller)";
	
	
	$order_id;
	$orderStatus = false;
	if($connect->query($sql) === true) {
		$order_id = $connect->insert_id;
		$valid['order_id'] = $order_id;	
		$orderStatus = true;
	}

		
	
	$orderItemStatus = false;

	
	//echo "<script>console.log( 'Debug Objects: " . "Cantida de productos a ingresar: " . count($_POST['barCodeValue']) . "' );</script>";
	for($x = 0; $x < count($_POST['barCodeValue']); $x++) {	
		

		 //echo "<script>console.log( 'Debug Objects: " . "INICIO" . "' );</script>";
		
		$productSQL = "SELECT a.quantity, a.product_id, a.rate, a.discount FROM product a WHERE a.bar_code = ".$_POST['barCodeValue'][$x]."";
		 //echo "<script>console.log( 'Debug Objects: sql:" . "$productSQL" . "' );</script>";
		$peoductData = $connect->query($productSQL);
		
		$productResult = $peoductData->fetch_array();	
			$updateQuantity = $productResult['quantity'] - $_POST['quantity'][$x];							
				
			 //echo "<script>console.log( 'Debug Objects: barCode:" . $_POST['barCodeValue'][$x] . "' );</script>";

			 //echo "<script>console.log( 'Debug Objects: PRODUCTO: Cantidad Original: " . $productResult[0] . " Cantidad a descontar: " . $_POST['quantity'][$x] . " Cantidad Final: " . $updateQuantity . "' );</script>";	
			// update product table
			 //echo "<script>console.log( 'Debug Objects: barCodeValue: " . $_POST['barCodeValue'][$x] . "' );</script>";	
			$updateProductTable = "UPDATE product SET quantity = ".$updateQuantity." WHERE bar_code = '".$_POST['barCodeValue'][$x]."'";
			 

			 //echo "<script>console.log( 'Debug Objects: UPDATE product SET quantity = ".$updateQuantity." WHERE bar_code = ".$_POST['barCodeValue'][$x]." ' );</script>";

			$connect->query($updateProductTable);

			

			// add into order_item
			//total = (total - (total * (Number(response.discount / 100))));
			

			$precioSinDescuento = $_POST['quantity'][$x] * $productResult['rate'];

			$totalValue = round($precioSinDescuento - ($precioSinDescuento * ($productResult['discount'] / 100)));

			 //echo "<script>console.log( 'Debug Objects: orderId: " . $order_id . "' );</script>";	
			 //echo "<script>console.log( 'Debug Objects: productId: " . $productResult['product_id'] . "' );</script>";	
			 //echo "<script>console.log( 'Debug Objects: descuento: " . $productResult['discount'] . "' );</script>";	
			 //echo "<script>console.log( 'Debug Objects: cantidad: " . $_POST['quantity'][$x] . "' );</script>";	
			 //echo "<script>console.log( 'Debug Objects: precio: " . $productResult[2] . "' );</script>";	
			 //echo "<script>console.log( 'Debug Objects: total: " . $totalValue . "' );</script>";	

			$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, discount, total, order_item_status) 
			VALUES ('$order_id', '". $productResult['product_id'] ."', '".$_POST['quantity'][$x]."', '".$productResult['rate']."', '".$productResult['discount']."' , '".$totalValue."', 1)"; 



			//echo "<script>console.log( 'Debug Objects: " . $orderItemSql . "' );</script>";	

			$connect->query($orderItemSql);		

//			 echo "<script>console.log( 'Debug Objects: COUNT BAR CODE: ".count($_POST['barCodeValue']) . "' );</script>";

			if($x == count($_POST['barCodeValue'])) {
				$orderItemStatus = true;
			}	

			//echo "<script>console.log( 'Debug Objects: " . "FIN DEL WHILE" . "' );</script>";	
		//} // while	
	} // /for quantity

	$valid['success'] = true;
	$valid['messages'] = "Venta Realizada.";		
	 //print_r($valid);
	$connect->close();
	
	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);