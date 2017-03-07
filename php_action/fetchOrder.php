<?php 	

require_once 'core.php';

$sql = "SELECT a.order_id, a.order_date, a.grand_total, b.username FROM orders a 
inner join users b on a.user_id = b.user_id
WHERE order_status = 1";

$result = $connect->query($sql);



$output = array('data' => array());

if($result->num_rows > 0) { 
 
 $x = 1;

 while($row = $result->fetch_array()) {
 	$orderId = $row[0];

 	$countOrderItemSql = "SELECT count(order_item_id) FROM order_item WHERE order_id = $orderId";
 	$itemCountResult = $connect->query($countOrderItemSql);
 	$itemCountRow = $itemCountResult->fetch_row();


 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Acciones <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a href="orders.php?o=editOrd&i='.$orderId.'" id="editOrderModalBtn"> <i class="glyphicon glyphicon-edit"></i> Editar</a></li>
	    
	    <!--<li><a href="#" type="button" data-toggle="modal" id="paymentOrderModalBtn" data-target="#paymentOrderModal" onclick="paymentOrder('.$orderId.')"> <i class="glyphicon glyphicon-save"></i> Abono</a></li>-->

	    <li><a href="#" type="button" onclick="printOrder('.$orderId.')"> <i class="glyphicon glyphicon-print"></i> Imprimir </a></li>
	    
	    <li><a href="#" type="button" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeOrder('.$orderId.')"> <i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>       
	  </ul>
	</div>';		


	$var = $row['order_date'];
	$date = str_replace('-', '/', $var);
	$orderDate = date('d/m/Y G:i:s', strtotime($date));

 	$output['data'][] = array( 		
		 $orderId, // order id
		$orderDate, // Fecha de Venta
 		$row['grand_total'],  // Monto Total de la venta
 		$itemCountRow, 		 	
		 $row['username'], //Nombre del vendedor
 		$button // button
 		); 	
 	$x++;
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);