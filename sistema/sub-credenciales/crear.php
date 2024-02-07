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
    $stmt = $conexion->prepare("INSERT INTO credenciales(nombre, pagina, usuario, password, foto)
                                VALUES(:nombre, :pagina, :usuario, :password, :foto )");

    $resultado = $stmt->execute(
        array(
            ':nombre'           => $_POST["nombre"],
            ':pagina'            => $_POST["pagina"],
            ':usuario'           => $_POST["usuario"],
            ':password'               => $_POST["password"],
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
    $imagen = obtener_nombre_imagen($_POST["id_credencial"]);


    if ($_FILES["foto"]["name"] != '') {
        unlink("productos/" . $imagen);
         $imagen = subir_imagen();
    }
    else {

        $imagen = @$_POST['img_o'];     
    }
    




    $stmt = $conexion->prepare("UPDATE credenciales SET nombre=:nombre, pagina=:pagina, usuario=:usuario, password=:password,foto=:foto WHERE id_credencial = :id_credencial");

    $resultado = $stmt->execute(
        array(
            ':id_credencial'      => $_POST["id_credencial"],
            ':nombre'           => $_POST["nombre"],
            ':pagina'            => $_POST["pagina"],
            ':usuario'           => $_POST["usuario"],
            ':password'               => $_POST["password"],
            ':foto'             => $imagen

        )

        

        
    );

    if (!empty($resultado)) {
        echo 'Exito !! al insertar el registro en la base de datos.';
    } else {
        echo 'Error al actualizar el registro en la base de datos.';
    }
}