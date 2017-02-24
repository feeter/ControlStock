<?php 

require_once 'core.php';

if($_POST) {



	list($dia, $mes, $anio) = explode('/', $_POST['startDate']); //explode es funcion split en php
	$start_date = $anio . '-' . $mes . '-' . $dia;

	
	list($dia, $mes, $anio) = explode('/', $_POST['endDate']);
	$end_date = $anio . '-' . $mes . '-' . $dia;

	//echo "<script>console.log( 'Debug Objects: Inicio:" . "$start_date" . "' );</script>";
	//echo "<script>console.log( 'Debug Objects: Final:" . "$end_date" . "' );</script>";

	$sql = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1";
	$query = $connect->query($sql);
	//echo "<script>console.log( 'Debug Objects: ' );</script>";

	$table = '
	<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<th>Fecha de Venta</th>
			<th>Nombre del Cliente</th>
			<th>Contacto</th>
			<th>Monto Venta</th>
		</tr>

		<tr>';
	

		$totalAmount = "";
		while ($result = $query->fetch_assoc()) {
			//echo "<script>console.log( 'Debug Objects: Inicio:" . "INICIO BUCLE" . "' );</script>";
			$table .= '<tr>
				<td><center>'.$result['order_date'].'</center></td>
				<td><center>'.$result['client_name'].'</center></td>
				<td><center>'.$result['client_contact'].'</center></td>
				<td><center>'.$result['grand_total'].'</center></td>
			</tr>';	
			$totalAmount += $result['grand_total'];
		}
		$table .= '
		</tr>

		<tr>
			<td colspan="3"><center>Total</center></td>
			<td><center>'.$totalAmount.'</center></td>
		</tr>
	</table>';

	echo $table;

}

?>