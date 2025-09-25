<?php

session_start();
include "../conexion.php";

// Aumentar el tiempo límite de ejecución y memoria
set_time_limit(300); // 5 minutos
ini_set('memory_limit', '512M');

// Función optimizada para comprimir imágenes
function comprimirImagen($rutaOrigen, $calidad = 50, $maxWidth = 800) {
    // Verificar si el archivo existe y es accesible
    if (!file_exists($rutaOrigen) || !is_readable($rutaOrigen)) {
        return false;
    }
    
    // Obtener información de la imagen de manera más eficiente
    $info = @getimagesize($rutaOrigen);
    if ($info === false || !isset($info[2])) {
        return false;
    }
    
    // Verificar si la imagen ya es pequeña y no necesita compresión
    if ($info[0] <= $maxWidth && $info[1] <= 600) {
        return $rutaOrigen; // Devolver la imagen original si ya es pequeña
    }
    
    // Crear una imagen temporal basada en el tipo de archivo
    $imagen = null;
    switch ($info[2]) {
        case IMAGETYPE_JPEG:
            $imagen = @imagecreatefromjpeg($rutaOrigen);
            break;
        case IMAGETYPE_PNG:
            $imagen = @imagecreatefrompng($rutaOrigen);
            if ($imagen) {
                // Preservar transparencia para PNG
                imagealphablending($imagen, false);
                imagesavealpha($imagen, true);
            }
            break;
        default:
            return false;
    }
    
    if (!$imagen) {
        return false;
    }
    
    // Obtener dimensiones originales
    $anchoOriginal = imagesx($imagen);
    $altoOriginal = imagesy($imagen);
    
    // Calcular nuevas dimensiones manteniendo la proporción
    $nuevoAncho = $anchoOriginal;
    $nuevoAlto = $altoOriginal;
    
    if ($anchoOriginal > $maxWidth) {
        $nuevoAncho = $maxWidth;
        $nuevoAlto = round(($altoOriginal * $maxWidth) / $anchoOriginal);
    }
    
    // Crear nueva imagen redimensionada solo si es necesario
    $imagenFinal = $imagen;
    if ($nuevoAncho != $anchoOriginal || $nuevoAlto != $altoOriginal) {
        $imagenRedimensionada = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        
        // Preservar transparencia para PNG
        if ($info[2] == IMAGETYPE_PNG) {
            imagealphablending($imagenRedimensionada, false);
            imagesavealpha($imagenRedimensionada, true);
            $transparent = imagecolorallocatealpha($imagenRedimensionada, 255, 255, 255, 127);
            imagefill($imagenRedimensionada, 0, 0, $transparent);
        }
        
        // Redimensionar la imagen
        imagecopyresampled($imagenRedimensionada, $imagen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $anchoOriginal, $altoOriginal);
        
        // Liberar la imagen original
        imagedestroy($imagen);
        $imagenFinal = $imagenRedimensionada;
    }
    
    // Crear un directorio temporal para las imágenes comprimidas si no existe
    $dirTemp = __DIR__ . '/temp_compressed/';
    if (!file_exists($dirTemp)) {
        if (!mkdir($dirTemp, 0755, true)) {
            imagedestroy($imagenFinal);
            return false;
        }
    }
    
    // Generar nombre único para la imagen comprimida
    $nombreArchivo = basename($rutaOrigen);
    $rutaComprimida = $dirTemp . 'comp_' . time() . '_' . $nombreArchivo;
    
    // Comprimir y guardar la imagen
    $resultado = false;
    switch ($info[2]) {
        case IMAGETYPE_JPEG:
            $resultado = @imagejpeg($imagenFinal, $rutaComprimida, $calidad);
            break;
        case IMAGETYPE_PNG:
            // Para PNG, la calidad va de 0 a 9 (0 = sin compresión, 9 = máxima compresión)
            $calidadPNG = max(0, min(9, round((100 - $calidad) / 11.1)));
            $resultado = @imagepng($imagenFinal, $rutaComprimida, $calidadPNG);
            break;
    }
    
    // Liberar memoria
    imagedestroy($imagenFinal);
    
    return $resultado ? $rutaComprimida : false;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACTAS</title>
    <style type="text/css">
        .aimg{
            width: 750px;
        }
    </style>
</head>

<body>

<?php
    //$directory="img/actas/";
    $directory="sub-exp-comer/actas/";
    $dirint = dir($directory);
    
    // Limpiar directorio temporal de imágenes comprimidas anteriores
    $dirTemp = 'temp_compressed/';
    if (file_exists($dirTemp)) {
        $tempFiles = glob($dirTemp . '*');
        foreach ($tempFiles as $tempFile) {
            if (is_file($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    // Obtener archivos de manera más eficiente
    $archivos = glob($directory . '*.{jpg,jpeg,JPG,JPEG}', GLOB_BRACE);
    
    if ($archivos) {
        // Ordenar archivos naturalmente
        natsort($archivos);
        
        // Contador para controlar el procesamiento
        $contador = 0;
        $maxImagenes = 50; // Límite de imágenes a procesar por página
        
        foreach($archivos as $rutaCompleta) {
            // Verificar tiempo de ejecución restante
            if (time() - $_SERVER['REQUEST_TIME'] > 240) { // 4 minutos máximo
                echo '<p style="color: red;">Tiempo de procesamiento excedido. Se muestran las primeras ' . $contador . ' imágenes.</p>';
                break;
            }
            
            // Límite de imágenes por página
            if ($contador >= $maxImagenes) {
                echo '<p style="color: orange;">Se han procesado ' . $maxImagenes . ' imágenes. Para ver más, considere paginar los resultados.</p>';
                break;
            }
            
            $archivo = basename($rutaCompleta);
            $rutaOriginal = $rutaCompleta;
            
            // Verificar si el archivo existe y es válido
            if (!file_exists($rutaOriginal) || !is_file($rutaOriginal)) {
                continue;
            }
            
            // Comprimir la imagen con mayor compresión para PDFs más livianos
            $rutaComprimida = comprimirImagen($rutaOriginal, 40, 760);
            
            // Si la compresión fue exitosa, usar la imagen comprimida
            if ($rutaComprimida && file_exists($rutaComprimida)) {
                echo '<img style="width:760px; margin-bottom: 10px;" src="' . $rutaComprimida . '">';
            } else {
                // Si hubo un error en la compresión, usar la imagen original
                echo '<img style="width:760px; margin-bottom: 10px;" src="' . $rutaOriginal . '">';
            }
            
            $contador++;
            
            // Liberar memoria periódicamente
            if ($contador % 10 == 0) {
                gc_collect_cycles();
            }
        }
    } else {
        echo '<p>No se encontraron imágenes en el directorio.</p>';
    }
    
?>
                
            
    
</body>
</html>