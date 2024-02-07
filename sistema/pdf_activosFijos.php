<?php
session_start();
include "../conexion.php";

require_once 'pdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Crear una instancia de Dompdf
$dompdf = new Dompdf();

try {
    // Consulta para obtener los datos de la base de datos
    $sql = mysqli_query($conexion, "SELECT id_activo, qr, nombre FROM activos_fijos");

    // Crear el documento HTML para Dompdf
    $html = '<html>
                <head>
                    <meta charset="utf-8" />
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
                    <meta name="description" content="" />
                    <meta name="author" content="" />
                    <link href="css/style3.css" rel="stylesheet" />
                    <title>SISPONCELET</title>
                </head>
                <body>';

    $html .= '<table border="1" style="width: 15%;">';

    while ($row = mysqli_fetch_array($sql)) {
        $idActivo = $row['id_activo'];
        $rutaQR = $row['qr'];
        $nombre = $row['nombre'];

        // Fila para "Activo-Fijo Poncelet"
        $html .= '<tr>';
        $html .= "<th colspan=\"2\">ACTIVO FIJO <br> <span style =\"font-size:7px\"> PONCELET CONSTRUCTORA COMERCIALIZADORA</span></th>";
        $html .= '</tr>';

        // Fila para la imagen del QR
        $html .= '<tr style="height: 200px;">'; // Ajusta la altura según tus necesidades
        $html .= '<td colspan="2" style="text-align: center;"><img src="sub-inventarios-activos/'.$rutaQR.'" style="max-width: 90px; max-height: 90px;"></td>';
        $html .= '</tr>';

        // Fila para el ID del activo
        $html .= '<tr>';
        $html .= "<td>ID:</td>";
        $html .= "<td><span style =\"font-size:7px\">COD-00$idActivo</span></td>";
        $html .= '</tr>';

        
    }

    $html .= '</table>';
    $html .= '</body></html>';

    // Limpiar el búfer de salida antes de cargar un nuevo HTML
    ob_end_clean();

    // Cargar el HTML en Dompdf
    $dompdf->loadHtml($html);

    // Configurar el tamaño del papel (puedes ajustarlo según tus necesidades)
    /* $dompdf->setPaper('A4', 'portrait'); */
    $dompdf->setPaper([0, 0, 150, 750]);

    // Renderizar el PDF
    $dompdf->render();

    // Generar el nombre del archivo PDF
    $pdfFileName = 'activos_fijos_qr.pdf';

    // Descargar el PDF en lugar de mostrarlo en el navegador
    $dompdf->stream($pdfFileName, array('Attachment' => 0));

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
} finally {
    // Cerrar la conexión a la base de datos
    if ($conexion) {
        mysqli_close($conexion);
    }
}
?>
