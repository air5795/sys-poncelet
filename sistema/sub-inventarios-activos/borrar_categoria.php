<?php

include('conexion.php');
include("funciones.php");

if(isset($_POST["id_categoria"]))
{


	$stmt = $conexion->prepare(
		"DELETE FROM categoria_i WHERE id_categoria = :id_categoria"
	);
	$resultado = $stmt->execute(
		array(
			':id_categoria'	=>	$_POST["id_categoria"]
		)
	);
	
	if(!empty($resultado))
	{
		echo 'Registro borrado';
	}
}



?>