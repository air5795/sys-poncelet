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
    }
    else {

        $imagen = @$_POST['img_o'];     
    }
    




    $stmt = $conexion->prepare("UPDATE inventario SET articulo=:articulo, stock=:stock, foto=:foto WHERE id_inv = :id_inv");

    $resultado = $stmt->execute(
        array(
            ':id_inv'      => $_POST["id_inv"],
            ':articulo'           => $_POST["articulo"],
            ':stock'            => $_POST["stock"],
           
            ':foto'             => $imagen
            

        )

        

        
    );

    if (!empty($resultado)) {
        echo 'Registro actualizado';
    }
}