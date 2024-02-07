<?php

include('conexion.php');
include("funciones.php");

if(isset($_POST["id_activo"]))
{

	$imagen = '';
	$qr = '';
	/* $ficha = ''; 
	$certificados = ''; */

	$imagen = obtener_nombre_imagen($_POST["id_activo"]);
	if($imagen != '')
	{
		unlink("productos/" . $imagen);
	}

	$qr = obtener_nombre_qr($_POST["id_activo"]);
	if($qr != '')
	{
		unlink($qr);
	}
	/* $ficha = obtener_nombre_ficha($_POST["id_producto"]);
	if($ficha != '')
	{
		unlink("fichas/" . $ficha);
	}
	$certificados = obtener_nombre_certificado($_POST["id_producto"]);
	if($certificados != '')
	{
		unlink("certificados/" . $certificados);
	} */





	$stmt = $conexion->prepare(
		"DELETE FROM activos_fijos WHERE id_activo = :id_activo"
	);
	$resultado = $stmt->execute(
		array(
			':id_activo'	=>	$_POST["id_activo"]
		)
	);
	
	if(!empty($resultado))
	{
		echo 'Registro borrado';
	}
}



?>