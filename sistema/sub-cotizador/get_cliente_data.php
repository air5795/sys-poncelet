<?php
// Establecer la conexión a la base de datos

if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    $entorno = 'local';
} else {
    $entorno = 'produccion';
}

if ($entorno == 'local') {
    $db_host = 'localhost:3316';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'naxsan';
} else {
    $db_host = 'localhost';
    $db_user = 'airsoftb_naxsan';
    $db_password = '71811452Ale*';
    $db_name = 'airsoftb_naxsan2';
}



// Crear la conexión
$conexion = new mysqli($db_host, $db_user, $db_password, $db_name);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Obtener el cliente seleccionado del parámetro GET
$selectedCliente = $_GET['cliente'];

// Consultar los datos del cliente en la base de datos
$query = "SELECT * FROM cliente WHERE nombre = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $selectedCliente);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener los datos del cliente
    $data = $result->fetch_assoc();
} else {
    // Si no se encontraron resultados, inicializar los datos como un arreglo vacío
    $data = array();
}

// Devolver los datos del cliente en formato JSON
header('Content-Type: application/json');
echo json_encode($data);

// Cerrar la conexión a la base de datos
$stmt->close();
$conexion->close();
?>
