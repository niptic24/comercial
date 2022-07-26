<?php
//Vaciamos y destruimos las variables de sesión
$_SESSION['nombre_usuario'] = NULL;
$_SESSION['asesor'] = NULL;
$_SESSION['nusuario'] = NULL;
unset($_SESSION['nombre_usuario']);
unset($_SESSION['asesor']);
unset($_SESSION['nusuario']);
session_destroy();

//Redireccionamos a la pagina index.php
header('Location: login.php');

?>