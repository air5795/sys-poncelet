<?php

    include("conexion.php");
    include("funciones.php");

    $query = "";
    $salida = array();
    $query = "SELECT * FROM inventario ";

    if (isset($_POST["search"]["value"])) {
       $query .= 'WHERE articulo LIKE "%' . $_POST["search"]["value"] . '%" ';
      
    }

    if (isset($_POST["order"])) {
        $query .= 'ORDER BY' . $_POST['order']['0']['column'] .' '.$_POST["order"][0]['dir'] . '';        
    }else{
        $query .= 'ORDER BY id_inv DESC ';
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
        $imagen = '';
        if($fila["foto"] != ''){
            $imagen = '<a class="btn btn-outline-primary btn-sm gallery-item boton-w"  id="inventario/'.$fila['foto'].'"><i class="fa-solid fa-image"></i> </a>';
        }else{
            $imagen = '<a class="btn btn-outline-secondary btn-sm gallery-item boton-w disabled" id=""><i class="fa-solid fa-ban"></i> </a>';
        }

        if ($fila['stock'] == 0) {
            $stock = '<a class="btn btn-danger w-100" style="text-align:center">'.$fila['stock'].' </a>' ;
        } else {
            $stock = '<a class="btn btn-success w-100" style="text-align:center">'.$fila['stock'].' </a>' ;
        }

        

       



        $sub_array = array();
        $sub_array[] = $fila["id_inv"];
        
        $sub_array[] = $fila["articulo"];
        
      
        $sub_array[] = $fila["fecha_add"];
        $sub_array[] = $stock;
        
        $sub_array[] = $imagen;
        $sub_array[] = '<button type="button" name="editar" id="'.$fila["id_inv"].'" class="btn btn-warning btn-sm boton-w  editar" style="background-color: #fbe806;color: #505050; color:#767676;"><i class="fa-solid fa-pencil"></i> </button>';
        $sub_array[] = '<button type="button" name="borrar" id="'.$fila["id_inv"].'" class="btn btn-danger btn-sm boton-w borrar" style="background-color: #ff5757;color: #505050; color:white;"><i class="fa-solid fa-trash-can"></i> </button>';
        $datos[] = $sub_array;
    }

    $salida = array(
        "draw"               => intval($_POST["draw"]),
        "recordsTotal"       => $filtered_rows,
        "recordsFiltered"    => obtener_todos_registros(),
        "data"               => $datos
    );

    echo json_encode($salida);