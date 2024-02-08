<?php


// Configuración para entorno local
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $usuario = "root";
    $password = "";
    $host = "localhost:3316";
    $dbname = "naxsan";
} else {
    // Configuración para entorno de producción
    $usuario = "airsoftb_naxsan";
    $password = "71811452Ale*";
    $host = "localhost";
    $dbname = 'airsoftb_poncelet';
}

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $password);
    // Configurar el objeto de conexión PDO según tus necesidades (por ejemplo, manejar errores)
    // ...
} catch (PDOException $e) {
    // Manejar errores de conexión
    echo "Error de conexión: " . $e->getMessage();
}


?>

