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

    // Obtener datos para el gráfico anual
    $año_actual = date("Y");
    $meses_año = [];
    for ($i = 1; $i <= 12; $i++) {
        $fecha_mes = $año_actual . "-" . str_pad($i, 2, "0", STR_PAD_LEFT) . "-01";
        $query_mes = mysqli_query($conexion, "SELECT estado FROM suscripcion_sistema WHERE DATE_FORMAT(fecha_inicio, '%Y-%m') = '" . substr($fecha_mes, 0, 7) . "'");
        
        if ($data_mes = mysqli_fetch_assoc($query_mes)) {
            $meses_año[$i] = $data_mes['estado'];
        } else {
            $meses_año[$i] = -1; // No existe registro
        }
    }
    
    $meses_nombres = [
        1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 
        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 
        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
    ];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <?php include "includes/scripts.php";?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SIS-PONCELET - Suscripciones</title>
    
    <style>
        :root {
            --primary-color: #457d9f;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --shadow: 0 2px 10px rgba(0,0,0,0.1);
            --border-radius: 12px;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            min-height: 100vh;
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1.5rem 0;
            border-bottom: 2px solid var(--light-bg);
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 300;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin: 0;
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: transform 0.2s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
        }

        .info-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .info-card-monthly .info-card-icon {
            background: linear-gradient(135deg, var(--primary-color), #3a6b8a);
        }

        .info-card-annual .info-card-icon {
            background: linear-gradient(135deg, var(--warning-color), #e0a800);
        }

        .info-card-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .info-card-text {
            color: #6c757d;
            margin: 0;
            line-height: 1.5;
        }

        .calendar-section {
            margin-bottom: 2rem;
        }

        .calendar-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .calendar-title {
            color: #495057;
            font-weight: 600;
            margin: 0;
            margin-right: 1rem;
        }

        .calendar-year {
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
            gap: 0.75rem;
            background: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .month-item {
            text-align: center;
            padding: 1rem 0.5rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .month-paid {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: var(--success-color);
            border: 2px solid var(--success-color);
        }

        .month-pending {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: var(--danger-color);
            border: 2px solid var(--danger-color);
        }

        .month-upcoming {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
            border: 2px solid var(--warning-color);
        }

        .month-no-data {
            background: #f8f9fa;
            color: #6c757d;
            border: 2px dashed #dee2e6;
        }

        .month-item:hover {
            transform: scale(1.05);
        }

        .history-section {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .history-header {
            background: linear-gradient(135deg, var(--primary-color), #3a6b8a);
            color: white;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .history-title {
            margin: 0;
            font-weight: 600;
        }

        .pending-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .table-container {
            padding: 0;
        }

        .custom-table {
            margin: 0;
            border: none;
        }

        .custom-table th {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
            border: none;
            padding: 1rem;
            font-size: 0.9rem;
        }

        .custom-table td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
        }

        .custom-table tbody tr:hover {
            background: rgba(69, 125, 159, 0.05);
        }

        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-paid {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-pending {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .status-upcoming {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .amount-cell {
            font-weight: 600;
            color: var(--primary-color);
        }

        .pagination-container {
            padding: 1.5rem;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .custom-pagination {
            margin: 0;
            justify-content: center;
        }

        .custom-pagination .page-link {
            border: none;
            color: var(--primary-color);
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .custom-pagination .page-link:hover {
            background: rgba(69, 125, 159, 0.1);
            color: var(--primary-color);
        }

        .custom-pagination .page-item.active .page-link {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 2px 4px rgba(69, 125, 159, 0.3);
        }

        .alert-custom {
            border: none;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
        }

        @media (max-width: 768px) {
            .calendar-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .info-cards {
                grid-template-columns: 1fr;
            }
            
            .history-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include "includes/header.php"; ?>
    
    <div id="layoutSidenav_content">
        <main>
            <div class="main-container">
                <!-- Encabezado de la página -->
                <div class="page-header">
                    <h1 class="page-title">Plan de Pagos Mensuales</h1>
                    <p class="page-subtitle">Sistema Poncelet - Gestión de Suscripciones</p>
                </div>

                <!-- Cards informativos -->
                <div class="info-cards">
                    <div class="info-card info-card-monthly">
                        <div class="info-card-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h5 class="info-card-title">Pago Mensual</h5>
                        <p class="info-card-text">
                            <strong>Mantenimiento del Sistema</strong><br>
                            Monto: <strong>100 Bs</strong> cada mes<br>
                            Incluye soporte técnico y actualizaciones
                        </p>
                    </div>

                    <div class="info-card info-card-annual">
                        <div class="info-card-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <h5 class="info-card-title">Pago Anual</h5>
                        <p class="info-card-text">
                            <strong>Hosting y Dominio</strong><br>
                            Cada <strong>10 de Noviembre</strong><br>
                            Renovación de servicios de hosting
                        </p>
                    </div>
                </div>

                <!-- Calendario anual -->
                <div class="calendar-section">
                    <div class="calendar-header">
                        <h4 class="calendar-title">Estado de Pagos</h4>
                        <span class="calendar-year"><?php echo $año_actual; ?></span>
                    </div>
                    
                    <div class="calendar-grid">
                        <?php foreach ($meses_nombres as $num_mes => $nombre_mes): ?>
                            <?php 
                                $estado = $meses_año[$num_mes];
                                $clase = '';
                                $icono = '';
                                $tooltip = '';
                                
                                switch ($estado) {
                                    case 1:
                                        $clase = 'month-paid';
                                        $icono = '<i class="fas fa-check-circle"></i>';
                                        $tooltip = 'Pagado';
                                        break;
                                    case 0:
                                        $clase = 'month-pending';
                                        $icono = '<i class="fas fa-exclamation-circle"></i>';
                                        $tooltip = 'Pendiente';
                                        break;
                                    case 2:
                                        $clase = 'month-upcoming';
                                        $icono = '<i class="fas fa-clock"></i>';
                                        $tooltip = 'Próximo pago';
                                        break;
                                    default:
                                        $clase = 'month-no-data';
                                        $icono = '<i class="fas fa-minus"></i>';
                                        $tooltip = 'Sin registro';
                                        break;
                                }
                            ?>
                            <div class="month-item <?php echo $clase; ?>" title="<?php echo $nombre_mes . ' - ' . $tooltip; ?>">
                                <div style="margin-bottom: 0.5rem;"><?php echo $icono; ?></div>
                                <div><?php echo $nombre_mes; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Historial de pagos -->
                <div class="history-section">
                    <div class="history-header">
                        <h4 class="history-title">
                            <i class="fas fa-history me-2"></i>
                            Historial de Pagos
                        </h4>
                        <?php if ($pendientes > 0): ?>
                            <div class="pending-badge">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                <?php echo $pendientes; ?> pendiente<?php echo $pendientes > 1 ? 's' : ''; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="table-container">
                        <?php if (mysqli_num_rows($query_pagos) > 0): ?>
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th width="10%">ID</th>
                                        <th width="30%">Fecha de Pago</th>
                                        <th width="20%">Monto</th>
                                        <th width="25%">Estado</th>
                                        <th width="15%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($data = mysqli_fetch_array($query_pagos)): ?>
                                        <tr>
                                            <td class="amount-cell">#<?php echo str_pad($data['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                            <td>
                                                <i class="fas fa-calendar-alt text-muted me-2"></i>
                                                <?php echo strftime("%d de %B de %Y", strtotime($data['fecha_inicio'])); ?>
                                            </td>
                                            <td class="amount-cell">
                                                <i class="fas fa-coins me-1"></i>
                                                100 Bs
                                            </td>
                                            <td>
                                                <?php if ($data['estado'] == 1): ?>
                                                    <span class="status-badge status-paid">
                                                        <i class="fas fa-check me-1"></i>Pagado
                                                    </span>
                                                <?php else: ?>
                                                    <span class="status-badge status-pending">
                                                        <i class="fas fa-clock me-1"></i>Pendiente
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" onclick="verDetalle(<?php echo $data['id']; ?>)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>

                            <!-- Paginación -->
                            <div class="pagination-container">
                                <nav>
                                    <ul class="pagination custom-pagination">
                                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                            <li class="page-item <?php if ($i == $pagina_actual) echo 'active'; ?>">
                                                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php else: ?>
                            <div class="p-4 text-center">
                                <div class="alert alert-custom alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No hay registros de suscripciones.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Próximo pago -->
                <?php if (mysqli_num_rows($query_proximo) > 0): ?>
                    <div class="mt-4">
                        <div class="history-section">
                            <div class="history-header">
                                <h4 class="history-title">
                                    <i class="fas fa-calendar-plus me-2"></i>
                                    Próximo Pago
                                </h4>
                            </div>

                            <div class="table-container">
                                <table class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th width="10%">ID</th>
                                            <th width="30%">Fecha de Pago</th>
                                            <th width="20%">Monto</th>
                                            <th width="40%">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($data = mysqli_fetch_array($query_proximo)): ?>
                                            <tr>
                                                <td class="amount-cell">#<?php echo str_pad($data['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                                <td>
                                                    <i class="fas fa-calendar-alt text-muted me-2"></i>
                                                    <?php echo strftime("%d de %B de %Y", strtotime($data['fecha_inicio'])); ?>
                                                </td>
                                                <td class="amount-cell">
                                                    <i class="fas fa-coins me-1"></i>
                                                    100 Bs
                                                </td>
                                                <td>
                                                    <span class="status-badge status-upcoming">
                                                        <i class="fas fa-clock me-1"></i>Próximo a pagar
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        function verDetalle(id) {
            // Aquí puedes agregar la lógica para ver más detalles del pago
            alert('Ver detalles del pago ID: ' + id);
        }

        // Animación suave para elementos al cargar
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.info-card, .calendar-grid, .history-section');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });

            // Tooltips para el calendario
            const monthItems = document.querySelectorAll('.month-item');
            monthItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>