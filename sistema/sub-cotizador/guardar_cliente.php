<?php
include 'conexion.php';

$nit = $_POST['nit'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];

$sql = $conexion->prepare("INSERT INTO cliente (nit, nombre, telefono, direccion) VALUES (?, ?, ?, ?)");
$sql->bind_param("isss", $nit, $nombre, $telefono, $direccion);

if ($sql->execute()) {
    echo "Cliente registrado correctamente";
} else {
    echo "Error al registrar el cliente: " . $sql->error;
}

$sql->close();
$conexion->close();
?>

