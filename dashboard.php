<?php 
require_once 'includes/header.php'; 
date_default_timezone_set('America/Santiago'); //puedes cambiar Guayaquil por tu Ciudad
setlocale(LC_TIME, 'spanish');
$fecha=strftime("%A, %d de %B de %Y");
?>

<?php 

$sql = "SELECT COUNT(product_id) cantProductos FROM product WHERE status = 1";
$sqlQuery = $connect->query($sql);
$sqlResult = $sqlQuery->fetch_assoc();
$countProduct = $sqlResult['cantProductos'];


$OrderSql = "SELECT SUM(grand_total) SumaTotal, COUNT(order_id) CantidadTotal FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($OrderSql);
$orderResult = $orderQuery->fetch_assoc();

$totalRevenue = $orderResult['SumaTotal'];
$countOrder = $orderResult['CantidadTotal'];


$CantidadStock = 3;

$lowStockSql = "SELECT COUNT(product_id) CantidadProducto FROM product WHERE quantity < $CantidadStock AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$lowStockResult = $lowStockQuery->fetch_assoc();
$countLowStock = $lowStockResult['CantidadProducto'];

$Dias = 31;

$soonStockExpireSql = "SELECT COUNT(product_id) CantProdToExpire FROM product WHERE expiration_date >= CURDATE() and expiration_date <= date_add(curdate(), interval $Dias day) AND status = 1";
$soonStockExpireQuery = $connect->query($soonStockExpireSql);
$soonStockExpireResult = $soonStockExpireQuery->fetch_assoc();
$countStockExpire = $soonStockExpireResult['CantProdToExpire'];

$connect->close();

?>


<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}
</style>

<!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">


<div class="row">
	
	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				
				<a href="product.php" style="text-decoration:none;color:black;">
					Cantidad de Productos
					<span class="badge pull pull-right"><?php echo $countProduct; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

		<div class="col-md-4">
			<div class="panel panel-info">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Cantidad de Ventas
					<span class="badge pull pull-right"><?php echo $countOrder; ?></span>
				</a>
					
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
		</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<a href="product.php" style="text-decoration:none;color:black;" data-toggle="tooltip" title="Cantidad menor a <?php echo $CantidadStock; ?>.">
					Bajo Stock
					<span class="badge pull pull-right"><?php echo $countLowStock; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->




	<div class="col-md-4">

			
		<div class="panel panel-warning">
			<div class="panel-heading">
				
				<a href="product.php" style="text-decoration:none;color:black;" data-toggle="tooltip" title="Productos a expirar en <?php echo $Dias ?> dias.">
					Productos pronto a expirar
					<span class="badge pull pull-right"><?php echo $countStockExpire; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	

		<div class="card">
		  <div class="cardHeader">
		    <h1><?php echo date('d'); ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p><?php echo $fecha; ?></p>
		  </div>
		</div> 
		<br/>

		<div class="card">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h1><?php if($totalRevenue) {
		    	echo $totalRevenue;
		    	} else {
		    		echo '0';
		    		} ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p> <i class="glyphicon glyphicon-usd"></i> Cantidad de Ingresos</p>
		  </div>
		</div> 

	</div>

	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading"> <i class="glyphicon glyphicon-calendar"></i> Calendario</div>
			<div class="panel-body">
				<div id="calendar"></div>
			</div>	
		</div>
		
	</div>

	
</div> <!--/row-->

<!-- fullCalendar 3.1.0 -->
<script src="assests/plugins/fullcalendar/lib/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src='assests/plugins/fullcalendar/locale/es.js'></script>

<script src="custom/js/dashboard.js"></script>
<?php require_once 'includes/footer.php'; ?>