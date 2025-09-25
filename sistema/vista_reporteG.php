<?php

session_start();
include "../conexion.php";

// Función para comprimir imágenes
function comprimirImagen($rutaOrigen, $calidad = 50, $maxWidth = 800) {
    // Obtener información de la imagen
    $info = getimagesize($rutaOrigen);
    if ($info === false) return false;
    
    // Crear una imagen temporal basada en el tipo de archivo
    switch ($info[2]) {
        case IMAGETYPE_JPEG:
            $imagen = imagecreatefromjpeg($rutaOrigen);
            break;
        case IMAGETYPE_PNG:
            $imagen = imagecreatefrompng($rutaOrigen);
            // Preservar transparencia para PNG
            imagealphablending($imagen, true);
            imagesavealpha($imagen, true);
            break;
        default:
            return false;
    }
    
    if (!$imagen) return false;
    
    // Obtener dimensiones originales
    $anchoOriginal = imagesx($imagen);
    $altoOriginal = imagesy($imagen);
    
    // Calcular nuevas dimensiones manteniendo la proporción
    if ($anchoOriginal > $maxWidth) {
        $nuevoAncho = $maxWidth;
        $nuevoAlto = round(($altoOriginal * $maxWidth) / $anchoOriginal);
        
        // Crear nueva imagen redimensionada
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
        
        // Liberar la imagen original y usar la redimensionada
        imagedestroy($imagen);
        $imagen = $imagenRedimensionada;
    }
    
    // Crear un directorio temporal para las imágenes comprimidas si no existe
    $dirTemp = __DIR__ . '/temp_compressed/';
    if (!file_exists($dirTemp)) {
        mkdir($dirTemp, 0777, true);
    }
    
    // Generar nombre para la imagen comprimida
    $nombreArchivo = basename($rutaOrigen);
    $rutaComprimida = $dirTemp . $nombreArchivo;
    
    // Comprimir y guardar la imagen
    $resultado = false;
    switch ($info[2]) {
        case IMAGETYPE_JPEG:
            $resultado = imagejpeg($imagen, $rutaComprimida, $calidad);
            break;
        case IMAGETYPE_PNG:
            // Para PNG, la calidad va de 0 a 9 (0 = sin compresión, 9 = máxima compresión)
            $calidadPNG = round((100 - $calidad) / 11.1);
            $resultado = imagepng($imagen, $rutaComprimida, $calidadPNG);
            break;
    }
    
    // Liberar memoria
    imagedestroy($imagen);
    
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

    while (($archivo = $dirint->read()) != false)
    {
        if (strpos($archivo,'jpg') || strpos($archivo,'jpeg')){
            $archivos[] = $archivo;
            $image = $directory. $archivo;
        }
    }
    $dirint->close();

    natsort($archivos);
    foreach($archivos as $archivo) {
        $rutaOriginal = $directory . $archivo;
        // Comprimir la imagen con mayor compresión para PDFs más livianos
        $rutaComprimida = comprimirImagen($rutaOriginal, 40, 760);
        
        // Si la compresión fue exitosa, usar la imagen comprimida
        if ($rutaComprimida) {
            echo '<img style="width:760px" src="' . $rutaComprimida . '">';
        } else {
            // Si hubo un error en la compresión, usar la imagen original
            echo '<img style="width:760px" src="sub-exp-comer/actas/' . $archivo . '">';
        }
    }
    
?>
                
            
    
</body>
</html>