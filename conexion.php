<?php
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    $entorno = 'local';
} else {
    $entorno = 'produccion';
}

if ($entorno == 'local') {
    $db_host = 'localhost:3316';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'naxsan';
} else {
    $db_host = 'localhost';
    $db_user = 'airsoftb_naxsan';
    $db_password = '71811452Ale*';
    $db_name = 'airsoftb_naxsan2';
}

$conexion = @mysqli_connect($db_host,$db_user,$db_password,$db_name);
if (!$conexion) {
    echo "Error en la conexion";
}

/* if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    $entorno = 'local';
} else {
    $entorno = 'produccion';
}

if ($entorno == 'local') {
    $db_host = 'localhost:3316';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'naxsan';
} else {
    $db_host = 'sdb-64.hosting.stackcp.net';
    $db_user = 'admin-81de';
    $db_password = '71811452Ale*';
    $db_name = 'naxsan-35303337ab1d';
}

$conexion = @mysqli_connect($db_host,$db_user,$db_password,$db_name);
if (!$conexion) {
    echo "Error en la conexion";
} */



    
    /* $host = 'localhost:3316';
    $user = 'root';
    $password = '';
    $db = 'naxsan';

    $conexion = @mysqli_connect($host,$user,$password,$db);

    

    if (!$conexion) {
        echo "Error en la conexion";
    }  */


/* } else {
    $db_host = 'sdb-64.hosting.stackcp.net';
    $db_user = 'admin-81de';
    $db_password = '71811452Ale*';
    $db_name = 'naxsan-35303337ab1d';
} */

?>