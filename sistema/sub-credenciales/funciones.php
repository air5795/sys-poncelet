<?php

    function subir_imagen(){
        if (isset($_FILES["foto"])) {
            
            $extension = explode('.', $_FILES["foto"]['name']);
            $nuevo_nombre = 'Producto-'.date('d-m-y').'-'.rand() . '.' . $extension[1];
            $ubicacion = './productos/' . $nuevo_nombre;
            move_uploaded_file($_FILES["foto"]['tmp_name'], $ubicacion);
            return $nuevo_nombre;
        }
    }

    function obtener_nombre_imagen($id_credencial){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT foto FROM credenciales WHERE id_credencial = '$id_credencial'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["foto"];
        }
    }

   

    function obtener_todos_registros(){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT * FROM credenciales");
        $stmt->execute();
        $resultado = $stmt->fetchAll(); 
        return $stmt->rowCount();       
    }

    



    