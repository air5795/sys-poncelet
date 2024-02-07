<?php

include("conexion.php");
include("funciones.php");

if (isset($_POST["id_activo"])) {
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM activos_fijos WHERE id_activo = '".$_POST["id_activo"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    foreach($resultado as $fila){
        $salida["nombre"] = $fila["nombre"];
        $salida["categoria"] = $fila["categoria"];
        $salida["responsable"] = $fila["responsable"];
        $salida["ubicacion"] = $fila["ubicacion"];
        $salida["estado"] = $fila["estado"];
        $salida["observacion"] = $fila["observacion"];
        

        /* FOTO */ 
        if ($fila["foto"] != "") {
            $salida["foto"] = '<img src="productos/' . $fila["foto"] . '"  class="img-thumbnail" width="150" height="150" />
            <input type="hidden" name="img_o" value="'.$fila["foto"].'" />';
        }else{
            $salida["foto"] = '<div class="alert alert-danger" role="alert"> <input type="hidden" name="img_o" value="" /> <i class="bi bi-exclamation-octagon-fill"></i> Sin Foto</div>' ;
            //$salida["foto"] = '<input type="hidden" name="img_o" value="" />';
        }

       
        
        
    }

    echo json_encode($salida);
}