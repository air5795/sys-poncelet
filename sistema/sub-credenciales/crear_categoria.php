<?php

include("conexion.php");
include("funciones.php");



if ($_POST["operacion2"] == "Crear") {
    
  
    $stmt = $conexion->prepare("INSERT INTO categoria_i(nombre_categoria) VALUES(:nombre_categoria)");

    $resultado = $stmt->execute(
        array(
            ':nombre_categoria' => $_POST["nombre_categoria"]
        )
    );

    if (!empty($resultado)) {
        echo json_encode(['message' => 'Registro actualizado']);
    } else {
        echo json_encode(['error' => 'Error al actualizar el registro']);
    }
    
}



	




if ($_POST["operacion2"] == "Editar") {
  


    $stmt = $conexion->prepare("UPDATE categoria_i SET nombre_categoria=:nombre_categoria WHERE id_categoria = :id_categoria");

    $resultado = $stmt->execute(
        array(
            ':id_categoria'      => $_POST["id_categoria"],
            ':nombre_categoria'  => $_POST["nombre_categoria"]

        )

        

        
    );

    if (!empty($resultado)) {
        echo 'Registro actualizado';
    }
}