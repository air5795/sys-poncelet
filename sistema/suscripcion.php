<?php
    session_start();
    include "../conexion.php";

    // Obtener la fecha actual
    $fecha_actual = date("Y-m-d");

    // Configurar localización en español para mostrar fechas correctamente
    setlocale(LC_TIME, "es_ES.UTF-8", "Spanish_Spain.1252");

    // Paginación
    $registros_por_pagina = 8;
    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $offset = ($pagina_actual - 1) * $registros_por_pagina;

    // Obtener los registros con estado 0 y 1 paginados
    $query_pagos = mysqli_query($conexion, "SELECT * FROM suscripcion_sistema WHERE estado IN (0,1) ORDER BY fecha_inicio DESC LIMIT $offset, $registros_por_pagina");
    
    // Contar total de registros para la paginación
    $total_registros_query = mysqli_query($conexion, "SELECT COUNT(*) as total FROM suscripcion_sistema WHERE estado IN (0,1)");
    $total_registros = mysqli_fetch_assoc($total_registros_query)['total'];
    $total_paginas = ceil($total_registros / $registros_por_pagina);
    
    // Obtener solo el registro del próximo mes con estado 2
    $query_proximo = mysqli_query($conexion, "SELECT * FROM suscripcion_sistema WHERE estado = 2 AND fecha_inicio >= '$fecha_actual' ORDER BY fecha_inicio ASC LIMIT 1");
    
    // Contar la cantidad de pagos pendientes
    $query_pendientes = mysqli_query($conexion, "SELECT COUNT(*) as total FROM suscripcion_sistema WHERE estado = 0");
    $resultado_pendientes = mysqli_fetch_assoc($query_pendientes);
    $pendientes = $resultado_pendientes['total'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <?php include "includes/scripts.php";?>
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SIS-PONCELET</title>
        
    </head>
    <body class="sb-nav-fixed">
    <?php  include "includes/header.php";?>
    
        <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <div class="container-fluid px-4 ">
                
                <h1 class="mt-4 col align-items-center" >
                    
                    <strong><span> Plan de pagos mensuales </strong>  
                    <span style="color:#457d9f;"> Sistema Poncelet </i></span>
                    
                </h1>
                <hr>    
                <p><strong>PAGO MENSUAL :</strong> MANTENIMIENTO <?php if ($pendientes > 0) { ?>
                        <a style="font-size:18px" href="#" class="btn btn-danger btn-sm ms-3">
                        Pagos Pendientes: <span class="badge bg-light text-dark"><?php echo $pendientes; ?></span>
                        </a>
                    <?php } ?></p> <hr>
                <p><strong>PAGO ANUAL :</strong>  HOSTING Y DOMINIO DEL SISTEMA CADA 10 DE NOVIEMBRE  </p>
                
                
                        <hr>
                        
    <div class=" mt-3">
        <h2 class="mb-4 text-left">Historial </h2>

        <?php if (mysqli_num_rows($query_pagos) > 0) { ?>
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Pago</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = mysqli_fetch_array($query_pagos)) { ?>
                        <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo strftime(" %d de %B de %Y", strtotime($data['fecha_inicio'])); ?></td>
                            <td>
                                <?php 
                                    if ($data['estado'] == 1) {
                                        echo '<span class="badge bg-success">Pagado</span>';
                                    } else {
                                        echo '<span class="badge bg-danger">Pago Pendiente</span>';
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <nav>
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                        <li class="page-item <?php if ($i == $pagina_actual) echo 'active'; ?>">
                            <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        <?php } else { ?>
            <div class="alert alert-info text-center">No hay registros de suscripciones pasadas.</div>
        <?php } ?>

        <h2 class="mb-4 text-left">Próximo Pago </h2>

        <?php if (mysqli_num_rows($query_proximo) > 0) { ?>
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Pago</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = mysqli_fetch_array($query_proximo)) { ?>
                        <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo strftime(" %d de %B de %Y", strtotime($data['fecha_inicio'])); ?></td>
                            <td>
                                <span class="badge bg-warning text-dark">Próximo a pagar</span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-info text-center">No hay registros de próximos pagos.</div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
