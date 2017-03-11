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
  <meta charset="UTF-8">
  <meta http-equiv="Content-type" content="text/html; charset=UTF-8">

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

  <!-- DateTimePicker -->
  <link rel="stylesheet" href="assests/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">

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
				      	$sql = "SELECT a.page_id, a.page_TagId, a.page_name, a.page_url, a.page_class, a.isDropDown FROM page a 
                        INNER JOIN functions b ON b.page_id = a.page_id 
                        WHERE parent_node = 0 and profile_id = " . $_SESSION['profile'] . " ORDER BY a.page_order;";
                        
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {

                  if (!$row['isDropDown']){
                    echo "<li id='" . $row['page_TagId']  . "'>";
                    echo "<a href='" . $row['page_url'] . "'><i class='" . $row['page_class'] . "'></i>  " . $row['page_name'] . "</a>";
                    echo "</li>";
                  } else {
                    echo "<li class='dropdown' id='" . $row['page_TagId'] . "'>";
                    echo  "<a href='' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'> <i class='" . $row['page_class'] . "'></i> " . $row['page_name'] . " <span class='caret'></span></a>";
                    echo  "<ul class='dropdown-menu'>";

                    $sqlChild = "SELECT a.page_TagId, a.page_name, a.page_url, a.page_class FROM page a
                                INNER JOIN functions b ON b.page_id = a.page_id 
                                WHERE profile_id = " . $_SESSION['profile'] . " AND parent_node = " . $row['page_id'] . " ORDER BY a.page_order;";
                            
                    
                    $resultChild = $connect->query($sqlChild);

                    while($rowChildNode = $resultChild->fetch_array()) {

                      echo "<li id='" . $rowChildNode['page_TagId'] . "'><a href='" . $rowChildNode['page_url'] . "'> <i class='" . $rowChildNode['page_class'] . "'></i> " . $rowChildNode['page_name'] . "</a></li>";
                    }

                    


                    echo  "</ul>";
                    echo "</li>";
                  }

                  
									
								} // while
								
				      	?>

                
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
	</nav>

	<div class="container">