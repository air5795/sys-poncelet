<?php

include("conexion.php");
include("funciones.php");

$query = "";
$salida = array();
$query = "SELECT ci.id_cambio, ci.id_inv, ci.cantidad_cambio, ci.tipo_cambio, ci.motivo, ci.fecha_cambio, i.articulo
          FROM cambio_inventario ci
          INNER JOIN inventario i ON ci.id_inv = i.id_inv"; // Realiza un INNER JOIN con la tabla inventario para obtener el nombre del producto

if (isset($_POST["search"]["value"])) {
    $query .= ' WHERE ci.id_inv LIKE "%' . $_POST["search"]["value"] . '%" ';  
}

if (isset($_POST["order"])) {
    $query .= ' ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST["order"][0]['dir'];        
} else {
    $query .= ' ORDER BY ci.id_cambio DESC ';
}

if($_POST["length"] != -1){
    $query .= ' LIMIT ' . $_POST["start"] . ', ' . $_POST["length"];
}

$stmt = $conexion->prepare($query);
$stmt->execute();
$resultado = $stmt->fetchAll();
$datos = array();
$filtered_rows = $stmt->rowCount();
foreach($resultado as $fila) {
    $sub_array = array();
    $sub_array[] = $fila["id_cambio"];
    $sub_array[] = $fila["articulo"]; // Agrega el nombre del producto en lugar del ID
    $sub_array[] = $fila["cantidad_cambio"];
    $sub_array[] = $fila["tipo_cambio"];
    $sub_array[] = $fila["motivo"];
    $sub_array[] = $fila["fecha_cambio"];
    $datos[] = $sub_array;
}

$salida = array(
    "draw"               => intval($_POST["draw"]),
    "recordsTotal"       => $filtered_rows,
    "recordsFiltered"    => obtener_todos_registros2(),
    "data"               => $datos
);

echo json_encode($salida);
?>
