<?php

    function subir_imagen(){
        if (isset($_FILES["foto"])) {
            
            $extension = explode('.', $_FILES["foto"]['name']);
            $nuevo_nombre = 'Producto-'.date('d-m-y').'-'.rand() . '.' . $extension[1];
            $ubicacion = './inventario/' . $nuevo_nombre;
            move_uploaded_file($_FILES["foto"]['tmp_name'], $ubicacion);
            return $nuevo_nombre;
        }
    }

    

    function obtener_nombre_imagen($id_inv){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT foto FROM inventario WHERE id_inv = '$id_inv'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["foto"];
        }
    }

    

    function obtener_todos_registros(){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT * FROM inventario");
        $stmt->execute();
        $resultado = $stmt->fetchAll(); 
        return $stmt->rowCount();       
    }