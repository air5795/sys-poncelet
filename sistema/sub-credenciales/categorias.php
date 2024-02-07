<?php
include('conexion.php');
// include('funciones.php'); // Si es necesario incluir funciones

// Consulta para obtener las categorías
$query = "SELECT nombre_categoria FROM categoria_i";
$resultado = $conexion->query($query);

// Verificar si hay resultados y generar las opciones del select
if ($resultado && $resultado->rowCount() > 0) {
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $fila['nombre_categoria'] . '">' . $fila['nombre_categoria'] . '</option>';
    }
}
?>

