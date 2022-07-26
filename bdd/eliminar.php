<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("DELETE FROM personas WHERE id = ?;");
$resultado = $sentencia->execute([$id]);
if($resultado === TRUE){ echo "Eliminado correctamente";
header( "Refresh:2; url=listarPersonasConBusqueda.php", true, 303);
}else{ echo "Algo salió mal";}
?>