<?php

session_start();

    include("conexion.php");
    include("funciones.php");

    $adm = $_SESSION['rol']; 
    

    $query = "";
    $salida = array();
    $query = "SELECT * FROM salidas ";

    if (isset($_POST["search"]["value"])) {
       $query .= 'WHERE personal LIKE "%' . $_POST["search"]["value"] . '%" ';
       $query .= 'OR lugar LIKE "%' . $_POST["search"]["value"] . '%" ';
       $query .= 'OR fecha LIKE "%' . $_POST["search"]["value"] . '%" ';
       $query .= 'OR motivo LIKE "%' . $_POST["search"]["value"] . '%" ';
       $query .= 'OR hora LIKE "%' . $_POST["search"]["value"] . '%" ';
    }

    if (isset($_POST["order"])) {
        $query .= 'ORDER BY' . $_POST['order']['0']['column'] .' '.$_POST["order"][0]['dir'] . '';        
    }else{
        $query .= 'ORDER BY id_salida DESC ';
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

        if ($fila['personal'] == 'Jazmin Velasco Diaz') {
            $personal =  '<span style="font-size:12px;background-color:#fbe9f4;text-align: left; color:#5a5a5a;" class="btn  btn-sm w-100"><i class="bi bi-person-circle"></i> Jazmin Velasco   </span>'.'<br/>';
        }else {
            $personal = '';
        }

        if ($fila['personal'] == 'Mavel Condori Flores') {
            $personal2 =  '<span class="btn btn-sm btn-outline-danger w-100" style="text-align:left;font-size:14px" ><i class="bi bi-person-fill"></i> Mavel Condori Flores  </span>'.'<br/>';
        }else {
            $personal2 = '';
        }
        

        if ($fila['personal'] == 'Alejandro Iglesias Raldes') {
            $personal3 =  '<span style="font-size:12px;background-color:#e9ffca;text-align: left; color:#5a5a5a;" class="btn  btn-sm w-100"><i class="bi bi-person-circle"></i> Alejandro Iglesias  </span>'.'<br/>';
        }else {
            $personal3 = '';
        }

        if ($fila['personal'] == 'Mariana Nicol Erquicia Camacho') {
            $personal4 =  '<span class="btn btn-sm btn-outline-secondary w-100" style="text-align:left;font-size:14px" ><i  class="bi bi-person-fill"></i> Mariana Nicol Erquicia Camacho  </span>'.'<br/>';
        }else {
            $personal4 = '';
        }

        if ($fila['personal'] == 'Edwin Mario Pinto Ramirez') {
            $personal5 =  '<span class="btn btn-sm btn-outline-primary w-100" style="text-align:left; font-size:14px"><i  class="bi bi-person-fill"></i> Edwin Mario Pinto Ramirez  </span>'.'<br/>';
        }else {
            $personal5 = '';
        }

        if ($fila['personal'] == 'Deyci Eveling Colque Pacha') {
            $personal6 = '<span style="font-size:12px;background-color:#cafbff;text-align: left; color:#5a5a5a;" class="btn  btn-sm w-100"><i class="bi bi-person-circle"></i> Deyci Eveling Colque Pacha </span>'.'<br/>';
        } else {
            $personal6 = '';
        }

        if ($fila['personal'] == 'Lucia Condori Calle') {
            $personal7 = '<span style="font-size:12px;background-color:#e4dcff;text-align: left; color:#5a5a5a;" class="btn  btn-sm w-100"><i class="bi bi-person-circle"></i> Lucia Condori Calle </span>'.'<br/>';
        } else {
            $personal7 = '';
        }

        if ($fila['personal'] == 'Cristian Cordero Iglesias ') {
            $personal9 = '<span style="font-size:12px;background-color:#dcffeb;text-align: left; color:#5a5a5a;" class="btn  btn-sm w-100"><i class="bi bi-person-circle"></i> Cristian Cordero Iglesias </span>'.'<br/>';
        } else {
            $personal9 = '';
        }

        




        //fecha de presentacion
        setlocale(LC_TIME, "spanish");
        $fecha =  strftime('%e de %B %Y', strtotime($fila['fecha']));


        
        

        
        $sub_array = array();
        $sub_array[] = $fila["id_salida"];
        $sub_array[] = $personal.$personal2.$personal3.$personal4.$personal5.$personal6.$personal7.$personal9; 
        $sub_array[] = $fecha;
        $sub_array[] = $fila["hora"];
        $sub_array[] = $fila["lugar"];
        $sub_array[] = $fila["motivo"];
        
        if ($_SESSION['rol'] == 1) {
            $sub_array[] = '<button type="button" name="editar" id="'.$fila["id_salida"].'" class="btn btn-warning btn-sm boton-w  editar" style="background-color: #fbe806;color: #505050; color:#767676;"><i class="fa-solid fa-pencil"></i> </button>';
            $sub_array[] = '<button type="button" name="borrar" id="'.$fila["id_salida"].'" class="btn btn-danger btn-sm boton-w borrar" style="background-color: #ff5757;color: #505050; color:white;"><i class="fa-solid fa-trash-can"></i> </button>';
           
        }else {
            $sub_array[] = '';
            $sub_array[] = '';
        }
        $datos[] = $sub_array;
    }

    $salida = array(
        "draw"               => intval($_POST["draw"]),
        "recordsTotal"       => $filtered_rows,
        "recordsFiltered"    => obtener_todos_registros(),
        "data"               => $datos
    );

    echo json_encode($salida);