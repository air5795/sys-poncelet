<?php

include("conexion.php");
include("funciones.php");

require 'phpqrcode/qrlib.php';




if ($_POST["operacion"] == "Crear") {
    $imagen = '';
    /* $ficha = '';
    $certificado = ''; */
    if ($_FILES["foto"]["name"] != '') {
        $imagen = subir_imagen();
    }
   /*  if ($_FILES["ficha"]["name"] != '') {
        $ficha = subir_ficha();
    }
    if ($_FILES["certificado"]["name"] != '') {
        $certificado = subir_certificado();
    } */
    $stmt = $conexion->prepare("INSERT INTO activos_fijos(nombre, categoria, responsable, ubicacion, estado, observacion, foto)
                                VALUES(:nombre, :categoria, :responsable, :ubicacion, :estado, :observacion, :foto )");

    $resultado = $stmt->execute(
        array(
            ':nombre'           => $_POST["nombre"],
            ':categoria'            => $_POST["categoria"],
            ':responsable'           => $_POST["responsable"],
            ':ubicacion'               => $_POST["ubicacion"],
            ':estado'               => $_POST["estado"],
            ':observacion'             => $_POST["observacion"],
            ':foto'             => $imagen
        )
    );

    if (!empty($resultado)) {
        // Obtener el ID del activo fijo recién insertado
        $lastInsertedID = $conexion->lastInsertId();

        // Llamar a la función para generar y actualizar el código QR
        generarActualizarQR($conexion, $lastInsertedID, $_POST["nombre"], $_POST["categoria"], $_POST["responsable"], $_POST["ubicacion"], $_POST["observacion"]);
    } else {
        echo 'Error al insertar el registro en la base de datos.';
    }
}



	




if ($_POST["operacion"] == "Editar") {
    $imagen = obtener_nombre_imagen($_POST["id_activo"]);


    if ($_FILES["foto"]["name"] != '') {
        unlink("productos/" . $imagen);
         $imagen = subir_imagen();
    }
    else {

        $imagen = @$_POST['img_o'];     
    }
    




    $stmt = $conexion->prepare("UPDATE activos_fijos SET nombre=:nombre, categoria=:categoria, responsable=:responsable, ubicacion=:ubicacion, estado=:estado, observacion=:observacion, 
    foto=:foto WHERE id_activo = :id_activo");

    $resultado = $stmt->execute(
        array(
            ':id_activo'      => $_POST["id_activo"],
            ':nombre'           => $_POST["nombre"],
            ':categoria'            => $_POST["categoria"],
            ':responsable'           => $_POST["responsable"],
            ':ubicacion'               => $_POST["ubicacion"],
            ':estado'               => $_POST["estado"],
            ':observacion'             => $_POST["observacion"],
            ':foto'             => $imagen

        )

        

        
    );

    if (!empty($resultado)) {
        // Llamar a la función para generar y actualizar el código QR
        generarActualizarQR($conexion, $_POST["id_activo"], $_POST["nombre"], $_POST["categoria"], $_POST["responsable"], $_POST["ubicacion"], $_POST["observacion"]);
    } else {
        echo 'Error al actualizar el registro en la base de datos.';
    }
}