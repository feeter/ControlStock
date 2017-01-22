<?php require_once 'php_action/core.php'; 



$urlActual = $_SERVER['REQUEST_URI'];
$profileId = $_SESSION['profile'];

$tieneAcceso = false;

$sqlProfile = "SELECT b.page_url FROM functions a inner join page b on a.page_id = b.page_id WHERE profile_id = $profileId;";
$result = $connect->query($sqlProfile);

while($row = $result->fetch_array()) {
	$url = $row[0];

	//echo "<script>console.log( 'Debug Objects: " .  . "' );</script>";
	if (strpos($urlActual,$url) !== false) {
		//echo "<script>console.log( 'Debug Objects: " . "SI" . "' );</script>";
		$tieneAcceso = true;
		
	}


}
  //echo "<script>console.log( 'Debug Objects: " . "NO" . "' );</script>";
  if (!$tieneAcceso){
 	//echo "<script>console.log( 'Debug Objects: " . "SI" . "' );</script>";
  	header('location: logout.php');
  }


?>

<!DOCTYPE html>
<html>
<head>

	<title>Sistema de almacenamiento de Stock</title>

	<!-- bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="custom/css/custom.css">

	<!-- DataTables -->
  <link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">

  <!-- file input -->
  <link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">

  <!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
  <!-- jquery ui -->  
  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  
  
  


</head>
<body>


	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- <a class="navbar-brand" href="#">Brand</a> -->
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">      

        <ul class="nav navbar-nav navbar-right">     


        <?php
       if ($_SESSION['profile'] == 2){
        ?>
          <li class="dropdown" id="navOrder">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-shopping-cart"></i> Ventas <span class="caret"></span></a>
            <ul class="dropdown-menu">            
              <li id="topNavAddOrder"><a href="orders.php?o=add"> <i class="glyphicon glyphicon-plus"></i> Vender</a></li>            
              
            </ul>
          </li> 

          <li class="dropdown" id="navSetting">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
            <ul class="dropdown-menu">            
              <li id="topNavSetting"><a href="setting.php"> <i class="glyphicon glyphicon-wrench"></i> Configuraciones</a></li>            
              <li id="topNavLogout"><a href="logout.php"> <i class="glyphicon glyphicon-log-out"></i> Salir</a></li>            
            </ul>
          </li>   
      <?php
       }else{
      ?>

        
          <li id="navDashboard"><a href="index.php"><i class="glyphicon glyphicon-list-alt"></i>  Informe</a></li>        
          
          <li id="navBrand"><a href="brand.php"><i class="glyphicon glyphicon-btc"></i>  Marcas</a></li>        

          <li id="navCategories"><a href="categories.php"> <i class="glyphicon glyphicon-th-list"></i> Categorias</a></li>        

          <li id="navProduct"><a href="product.php"> <i class="glyphicon glyphicon-ruble"></i> Productos </a></li>     

          <li class="dropdown" id="navOrder">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-shopping-cart"></i> Ventas <span class="caret"></span></a>
            <ul class="dropdown-menu">            
              <li id="topNavAddOrder"><a href="orders.php?o=add"> <i class="glyphicon glyphicon-plus"></i> Vender</a></li>            
              <li id="topNavManageOrder"><a href="orders.php?o=manord"> <i class="glyphicon glyphicon-edit"></i> Administrar ventas</a></li>            
            </ul>
          </li> 

          <li id="navReport"><a href="report.php"> <i class="glyphicon glyphicon-check"></i> Reportes </a></li>

          <li class="dropdown" id="navSetting">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
            <ul class="dropdown-menu">            
              <li id="topNavSetting"><a href="setting.php"> <i class="glyphicon glyphicon-wrench"></i> Configuraciones</a></li>            
              <li id="topNavLogout"><a href="logout.php"> <i class="glyphicon glyphicon-log-out"></i> Salir</a></li>            
            </ul>
          </li>   
      <?php

       }
        ?>   

                
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
	</nav>

	<div class="container">