<?php 	

require_once 'core.php';

$orderId = $_POST['orderId'];

$sql = "SELECT order_date, client_name, client_contact, sub_total, discount, grand_total, paid, due FROM orders WHERE order_id = $orderId";
//vat, total_amount,


$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData['order_date'];
$clientName = $orderData['client_name'];
$clientContact = $orderData['client_contact']; 
$subTotal = $orderData['sub_total'];
// $vat = $orderData[4];
// $totalAmount = $orderData[5]; 
$discount = $orderData['discount'];
$grandTotal = $orderData['grand_total'];
$paid = $orderData['paid'];
$due = $orderData['due'];


$orderItemSql = "SELECT a.product_id, a.rate, a.quantity, a.total,
b.product_name FROM order_item a
INNER JOIN product b ON a.product_id = b.product_id 
WHERE a.order_id = $orderId";

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
			<th>Precio Unitario</th>
			<th>Cantidad</th>
			<th>Total</th>
		</tr>';

		$x = 1;
		while($row = $orderItemResult->fetch_array()) {			
						
			$table .= '<tr>
				<th>'.$x.'</th>
				<th>'.$row['product_name'].'</th>
				<th>'.$row['rate'].'</th>
				<th>'.$row['quantity'].'</th>
				<th>'.$row['total'].'</th>
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
			<th>Sub. Total</th>
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