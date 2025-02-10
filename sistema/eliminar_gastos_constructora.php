<?php
session_start();

include "../conexion.php";

if (!empty($_POST)) {

    
    $idG = $_POST['idGasto'];


    //eliminar un registro
    $query_delete = mysqli_query($conexion, "DELETE FROM gastos_constructora WHERE id_gastoC = $idG");
    

    //$query_delete = mysqli_query($conexion,"UPDATE usuario SET estatus = 0 WHERE idusuario = $idusuario");

    if ($query_delete) {
        header('location: gastos_constructora.php');
    }else {
        echo "error al eliminar ";
    }
}
    

    

?>