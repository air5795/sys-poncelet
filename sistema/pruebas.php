<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla con PHP y HTML</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<?php
$filas = array();

// Manejar la solicitud para agregar una nueva fila
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nueva_fila"])) {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $edad = $_POST["edad"];
    $filas[] = array("id" => $id, "nombre" => $nombre, "edad" => $edad);
}

// Mostrar la tabla
echo "<table>";
echo "<tr><th>ID</th><th>Nombre</th><th>Edad</th></tr>";
foreach ($filas as $fila) {
    echo "<tr>";
    echo "<td>{$fila['id']}</td>";
    echo "<td>{$fila['nombre']}</td>";
    echo "<td>{$fila['edad']}</td>";
    echo "</tr>";
}
echo "</table>";
?>

<!-- Formulario para agregar una nueva fila -->
<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="id">ID:</label>
    <input type="text" id="id" name="id" required><br>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br>
    <label for="edad">Edad:</label>
    <input type="text" id="edad" name="edad" required><br>
    <input type="submit" name="nueva_fila" value="Agregar Fila">
</form>

</body>
</html>
