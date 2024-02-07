<?php

include("conexion.php");
include("funciones.php");

if (isset($_POST["id_credencial"])) {
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM credenciales WHERE id_credencial = '".$_POST["id_credencial"]."' LIMIT 1");
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    foreach($resultado as $fila){
        $salida["nombre"] = $fila["nombre"];
        $salida["pagina"] = $fila["pagina"];
        $salida["usuario"] = $fila["usuario"];
        $salida["password"] = $fila["password"];
       
        

        /* FOTO */ 
        if ($fila["foto"] != "") {
            $salida["foto"] = '<img src="productos/' . $fila["foto"] . '"  class="img-thumbnail" width="500" height="500" />
            <input type="hidden" name="img_o" value="'.$fila["foto"].'" />';
        }else{
            $salida["foto"] = '<div class="alert alert-danger" role="alert"> <input type="hidden" name="img_o" value="" /> <i class="bi bi-exclamation-octagon-fill"></i> Sin Foto</div>' ;
            //$salida["foto"] = '<input type="hidden" name="img_o" value="" />';
        }

       
        
        
    }

    echo json_encode($salida);
}