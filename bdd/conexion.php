<?php
$contraseña = "";
$usuario = "root";
$nombre_base_de_datos = "comercial";
try{
	$conn = new PDO('mysql:host=localhost;dbname=' . $nombre_base_de_datos, $usuario, $contraseña);
}catch(Exception $e){
	echo "Ocurrió algo con la base de datos: " . $e->getMessage();
}
?>