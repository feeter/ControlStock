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
				<a href="product.php" style="text-decoration:none;color:black;" data-toggle="tooltip" title="Stock menor a <?php echo $CantidadStock; ?> por producto.">
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
		  <div class="cardHeader" style="background-color:#777799;" title="Productos vendidos mas de 3 veces." data-toggle="tooltip" >
		    
			<!--<div id="piechart" style="width: 340px; height: 200px;"></div>-->
			<!--Div that will hold the dashboard-->
		    <div id="dashboard_div" style="border: 1px solid #ccc">
		      <!--Divs that will hold each control and chart-->
		      <div id="filter_div" style="font: 16px/24px Roboto,sans-serif"></div>
		      <div id="chart_div"></div>
		    </div>
			
			

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
		
		<br/>

		<div class="card">
		  <div class="cardHeader">
		    <h1><?php echo date('d'); ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p><?php echo $fecha; ?></p>
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

<script type="text/javascript" src="assests/plugins/googleChart/pieChart/loader.js"></script>
<!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
<!--<script src="https://maps.google.com/maps/api/js"></script>-->
<!--<script src="assests/plugins/googleChart/pieChart/google.js?key=AIzaSyAz3mg51Q7pnd2QV846M3E8W4ok-zeG9zk&callback"></script>-->
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAz3mg51Q7pnd2QV846M3E8W4ok-zeG9zk&callback"
  type="text/javascript"></script>-->

<script src="custom/js/dashboard.js?ver=20170318"></script>
<?php require_once 'includes/footer.php'; ?>