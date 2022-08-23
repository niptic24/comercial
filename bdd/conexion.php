<?php
/*
$contraseña = "Listo.123";
$usuario = "u717963070_root";
$nombre_base_de_datos = "u717963070_comercial";*/
$contraseña = "";
$usuario = "root";
$nombre_base_de_datos = "comercial";
try{
	$conn = new PDO('mysql:host=localhost;dbname=' . $nombre_base_de_datos, $usuario, $contraseña);
}catch(Exception $e){
	echo "Ocurrió algo con la base de datos: " . $e->getMessage();
}
?>