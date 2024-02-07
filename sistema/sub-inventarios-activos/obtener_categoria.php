<?php

include("conexion.php");
include("funciones.php");

if (isset($_POST["id_categoria"])) {
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM categoria_i WHERE id_categoria = '".$_POST["id_categoria"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    foreach($resultado as $fila){
        $salida["nombre_categoria"] = $fila["nombre_categoria"];
       
        
        
    }

    echo json_encode($salida);
}