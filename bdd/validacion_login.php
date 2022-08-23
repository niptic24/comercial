<?php 

session_start();

include('../bdd/conexion.php');

global $conexion;


    $_SESSION['nusuario']= $_POST['usuario'];
	$username = $_POST['usuario'];
	$password = $_POST['pwd'];
//user
	$statement = $conn->prepare("SELECT * FROM usuarios  WHERE username = ? ");
	$statement->execute([ $username]);
	$user = $statement 	-> fetchAll(PDO::FETCH_ASSOC);
	
	foreach($user as $usuariob):

	  $_SESSION['rol']=$usuariob['rol'];
		endforeach;
   

//validacion inicio de sesion
$sql = "SELECT * FROM usuarios WHERE username = ? AND pass = ? LIMIT 1";
$stmtselect = $conn->prepare($sql);
$result = $stmtselect->execute([$username, $password]);


if($result){
	$user = $stmtselect->fetch(PDO::FETCH_ASSOC);
	if($stmtselect->rowCount()==0){
		echo '<script language="javascript">alert("Error de autentificacion");window.location.href=" ../../comercial/login.php"</script>';
		
	
	}
	else if (($stmtselect->rowCount()>0) and $_SESSION['rol']== 'comercial' ) {
        $_SESSION['userlogin'] = $user;
        
        $_SESSION['expira'] = $_SESSION['inicio'] + (5 * 60);
        
        header('Location: ../../comercial/comercial/indexcomercial.php');
	}elseif (($stmtselect->rowCount()>0) and $_SESSION['rol']== 'gerencia' ){
		$_SESSION['userlogin'] = $user;
        
        $_SESSION['expira'] = $_SESSION['inicio'] + (5 * 60);
        
        header('Location: ../../comercial/gerencia/indexgerencia.php');
		
	}
}else{
	header('Location: ../../comercial/comercial/login.php');
 
}

