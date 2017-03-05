<?php 	

require_once 'core.php';

$mes = $_POST['month'];
$year = $_POST['year'];

$sql = "SELECT a.product_name Producto, SUM(b.quantity) cantidad 
FROM product a 
INNER JOIN order_item b ON a.product_id = b.product_id 
INNER JOIN orders c ON b.order_id = c.order_id 
WHERE MONTH( c.order_date ) = $mes 
AND YEAR( c.order_date ) = $year 
GROUP BY a.product_name 
HAVING cantidad > 3";


$result = $connect->query($sql);

$data = $result->fetch_all();

$connect->close();

echo json_encode($data);