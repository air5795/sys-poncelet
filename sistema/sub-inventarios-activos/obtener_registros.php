<?php

    include("conexion.php");
    include("funciones.php");

    $query = "";
    $salida = array();
    $query = "SELECT * FROM activos_fijos ";

    if (isset($_POST["search"]["value"])) {
       $query .= 'WHERE nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
       $query .= 'OR estado LIKE "%' . $_POST["search"]["value"] . '%" ';
    }

    if (isset($_POST["order"])) {
        $query .= 'ORDER BY' . $_POST['order']['0']['column'] .' '.$_POST["order"][0]['dir'] . '';        
    }else{
        $query .= 'ORDER BY id_activo DESC ';
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
        /* $imagen = '';
        if($fila["foto"] != ''){
            $imagen = '<a class="btn btn-outline-primary btn-sm gallery-item boton-w"  id="productos/'.$fila['foto'].'"><i class="fa-solid fa-image"></i> </a>';
        }else{
            $imagen = '<a class="btn btn-outline-secondary btn-sm gallery-item boton-w disabled" id=""><i class="fa-solid fa-ban"></i> </a>';
        } */

        $imagen = '';
        if($fila["foto"] != '' ){
            $imagen = '<img class="gallery-item boton-w" src="productos/'.$fila['foto'].'" height="70px"   id="productos/'.$fila['foto'].'">';
            //$image = '<a class="btn btn-outline-primary btn-sm gallery-item boton-w"  id="actas/'.$fila['image'].'"><i class="fa-solid fa-image"></i> </a>';
        }else{
            $imagen = '<a class="btn btn-outline-secondary btn-sm gallery-item boton-w disabled" id=""><i class="fa-solid fa-ban"></i> </a>';
        }

        $qr = '';
        if($fila["qr"] != '' ){
            $qr = '<img class="gallery-item boton-w" src="'.$fila['qr'].'" height="70px"   id="'.$fila['qr'].'">';
            //$image = '<a class="btn btn-outline-primary btn-sm gallery-item boton-w"  id="actas/'.$fila['image'].'"><i class="fa-solid fa-image"></i> </a>';
        }else{
            $qr = '<a class="btn btn-outline-secondary btn-sm gallery-item boton-w disabled" id=""><i class="fa-solid fa-ban"></i> </a>';
        }

        /* $qr = '';
        if($fila["qr"] != ''){
            $qr = '<a class="btn btn-outline-primary btn-sm gallery-item boton-w"  id="qr/'.$fila['foto'].'"><i class="fa-solid fa-image"></i> </a>';
        }else{
            $qr = '<a class="btn btn-outline-secondary btn-sm gallery-item boton-w disabled" id=""><i class="fa-solid fa-ban"></i> </a>';
        } */

        /* $ficha = '';
        if($fila["pdf"] != ''){
            $ficha = '<a  target="_blank" class="btn btn-outline-danger btn-sm boton-w boton-f " href="fichas/'.$fila['pdf'].' "><i class="bi bi-file-earmark-pdf-fill"></i></a>';
        }else{
            $ficha = '<a class="btn btn-outline-secondary btn-sm boton-w disabled" href="" ><i class="fa-solid fa-ban"></i></a>';
        }

        $certificado = '';
        if($fila["certificado"] != ''){
            $certificado = '<a  target="_blank" class="btn btn-outline-danger btn-sm boton-w boton-c" href="certificados/'.$fila['certificado'].' "><i class="bi bi-file-earmark-post"></i></a>';
        }else{
            $certificado = '<a  class="btn btn-outline-secondary btn-sm boton-w disabled" href=""><i class="fa-solid fa-ban"></i></a>';
        } */



        $sub_array = array();
        $sub_array[] = $fila["id_activo"];
        $sub_array[] = $fila["nombre"];
        $sub_array[] = $fila["categoria"];
        $sub_array[] = $fila["responsable"];
        $sub_array[] = $fila["ubicacion"];
        $sub_array[] = $fila["estado"];
        $sub_array[] = $fila["observacion"];
        $sub_array[] = $fila["fecha_registro"];
        $sub_array[] = $imagen;
        $sub_array[] = $qr;
       /*  $sub_array[] = $ficha;
        $sub_array[] = $certificado; */
        $sub_array[] = '<button type="button" name="editar" id="'.$fila["id_activo"].'" class="btn btn-warning btn-sm boton-w  editar" style="background-color: #fbe806;color: #505050; color:#767676;"><i class="fa-solid fa-pencil"></i> </button>';
        $sub_array[] = '<button type="button" name="borrar" id="'.$fila["id_activo"].'" class="btn btn-danger btn-sm boton-w borrar" style="background-color: #ff5757;color: #505050; color:white;"><i class="fa-solid fa-trash-can"></i> </button>';
        $datos[] = $sub_array;
    }

    $salida = array(
        "draw"               => intval($_POST["draw"]),
        "recordsTotal"       => $filtered_rows,
        "recordsFiltered"    => obtener_todos_registros(),
        "data"               => $datos
    );

    echo json_encode($salida);