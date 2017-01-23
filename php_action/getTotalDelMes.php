<?php 	

require_once 'core.php';


$mes = $_POST['month'];
$year = $_POST['year'];



$orderSql = "SELECT grand_total FROM orders WHERE YEAR(order_date) = $year AND MONTH(order_date) = $mes";

$orderQuery = $connect->query($orderSql);



$output = array('data' => array());

$totalRevenue = "";
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue += $orderResult['grand_total'];
}



$connect->close();

echo json_encode($totalRevenue);