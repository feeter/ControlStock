<?php 	

require_once 'core.php';

//echo "<script>console.log( 'Debug Objects: " . "INICIO" . "' );</script>";


$mes = $_POST['month'];
$year = $_POST['year'];
$dia = $_POST['day'];


$orderSql = "SELECT SUM(grand_total) sumaTotal FROM orders 
WHERE YEAR(order_date) = $year 
AND MONTH(order_date) = $mes 
AND DAY(order_date) = $dia 
AND order_status = 1";

$orderQuery = $connect->query($orderSql);


$orderResult = $orderQuery->fetch_assoc();



$connect->close();

echo json_encode($orderResult);