<?php

    include("conexion.php");
    include("funciones.php");

    $query = "";
    $salida = array();
    $query = "SELECT * FROM credenciales ";

    if (isset($_POST["search"]["value"])) {
       $query .= 'WHERE nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
       $query .= 'OR usuario LIKE "%' . $_POST["search"]["value"] . '%" ';
    }

    if (isset($_POST["order"])) {
        $query .= 'ORDER BY' . $_POST['order']['0']['column'] .' '.$_POST["order"][0]['dir'] . '';        
    }else{
        $query .= 'ORDER BY id_credencial DESC ';
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
        if($fila["foto"] != '' ){
            $imagen = '<img  class="gallery-item" src="productos/'.$fila['foto'].'" height="50px"    id="productos/'.$fila['foto'].'">';
            //$image = '<a class="btn btn-outline-primary btn-sm gallery-item "  id="actas/'.$fila['image'].'"><i class="fa-solid fa-image"></i> </a>';
        }else{
            $imagen = '<a class="btn btn-outline-secondary btn-sm gallery-item  disabled" id=""><i class="fa-solid fa-ban"></i> </a>';
        }

        

        /* $qr = '';
        if($fila["qr"] != ''){
            $qr = '<a class="btn btn-outline-primary btn-sm gallery-item "  id="qr/'.$fila['foto'].'"><i class="fa-solid fa-image"></i> </a>';
        }else{
            $qr = '<a class="btn btn-outline-secondary btn-sm gallery-item  disabled" id=""><i class="fa-solid fa-ban"></i> </a>';
        } */

         $pagina = '';
        if($fila["pagina"] != ''){
            $pagina = '<a  target="_blank" class="btn btn-secondary btn-sm  boton-f " href="'.$fila['pagina'].' "><i class="bi bi-back"></i> Ir a Pagina Web</a>';
        }else{
            $pagina = '<a class="btn btn-outline-secondary btn-sm  disabled" href="" ><i class="fa-solid fa-ban"></i></a>';
        } 
/*
        $certificado = '';
        if($fila["certificado"] != ''){
            $certificado = '<a  target="_blank" class="btn btn-outline-danger btn-sm  boton-c" href="certificados/'.$fila['certificado'].' "><i class="bi bi-file-earmark-post"></i></a>';
        }else{
            $certificado = '<a  class="btn btn-outline-secondary btn-sm  disabled" href=""><i class="fa-solid fa-ban"></i></a>';
        } */



        $sub_array = array();
        $sub_array[] = $fila["id_credencial"];
        $sub_array[] = $fila["nombre"];
        
        $sub_array[] = $fila["usuario"];
        $sub_array[] = $fila["password"];
        $sub_array[] = $imagen;
        $sub_array[] = $pagina;
        
       /*  $sub_array[] = $ficha;
        $sub_array[] = $certificado; */
        $sub_array[] = '<button type="button" name="editar" id="'.$fila["id_credencial"].'" class="btn btn-warning btn-sm  editar" style="background-color: #fbe806;color: #505050; color:#767676;"><i class="fa-solid fa-pencil"></i> Editar </button>';
        $sub_array[] = '<button type="button" name="borrar" id="'.$fila["id_credencial"].'" class="btn btn-danger btn-sm  borrar" style="background-color: #ff5757;color: #505050; color:white;"><i class="fa-solid fa-trash-can"></i> Eliminar </button>';
        $datos[] = $sub_array;
    }

    $salida = array(
        "draw"               => intval($_POST["draw"]),
        "recordsTotal"       => $filtered_rows,
        "recordsFiltered"    => obtener_todos_registros(),
        "data"               => $datos
    );

    echo json_encode($salida);