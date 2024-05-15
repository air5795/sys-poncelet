<?php

include('conexion.php');
include("funciones.php");

if(isset($_POST["id_inv"]))
{

	$imagen = '';
	

	$imagen = obtener_nombre_imagen($_POST["id_inv"]);
	if($imagen != '')
	{
		unlink("inventario/" . $imagen);
	}
	





	$stmt = $conexion->prepare(
		"DELETE FROM inventario WHERE id_inv = :id_inv"
	);
	$resultado = $stmt->execute(
		array(
			':id_inv'	=>	$_POST["id_inv"]
		)
	);
	
	if(!empty($resultado))
	{
		echo 'Registro borrado';
	}
}



?>