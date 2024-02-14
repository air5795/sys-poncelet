<?php

include('conexion.php');
include("funciones.php");

if(isset($_POST["idcliente"]))
{

	$imagen = '';


	$imagen = obtener_nombre_imagen($_POST["idcliente"]);
	if($imagen != '')
	{
		unlink("productos/" . $imagen);
	}




	$stmt = $conexion->prepare(
		"DELETE FROM cliente WHERE idcliente = :idcliente"
	);
	$resultado = $stmt->execute(
		array(
			':idcliente'	=>	$_POST["idcliente"]
		)
	);
	
	if(!empty($resultado))
	{
		echo 'Registro borrado';
	}
}



?>