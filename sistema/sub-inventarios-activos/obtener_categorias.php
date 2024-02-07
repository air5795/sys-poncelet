<?php

    include("conexion.php");
    include("funciones.php");

    header('Content-Type: application/json');

    $query = "";
    $salida = array();
    $query = "SELECT * FROM categoria_i ";

    if (isset($_POST["search"]["value"])) {
       $query .= 'WHERE nombre_categoria LIKE "%' . $_POST["search"]["value"] . '%" ';
    }

    if (isset($_POST["order"])) {
        $query .= 'ORDER BY ' . $_POST['order']['0']['column'] .' '.$_POST["order"][0]['dir'] . '';        
    }else{
        $query .= 'ORDER BY id_categoria DESC ';
    }

    if($_POST["length"] != -1){
        $query .= 'LIMIT ' . $_POST["start"] . ','. $_POST["length"];
    }

    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    $datos = array();
    $filtered_rows = $stmt->rowCount();
    foreach($resultado as $fila){
        
        $sub_array = array();
        $sub_array[] = $fila["id_categoria"];
        $sub_array[] = $fila["nombre_categoria"];
        
        $sub_array[] = '<button type="button" name="editar" id="'.$fila["id_categoria"].'" class="btn btn-warning btn-sm boton-w  editarCategoria" style="background-color: #fbe806;color: #505050; color:#767676;"><i class="fa-solid fa-pencil"></i> </button>';
        $sub_array[] = '<button type="button" name="borrar" id="'.$fila["id_categoria"].'" class="btn btn-danger btn-sm boton-w borrarCategoria" style="background-color: #ff5757;color: #505050; color:white;"><i class="fa-solid fa-trash-can"></i> </button>';
        $datos[] = $sub_array;
    }

    $salida = array(
        "draw"               => intval($_POST["draw"]),
        "recordsTotal"       => $filtered_rows,
        "recordsFiltered"    => obtener_todos_registros2(),
        "data"               => $datos
    );

    echo json_encode($salida);