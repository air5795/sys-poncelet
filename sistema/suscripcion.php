<?php
    session_start();
    include "../conexion.php";

    // Obtener la fecha actual
    $fecha_actual = date("Y-m-d");

    // Configurar localización en español para mostrar fechas correctamente
    setlocale(LC_TIME, "es_ES.UTF-8", "Spanish_Spain.1252");

    // Paginación AJAX
    $registros_por_pagina = 6;
    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $offset = ($pagina_actual - 1) * $registros_por_pagina;

    // Si es una petición AJAX para paginación
    if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
        $query_pagos = mysqli_query($conexion, "SELECT * FROM suscripcion_sistema WHERE estado IN (0,1) ORDER BY fecha_inicio DESC LIMIT $offset, $registros_por_pagina");
        
        $html = '';
        while ($data = mysqli_fetch_array($query_pagos)) {
            $estado_badge = $data['estado'] == 1 
                ? '<span class="status-badge status-paid"><i class="fas fa-check"></i> Pagado</span>'
                : '<span class="status-badge status-pending"><i class="fas fa-clock"></i> Pendiente</span>';
            
            $tipo_badge = strtoupper($data['tipo']) == 'MENSUAL' 
                ? '<span class="tipo-badge tipo-mensual">MENSUAL</span>'
                : '<span class="tipo-badge tipo-anual">ANUAL</span>';
            
            $html .= '<tr>
                <td>#' . str_pad($data['id'], 3, '0', STR_PAD_LEFT) . '</td>
                <td>' . strftime("%d/%m/%Y", strtotime($data['fecha_inicio'])) . '</td>
                <td class="amount-cell">' . (strtoupper($data['tipo']) == 'MENSUAL' ? '100' : '400') . ' Bs</td>
                <td>' . $tipo_badge . '</td>
                <td>' . $estado_badge . '</td>
            </tr>';
        }
        
        echo $html;
        exit;
    }

    // Obtener los registros con estado 0 y 1 paginados
    $query_pagos = mysqli_query($conexion, "SELECT * FROM suscripcion_sistema WHERE estado IN (0,1) ORDER BY fecha_inicio DESC LIMIT $offset, $registros_por_pagina");
    
    // Contar total de registros para la paginación
    $total_registros_query = mysqli_query($conexion, "SELECT COUNT(*) as total FROM suscripcion_sistema WHERE estado IN (0,1)");
    $total_registros = mysqli_fetch_assoc($total_registros_query)['total'];
    $total_paginas = ceil($total_registros / $registros_por_pagina);
    
    // Obtener solo el registro del próximo mes con estado 2
    $query_proximo = mysqli_query($conexion, "SELECT * FROM suscripcion_sistema WHERE estado = 2 AND fecha_inicio >= '$fecha_actual' ORDER BY fecha_inicio ASC LIMIT 1");
    
    // Contar la cantidad de pagos pendientes y total de pagos realizados
    $query_pendientes = mysqli_query($conexion, "SELECT COUNT(*) as total FROM suscripcion_sistema WHERE estado = 0");
    $resultado_pendientes = mysqli_fetch_assoc($query_pendientes);
    $pendientes = $resultado_pendientes['total'];
    
    $query_pagados = mysqli_query($conexion, "SELECT COUNT(*) as total FROM suscripcion_sistema WHERE estado = 1");
    $resultado_pagados = mysqli_fetch_assoc($query_pagados);
    $pagados = $resultado_pagados['total'];

    // Obtener datos para el calendario mensual (6 meses atrás y 6 adelante del mes actual)
    $mes_actual = (int)date("n");
    $año_actual = (int)date("Y");
    
    $meses_mostrar = [];
    for ($i = -6; $i <= 5; $i++) {
        $mes_calc = $mes_actual + $i;
        $año_calc = $año_actual;
        
        if ($mes_calc <= 0) {
            $mes_calc += 12;
            $año_calc--;
        } elseif ($mes_calc > 12) {
            $mes_calc -= 12;
            $año_calc++;
        }
        
        $fecha_mes = $año_calc . "-" . str_pad($mes_calc, 2, "0", STR_PAD_LEFT) . "-01";
        $query_mes = mysqli_query($conexion, "SELECT estado FROM suscripcion_sistema WHERE DATE_FORMAT(fecha_inicio, '%Y-%m') = '" . substr($fecha_mes, 0, 7) . "' AND tipo = 'MENSUAL'");
        
        if ($data_mes = mysqli_fetch_assoc($query_mes)) {
            $estado = $data_mes['estado'];
        } else {
            $estado = -1; // No existe registro
        }
        
        $meses_mostrar[] = [
            'numero' => $mes_calc,
            'año' => $año_calc,
            'estado' => $estado,
            'es_actual' => ($mes_calc == $mes_actual && $año_calc == $año_actual)
        ];
    }
    
    // Obtener datos para el calendario de años (3 años atrás y 3 adelante)
    $años_mostrar = [];
    for ($i = -3; $i <= 2; $i++) {
        $año_calc = $año_actual + $i;
        $query_año = mysqli_query($conexion, "SELECT estado FROM suscripcion_sistema WHERE YEAR(fecha_inicio) = $año_calc AND tipo = 'ANUAL'");
        
        if ($data_año = mysqli_fetch_assoc($query_año)) {
            $estado = $data_año['estado'];
        } else {
            $estado = -1; // No existe registro
        }
        
        $años_mostrar[] = [
            'año' => $año_calc,
            'estado' => $estado,
            'es_actual' => ($año_calc == $año_actual)
        ];
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
            --shadow: 0 2px 8px rgba(0,0,0,0.08);
            --border-radius: 8px;
        }

        body {
            background: #f5f6fa;
            font-size: 14px;
        }

        .main-container {
            padding: 15px;
            max-width: 100vw;
            margin: 0;
        }

        .page-header {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px 0;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .page-title {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.6rem;
            margin-bottom: 5px;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            height: calc(100vh - 200px);
        }

        .left-column, .right-column {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Cards compactas */
        .info-cards {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .info-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 12px 15px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 50px;
        }

        .info-card-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: white;
            flex-shrink: 0;
        }

        .info-card-monthly .info-card-icon {
            background: var(--primary-color);
        }

        .info-card-annual .info-card-icon {
            background: var(--warning-color);
        }

        .info-card-content {
            flex: 1;
        }

        .info-card-title {
            font-weight: 600;
            color: #495057;
            margin: 0 0 2px 0;
            font-size: 0.9rem;
        }

        .info-card-text {
            color: #6c757d;
            margin: 0;
            font-size: 0.8rem;
            line-height: 1.3;
        }

        /* Calendario compacto */
        .calendar-section, .calendar-section-años {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 15px;
            flex: 1;
        }

        .calendar-section-años {
            margin-top: 15px;
        }

        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .calendar-title {
            color: #495057;
            font-weight: 600;
            margin: 0;
            font-size: 1.1rem;
        }

        .year-selector {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .year-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .current-year {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 8px;
        }

        .calendar-grid-años {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 8px;
        }

        .month-item, .year-item {
            text-align: center;
            padding: 8px 4px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .year-item {
            padding: 12px 8px;
            font-size: 0.8rem;
        }

        .month-current, .year-current {
            border: 2px solid #333 !important;
            font-weight: 700;
        }

        .month-paid {
            background: #d4edda;
            color: var(--success-color);
        }

        .month-pending {
            background: #f8d7da;
            color: var(--danger-color);
        }

        .month-upcoming {
            background: #fff3cd;
            color: #856404;
        }

        .month-no-data {
            background: #f8f9fa;
            color: #6c757d;
        }

        .month-item:hover, .year-item:hover {
            transform: scale(1.05);
        }

        .month-name {
            font-size: 0.7rem;
            margin-bottom: 2px;
        }

        .month-year {
            font-size: 0.6rem;
            opacity: 0.7;
        }

        /* Historial compacto */
        .history-section {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .history-header {
            background: var(--primary-color);
            color: white;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .history-title {
            margin: 0;
            font-weight: 600;
            font-size: 1rem;
        }

        .pending-badge {
            background: rgba(220, 53, 69, 0.9);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .paid-badge {
            background: rgba(40, 167, 69, 0.9);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            margin-left: 8px;
        }

        .table-container {
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 400px);
        }

        .custom-table {
            margin: 0;
            border: none;
            font-size: 0.85rem;
            text-align: center;
        }

        .custom-table th {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
            border: none;
            padding: 10px 12px;
            font-size: 0.8rem;
            position: sticky;
            top: 0;
            z-index: 10;
            text-align: center;
        }

        .custom-table td {
            padding: 8px 12px;
            border: none;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
            text-align: center;
        }

        .custom-table tbody tr:hover {
            background: rgba(69, 125, 159, 0.05);
        }

        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .status-paid {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .status-pending {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        .amount-cell {
            font-weight: 600;
            color: var(--primary-color);
        }

        .tipo-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .tipo-mensual {
            background: rgba(0, 123, 255, 0.1);
            color: #0056b3;
        }

        .tipo-anual {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
        }

        .pagination-container {
            padding: 10px 15px;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .custom-pagination {
            margin: 0;
            justify-content: center;
            gap: 4px;
        }

        .pagination-btn {
            border: none;
            background: white;
            color: var(--primary-color);
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .pagination-btn:hover {
            background: rgba(69, 125, 159, 0.1);
        }

        .pagination-btn.active {
            background: var(--primary-color);
            color: white;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Sección de próximo pago con color de alerta */
        .next-payment-section {
            background: #fff8e1;
            border: 1px solid #ffcc02;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            max-height: 150px;
        }

        .next-payment-header {
            background: linear-gradient(135deg, #ffb300, #ff8f00);
            color: white;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .next-payment-content {
            padding: 15px;
            background: #fff8e1;
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        @media (max-width: 1200px) {
            .layout-grid {
                grid-template-columns: 1fr;
                height: auto;
            }
            
            .calendar-grid, .calendar-grid-años {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 768px) {
            .calendar-grid, .calendar-grid-años {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .layout-grid {
                gap: 10px;
            }
            
            .main-container {
                padding: 10px;
            }

            .history-header {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include "includes/header.php"; ?>
    
    <div id="layoutSidenav_content">
        <main>
            <div class="main-container">
                <!-- Encabezado compacto -->
                <div class="page-header">
                    <h1 class="page-title">Plan de Pagos - Sistema Poncelet</h1>
                    <p class="page-subtitle">Gestión de Suscripciones</p>
                </div>

                <!-- Layout en 2 columnas -->
                <div class="layout-grid">
                    <!-- Columna Izquierda -->
                    <div class="left-column">
                        <!-- Cards informativas compactas -->
                        <div class="info-cards">
                            <div class="info-card info-card-monthly">
                                <div class="info-card-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="info-card-content">
                                    <h6 class="info-card-title">Pago Mensual - 100 Bs</h6>
                                    <p class="info-card-text">Mantenimiento del sistema y soporte técnico</p>
                                </div>
                            </div>

                            <div class="info-card info-card-annual">
                                <div class="info-card-icon">
                                    <i class="fas fa-server"></i>
                                </div>
                                <div class="info-card-content">
                                    <h6 class="info-card-title">Pago Anual - 400 Bs</h6>
                                    <p class="info-card-text">Hosting y dominio - 10 de Noviembre</p>
                                </div>
                            </div>
                        </div>

                        <!-- Calendario de estados mensuales -->
                        <div class="calendar-section">
                            <div class="calendar-header">
                                <h5 class="calendar-title">Estado de Pagos Mensuales</h5>
                                <div class="year-selector">
                                    <button class="year-btn" onclick="cambiarPeriodo(-1)">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <span class="current-year" id="currentPeriod">
                                        <?php echo date('M Y', strtotime('-6 months')) . ' - ' . date('M Y', strtotime('+5 months')); ?>
                                    </span>
                                    <button class="year-btn" onclick="cambiarPeriodo(1)">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="calendar-grid">
                                <?php foreach ($meses_mostrar as $mes): ?>
                                    <?php 
                                        $estado = $mes['estado'];
                                        $clase = '';
                                        $icono = '';
                                        $tooltip = '';
                                        
                                        switch ($estado) {
                                            case 1:
                                                $clase = 'month-paid';
                                                $icono = '<i class="fas fa-check"></i>';
                                                $tooltip = 'Pagado';
                                                break;
                                            case 0:
                                                $clase = 'month-pending';
                                                $icono = '<i class="fas fa-times"></i>';
                                                $tooltip = 'Pendiente';
                                                break;
                                            case 2:
                                                $clase = 'month-upcoming';
                                                $icono = '<i class="fas fa-clock"></i>';
                                                $tooltip = 'Próximo';
                                                break;
                                            default:
                                                $clase = 'month-no-data';
                                                $icono = '<i class="fas fa-minus"></i>';
                                                $tooltip = 'Sin datos';
                                                break;
                                        }
                                        
                                        if ($mes['es_actual']) {
                                            $clase .= ' month-current';
                                        }
                                    ?>
                                    <div class="month-item <?php echo $clase; ?>" title="<?php echo $meses_nombres[$mes['numero']] . ' ' . $mes['año'] . ' - ' . $tooltip; ?>">
                                        <div class="month-name"><?php echo $meses_nombres[$mes['numero']]; ?></div>
                                        <div class="month-year"><?php echo $mes['año']; ?></div>
                                        <div><?php echo $icono; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Calendario de estados anuales -->
                        <div class="calendar-section-años">
                            <div class="calendar-header">
                                <h5 class="calendar-title">Estado de Pagos Anuales</h5>
                                <div class="year-selector">
                                    <span class="current-year">
                                        <?php echo ($año_actual - 3) . ' - ' . ($año_actual + 2); ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="calendar-grid-años">
                                <?php foreach ($años_mostrar as $año): ?>
                                    <?php 
                                        $estado = $año['estado'];
                                        $clase = '';
                                        $icono = '';
                                        $tooltip = '';
                                        
                                        switch ($estado) {
                                            case 1:
                                                $clase = 'month-paid';
                                                $icono = '<i class="fas fa-check"></i>';
                                                $tooltip = 'Pagado';
                                                break;
                                            case 0:
                                                $clase = 'month-pending';
                                                $icono = '<i class="fas fa-times"></i>';
                                                $tooltip = 'Pendiente';
                                                break;
                                            case 2:
                                                $clase = 'month-upcoming';
                                                $icono = '<i class="fas fa-clock"></i>';
                                                $tooltip = 'Próximo';
                                                break;
                                            default:
                                                $clase = 'month-no-data';
                                                $icono = '<i class="fas fa-minus"></i>';
                                                $tooltip = 'Sin datos';
                                                break;
                                        }
                                        
                                        if ($año['es_actual']) {
                                            $clase .= ' year-current';
                                        }
                                    ?>
                                    <div class="year-item <?php echo $clase; ?>" title="<?php echo $año['año'] . ' - ' . $tooltip; ?>">
                                        <div style="margin-bottom: 4px;"><?php echo $icono; ?></div>
                                        <div><?php echo $año['año']; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha -->
                    <div class="right-column">
                        <!-- Historial de pagos -->
                        <div class="history-section">
                            <div class="history-header">
                                <h5 class="history-title">
                                    <i class="fas fa-history me-2"></i>
                                    Historial de Pagos
                                </h5>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <?php if ($pendientes > 0): ?>
                                        <div class="pending-badge">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            <?php echo $pendientes; ?> pendiente<?php echo $pendientes > 1 ? 's' : ''; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($pagados > 0): ?>
                                        <div class="paid-badge">
                                            <i class="fas fa-check me-1"></i>
                                            <?php echo $pagados; ?> realizado<?php echo $pagados > 1 ? 's' : ''; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="table-container">
                                <table class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th width="12%">ID</th>
                                            <th width="25%">Fecha</th>
                                            <th width="18%">Monto</th>
                                            <th width="20%">Tipo</th>
                                            <th width="25%">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="historialTableBody">
                                        <?php while ($data = mysqli_fetch_array($query_pagos)): ?>
                                            <tr>
                                                <td>#<?php echo str_pad($data['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                                <td><?php echo strftime("%d/%m/%Y", strtotime($data['fecha_inicio'])); ?></td>
                                                <td class="amount-cell"><?php echo (strtoupper($data['tipo']) == 'MENSUAL' ? '100' : '400'); ?> Bs</td>
                                                <td>
                                                    <?php if (strtoupper($data['tipo']) == 'MENSUAL'): ?>
                                                        <span class="tipo-badge tipo-mensual">MENSUAL</span>
                                                    <?php else: ?>
                                                        <span class="tipo-badge tipo-anual">ANUAL</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($data['estado'] == 1): ?>
                                                        <span class="status-badge status-paid">
                                                            <i class="fas fa-check"></i> Pagado
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="status-badge status-pending">
                                                            <i class="fas fa-clock"></i> Pendiente
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación AJAX -->
                            <div class="pagination-container">
                                <div class="custom-pagination" id="paginationContainer">
                                    <?php if ($total_paginas > 1): ?>
                                        <button class="pagination-btn" onclick="cargarPagina(<?php echo max(1, $pagina_actual-1); ?>)" <?php echo $pagina_actual == 1 ? 'disabled' : ''; ?>>
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        
                                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                                            <button class="pagination-btn <?php echo $i == $pagina_actual ? 'active' : ''; ?>" onclick="cargarPagina(<?php echo $i; ?>)">
                                                <?php echo $i; ?>
                                            </button>
                                        <?php endfor; ?>
                                        
                                        <button class="pagination-btn" onclick="cargarPagina(<?php echo min($total_paginas, $pagina_actual+1); ?>)" <?php echo $pagina_actual == $total_paginas ? 'disabled' : ''; ?>>
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Próximo pago (si existe) -->
                        <?php if (mysqli_num_rows($query_proximo) > 0): ?>
                            <div class="next-payment-section">
                                <div class="next-payment-header">
                                    <h5 class="history-title">
                                        <i class="fas fa-calendar-plus me-2"></i>
                                        Próximo Pago
                                    </h5>
                                </div>

                                <div class="next-payment-content">
                                    <?php while ($data = mysqli_fetch_array($query_proximo)): ?>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo strftime("%d de %B de %Y", strtotime($data['fecha_inicio'])); ?></strong>
                                                <br>
                                                <small class="text-muted">Monto: <?php echo (strtoupper($data['tipo']) == 'MENSUAL' ? '100' : '400'); ?> Bs</small>
                                            </div>
                                            <span class="status-badge" style="background: rgba(255, 193, 7, 0.1); color: #856404;">
                                                <i class="fas fa-clock"></i> Próximo
                                            </span>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Función para cargar página sin recargar
        function cargarPagina(pagina) {
            const tbody = document.getElementById('historialTableBody');
            const container = document.querySelector('.history-section');
            
            // Agregar clase de carga
            container.classList.add('loading');
            
            // Realizar petición AJAX
            fetch(`?ajax=1&pagina=${pagina}`)
                .then(response => response.text())
                .then(data => {
                    tbody.innerHTML = data;
                    
                    // Actualizar paginación
                    actualizarPaginacion(pagina);
                    
                    // Quitar clase de carga
                    container.classList.remove('loading');
                })
                .catch(error => {
                    console.error('Error:', error);
                    container.classList.remove('loading');
                });
        }

        // Función para actualizar la paginación
        function actualizarPaginacion(paginaActual) {
            const buttons = document.querySelectorAll('.pagination-btn');
            buttons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent == paginaActual) {
                    btn.classList.add('active');
                }
            });
        }

        // Función para cambiar período del calendario (futura implementación)
        function cambiarPeriodo(direccion) {
            // Aquí puedes implementar la lógica para cambiar el período del calendario
            console.log('Cambiar período:', direccion);
        }

        // Animación al cargar
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.info-card, .calendar-section, .calendar-section-años, .history-section, .next-payment-section');
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    element.style.transition = 'all 0.4s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>