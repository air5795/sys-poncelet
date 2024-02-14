<?php

include("conexion.php");
include("funciones.php");






if ($_POST["operacion"] == "Crear") {
    $imagen = '';
   
    if ($_FILES["foto"]["name"] != '') {
        $imagen = subir_imagen();
    }
   
    $stmt = $conexion->prepare("INSERT INTO cliente(nit, nombre, telefono, direccion, foto)
                                VALUES(:nit, :nombre, :telefono, :direccion, :foto )");

    $resultado = $stmt->execute(
        array(
            ':nit'           => $_POST["nit"],
            ':nombre'            => $_POST["nombre"],
            ':telefono'           => $_POST["telefono"],
            ':direccion'               => $_POST["direccion"],
            ':foto'             => $imagen
        )
    );

    if (!empty($resultado)) {
        echo 'Exito !! al insertar el registro en la base de datos.';
    } else {
        echo 'Error al insertar el registro en la base de datos.';
    }
}



	




if ($_POST["operacion"] == "Editar") {
    $imagen = obtener_nombre_imagen($_POST["idcliente"]);


    if ($_FILES["foto"]["name"] != '') {
        unlink("productos/" . $imagen);
         $imagen = subir_imagen();
    }
    else {

        $imagen = @$_POST['img_o'];     
    }
    




    $stmt = $conexion->prepare("UPDATE cliente SET nit=:nit, nombre=:nombre, telefono=:telefono, direccion=:direccion,foto=:foto WHERE idcliente = :idcliente");

    $resultado = $stmt->execute(
        array(
            ':idcliente'      => $_POST["idcliente"],
            ':nit'           => $_POST["nit"],
            ':nombre'            => $_POST["nombre"],
            ':telefono'           => $_POST["telefono"],
            ':direccion'               => $_POST["direccion"],
            ':foto'             => $imagen

        )

        

        
    );

    if (!empty($resultado)) {
        echo 'Exito !! al insertar el registro en la base de datos.';
    } else {
        echo 'Error al actualizar el registro en la base de datos.';
    }
}