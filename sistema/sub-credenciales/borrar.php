<?php

include('conexion.php');
include("funciones.php");

if(isset($_POST["id_credencial"]))
{

	$imagen = '';


	$imagen = obtener_nombre_imagen($_POST["id_credencial"]);
	if($imagen != '')
	{
		unlink("productos/" . $imagen);
	}




	$stmt = $conexion->prepare(
		"DELETE FROM credenciales WHERE id_credencial = :id_credencial"
	);
	$resultado = $stmt->execute(
		array(
			':id_credencial'	=>	$_POST["id_credencial"]
		)
	);
	
	if(!empty($resultado))
	{
		echo 'Registro borrado';
	}
}



?>