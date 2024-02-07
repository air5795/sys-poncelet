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

 /*    function subir_ficha(){
        if (isset($_FILES["ficha"])) {
            
            $extension = explode('.', $_FILES["ficha"]['name']);
            $nuevo_nombre = rand() . '.' . $extension[1];
            $ubicacion = './fichas/' . $nuevo_nombre;
            move_uploaded_file($_FILES["ficha"]['tmp_name'], $ubicacion);
            return $nuevo_nombre;
        }
    }

    function subir_certificado(){
        if (isset($_FILES["certificado"])) {
            
            $extension = explode('.', $_FILES["certificado"]['name']);
            $nuevo_nombre = rand() . '.' . $extension[1];
            $ubicacion = './certificados/' . $nuevo_nombre;
            move_uploaded_file($_FILES["certificado"]['tmp_name'], $ubicacion);
            return $nuevo_nombre;
        }
    } */

    function obtener_nombre_imagen($id_activo){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT foto FROM activos_fijos WHERE id_activo = '$id_activo'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["foto"];
        }
    }

    function obtener_nombre_qr($id_activo){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT qr FROM activos_fijos WHERE id_activo = '$id_activo'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["qr"];
        }
    }

 /*    function obtener_nombre_ficha($id_producto){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT pdf FROM productos WHERE id_producto = '$id_producto'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["pdf"];
        }
    }

    function obtener_nombre_certificado($id_producto){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT certificado FROM productos WHERE id_producto = '$id_producto'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["certificado"];
        }
    } */

    function obtener_todos_registros(){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT * FROM activos_fijos");
        $stmt->execute();
        $resultado = $stmt->fetchAll(); 
        return $stmt->rowCount();       
    }

    function obtener_todos_registros2(){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT * FROM categoria_i");
        $stmt->execute();
        $resultado = $stmt->fetchAll(); 
        return $stmt->rowCount();       
    }


    function generarActualizarQR($conexion, $idActivo, $nombre, $categoria, $responsable, $ubicacion, $observacion) {
        // Crear una cadena de datos para el QR
        $qrData = "ID: $idActivo\nNombre: $nombre\nCategoria: $categoria\nResponsable: $responsable\nUbicacion: $ubicacion\nObservacion: $observacion";
    
        // Directorio donde se almacenarán los códigos QR (asegúrate de tener permisos de escritura)
        $dir = 'qr/';
    
        // Nombre del archivo QR
        $qrFileName = $dir . 'qr_' . $idActivo . '.png';
    
        // Generar el código QR
        if (QRcode::png($qrData, $qrFileName)) {
            echo 'Código QR generado y guardado correctamente.<br>';
        } else {
            echo 'Error al generar el código QR.<br>';
        }
    
        // Actualizar la base de datos con el nombre del archivo QR
        $stmt = $conexion->prepare("UPDATE activos_fijos SET qr = :qr WHERE id_activo = :id");
        $stmt->execute(array(':qr' => $qrFileName, ':id' => $idActivo));
    
       

echo 'Registro actualizado y código QR generado. ActualizaciónCompletada';

        
    }
    