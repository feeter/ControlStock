<?php 	

require_once 'core.php';


$mes = $_POST['month'];
$year = $_POST['year'];



$orderSql = "SELECT SUM(grand_total) sumaTotal FROM orders WHERE YEAR(order_date) = $year AND MONTH(order_date) = $mes AND order_status = 1";

$orderQuery = $connect->query($orderSql);


$orderResult = $orderQuery->fetch_assoc();



$connect->close();

echo json_encode($orderResult);