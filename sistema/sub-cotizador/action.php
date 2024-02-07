<?php
// Iniciar la sesión
session_start();
// Configurar la duración de la sesión en segundos (por ejemplo, 1 hora)
$sesionDuracion = 3600; // 3600 segundos = 1 hora

// Verificar si la sesión está configurada
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $sesionDuracion)) {
    // La sesión ha expirado, destruir la sesión
    session_unset();
    session_destroy();
} else {
    // La sesión no ha expirado, actualizar el tiempo de actividad
    $_SESSION['last_activity'] = time();
}
include 'Invoice.php';
$invoice = new Invoice();
if($_POST['action'] == 'delete_invoice' && $_POST['id']) {
	$invoice->deleteInvoice($_POST['id']);	
	$jsonResponse = array(
		"status" => 1	
	);
	echo json_encode($jsonResponse);	
}


