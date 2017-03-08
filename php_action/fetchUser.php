<?php 	

require_once 'core.php';

$sql = "SELECT a.user_id, a.username, a.email, b.profile_name FROM users a INNER JOIN profile b ON a.profile_id = b.profile_id;";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

    while($row = $result->fetch_array()) {
 	    $userId = $row['user_id'];

        $button = '<!-- Single button -->
        <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Acciones <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="" type="button" data-toggle="modal" data-target="#editUserModel" onclick="editBrands('.$userId.')"> <i class="glyphicon glyphicon-edit"></i> Editar</a></li>
            <li><a href="" type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeBrands('.$userId.')"> <i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>       
        </ul>
        </div>';

        $output['data'][] = array( 		
            $row['username'], 		
            $row['email'],
            $row['profile_name'],
            $button
            ); 	
    } //WHILE
} //IF



$connect->close();

echo json_encode($output);