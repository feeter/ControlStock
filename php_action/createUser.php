<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

    $UserName = $_POST['tbUserName'];
    $userPass = $_POST['tbUserPass'];
    $userPass2 = $_POST['tbUserPass2'];
    $email = $_POST['tbUserEmail']; 
    $perfil = $_POST['ddlUserPerfil']; 
    

    if ($userPass == $userPass2){

        $userPass = md5($userPass);

        $sql = "INSERT INTO users (username, password, email, profile_id) VALUES ('$UserName', '$userPass', '$email', '$perfil')";

        if($connect->query($sql) === TRUE) {
            $valid['success'] = true;
            $valid['messages'] = "Usuario agregado Satisfactoriamente";	
        } else {
            $valid['success'] = false;
            $valid['messages'] = "Error mientras se agrega el usuario, favor reintentar";
        }
    } else {
         $valid['success'] = false;
        $valid['messages'] = "Error - Claves no son iguales";
    }

	


	 

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST