<?php

include('conexion.php');
include("funciones.php");

if(isset($_POST["id_asistencia"]))
{
    date_default_timezone_set('America/La_Paz');
    $salida = date("Y-m-d H:i:s");

    $stmt = $conexion->prepare("UPDATE asis SET salida = :salida, estado = 2 WHERE id_asistencia = :id_asistencia and estado = 1 ;");
	
	$resultado = $stmt->execute(
		array(
			':id_asistencia'	=>	$_POST["id_asistencia"],
            ':salida'           =>  $salida,

		)
	);
	
	if ($stmt->rowCount() > 0) {
        echo 'Registro salida';
    } else {
        http_response_code(400); // Código de respuesta HTTP para indicar un error
        echo 'Ya Registro su salida .';
    }
}



?>