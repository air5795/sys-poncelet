<?php

include("conexion.php");
include("funciones.php");




if ($_POST["operacion"] == "Crear") {
    $imagen = '';
  
    if ($_FILES["foto"]["name"] != '') {
        $imagen = subir_imagen();
    }
    
    $stmt = $conexion->prepare("INSERT INTO inventario(articulo, stock, foto)
                                VALUES(:articulo, :stock,:foto)");

    $resultado = $stmt->execute(
        array(
            ':articulo'           => $_POST["articulo"],
            ':stock'            => $_POST["stock"],
            ':foto'             => $imagen
            
        )
    );

    if (!empty($resultado)) {
        echo 'Registro creado';
    }
}



	




if ($_POST["operacion"] == "Editar") {
    $imagen = obtener_nombre_imagen($_POST["id_inv"]);

    if ($_FILES["foto"]["name"] != '') {
        unlink("inventario/" . $imagen);
        $imagen = subir_imagen();
    } else {
        $imagen = @$_POST['img_o'];
    }

    // Obtener el stock actual antes de la actualización
    $stmt = $conexion->prepare("SELECT stock FROM inventario WHERE id_inv = :id_inv");
    $stmt->execute(array(':id_inv' => $_POST["id_inv"]));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stock_anterior = $row['stock'];

    // Calcular la diferencia de stock
    $nuevo_stock = $_POST["stock"];
    $diferencia_stock = $nuevo_stock - $stock_anterior;
    $tipo_cambio = $diferencia_stock > 0 ? 'aumento' : 'disminucion';

    // Actualizar el inventario
    $stmt = $conexion->prepare("UPDATE inventario SET articulo=:articulo, stock=:stock, foto=:foto WHERE id_inv = :id_inv");
    $resultado = $stmt->execute(
        array(
            ':id_inv'      => $_POST["id_inv"],
            ':articulo'    => $_POST["articulo"],
            ':stock'       => $_POST["stock"],
            ':foto'        => $imagen
        )
    );

    // Registrar el cambio en la tabla cambio_inventario
    if (!empty($resultado)) {
        $stmt = $conexion->prepare("INSERT INTO cambio_inventario (id_inv, cantidad_cambio, tipo_cambio, motivo) VALUES (:id_inv, :cantidad_cambio, :tipo_cambio, :motivo)");
        $stmt->execute(
            array(
                ':id_inv'         => $_POST["id_inv"],
                ':cantidad_cambio'=> abs($diferencia_stock),
                ':tipo_cambio'    => $tipo_cambio,
                ':motivo'         => $_POST["motivo"]
            )
        );
        echo 'Registro actualizado y cambio registrado';
    }
}