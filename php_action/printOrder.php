<?php 	

require_once 'core.php';

$orderId = $_POST['orderId'];

$sql = "SELECT order_date, client_name, client_contact, sub_total, discount, grand_total, paid, due FROM orders WHERE order_id = $orderId";
//vat, total_amount,


$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData[0];
$clientName = $orderData[1];
$clientContact = $orderData[2]; 
$subTotal = $orderData[3];
// $vat = $orderData[4];
// $totalAmount = $orderData[5]; 
$discount = $orderData[4];
$grandTotal = $orderData[5];
$paid = $orderData[6];
$due = $orderData[7];


$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
product.product_name FROM order_item
	INNER JOIN product ON order_item.product_id = product.product_id 
 WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

 $table = '
 <table border="1" cellspacing="0" cellpadding="20" width="100%">
	<thead>
		<tr >
			<th colspan="5">

			<center>
				Fecha de Venta : '.$orderDate.'
				<center>Nombre del Cliente : '.$clientName.'</center>
				Contacto : '.$clientContact.'
			</center>		
			</th>
				
		</tr>		
	</thead>
</table>
<table border="0" width="100%;" cellpadding="5" style="border:1px solid black;border-top-style:1px solid black;border-bottom-style:1px solid black;">

	<tbody>
		<tr>
			<th>Nro</th>
			<th>Producto</th>
			<th>Precio</th>
			<th>Cantidad</th>
			<th>Total</th>
		</tr>';

		$x = 1;
		while($row = $orderItemResult->fetch_array()) {			
						
			$table .= '<tr>
				<th>'.$x.'</th>
				<th>'.$row[4].'</th>
				<th>'.$row[1].'</th>
				<th>'.$row[2].'</th>
				<th>'.$row[3].'</th>
			</tr>
			';
		$x++;
		} // /while

		$table .= '<tr>
			<th></th>
		</tr>

		<tr>
			<th></th>
		</tr>

		<tr>
			<th>Sub Total</th>
			<th>'.$subTotal.'</th>			
		</tr>

		<tr>
			<th>Descuento</th>
			<th>'.$discount.'</th>			
		</tr>

		<tr>
			<th>Monto Total</th>
			<th>'.$grandTotal.'</th>			
		</tr>

		<tr>
			<th>Monto Pagado</th>
			<th>'.$paid.'</th>			
		</tr>

		<tr>
			<th>Vuelto</th>
			<th>'.$due.'</th>			
		</tr>
	</tbody>
</table>
 ';


$connect->close();

echo $table;