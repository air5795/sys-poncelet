<?php
ob_start();
require_once 'dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
include 'Invoice.php';
include 'conexion.php';
$invoice = new Invoice();

if (!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
    $invoiceValues = $invoice->getInvoice($_GET['invoice_id']);
    $invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);
}

$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceValues['fecha_cotizacion']));

// Estilos CSS para el PDF
$css = '
<style>
* {
   padding:4px;
   margin:4px;
}

hr {
    padding:0px;
    margin:2px;
 }
    body {
        font-family: Arial, sans-serif;
        font-size: 10px;
        color: #333;
        background-color: #F2F2F2;
    }
    
    header {
		position: fixed;
		top: -40px;
		left: 0px;
		right: 0px;
		height: 30px;
		font-size: 20px !important;

		/** Extra personal styles **/
		background-color: #008B8B;
		color: white;
		text-align: center;
		line-height: 35px;
	}

	footer {
		position: fixed; 
		bottom: 0px; 
		left: 0px; 
		right: 0px;
		height: 40px; 
		font-size: 20px !important;

		/** Extra personal styles **/
		
		color: white;
		text-align: center;
		line-height: 35px;
	}
    
    .address {
        width: 65%;
        float: left;
    }
    
    .info {
        width: 35%;
        float: right;
        text-align: right;
    }
    
    .table-header {
        background-color: #FF5451;
        font-weight: bold;
        color: #FFF;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    
    th, td {
        border: 1px solid #ccc;
        padding: 5px;
    }
    
    .subtotal {
        text-align: right;
    }
    
    .total {
        text-align: right;
        font-weight: bold;
        width:200px;
    }

    .red-letters {
        text-shadow: 0 0 1px red;
      }

      .page-number {
        position: fixed;
        bottom: -40px;
        text-align: center;
        font-size: 12px;
        width: 100%;
        font-family: Arial, sans-serif;
      }
    
</style>';


$output = '<html><head>' . $css . '</head><body>';

$output .= '    

<footer>
<div id="watermark" >
	/* pie de pagina poner imagen */
	
</div>
</footer>' ;
$output .= '<table>';


$output .= '<tr>
    <td colspan="8">
        <table width="100%" cellpadding="5">
            <tr>
				<td width="20%">
				/* poner imagen encabezado */
				<td>
                <td width="68%"> 
                <b style="font-size: 11px">
                    EMPRESA COMERCIALIZADORA PONCELET 
                    </b>  
                <br>
                    <b style="font-size: 10px;">NIT: </b> 5505982013<br>
                    <b style="font-size: 10px;">DIRECCIÓN: </b> CALLE GUALBERTO VILLARROEL N° 12 EDIF. PLAZA / POTOSÍ <br>
                    <b style="font-size: 10px;">REPRESENTANTE LEGAL: </b> ARISPE PONCE DENIS DANIEL<br>

                    <hr>
                <strong style="font-size:10px">COTIZACION A:</strong> ' . $invoiceValues['cliente_nombre'] . '<br>
                <strong style="font-size:10px">NIT:</strong> ' . $invoiceValues['cliente_direccion'] . '
                </td>
                <td width="32%" align="right">
                    <strong> <span style="font-size: 11px;background-color:#FF5451; padding:1px; color:white;border-radius:3px">Cotizacion N°: 000' . $invoiceValues['id_cotizacion'] . '</span></strong><br>
                    Fecha: ' . $invoiceDate . ' <br> 
                    
					
                </td>
            </tr>
        </table>
    </td>
</tr>';

$output .= '<tr class="table-header">
    <th width="5%">No.</th>
    <th>Código Cotización</th>
    <th width="35%" >Nombre Item</th>
    <th>Marca</th>
    <th>U/M</th>
    <th>Cantidad</th>
    <th>Precio</th>
    <th>Sub-Total</th>
</tr>';

$count = 0;
foreach ($invoiceItems as $invoiceItem) {
    $count++;
    $output .= '<tr>
        <td align="center">' . $count . '</td>
        <td align="center">' .'00CMPRO'. $invoiceItem["codigo_item"] . '</td>
        <td align="left">
            <textarea name="nombre_item[]" class="form-control" style="resize: none; height: auto; background-color: transparent; border:none;font-family: sans-serif;" readonly>'
            . $invoiceItem["nombre_item"] . '</textarea>
        </td>
        <td align="center">' . $invoiceItem["marca_item"] . '</td>
        <td align="center">' . $invoiceItem["unidad_item"] . '</td>
        <td align="center">' . intval($invoiceItem["cantidad_item"]) . '</td>
        <td align="right">' . number_format($invoiceItem["precio_item"], 2, '.', ',') . ' Bs' . '</td>
        <td align="right">' . number_format($invoiceItem["subtotal_item"], 2, '.', ',') . ' Bs' . '</td>
    </tr>';
}



$output .= '</table>';
$output .= '</table>';


$output .= '<table>';
$output .= '<tr>
<td colspan="8" class="total" style="background-color: #FF5451;color:white">Total:</td>

<td class="total">' . number_format($invoiceValues['total_antes_impuestos'],2,'.',',')  .' Bs'. '</td>
</tr>
<tr>
    <td colspan="8" class="subtotal"><b>Garantia</b></td>
    <td class="subtotal">' . $invoiceValues['tiempo_garantia'] . '</td>
</tr>
<tr>
    <td colspan="8" class="subtotal"><b>Lugar de Entrega</b></td>
    <td class="subtotal">' .'ALMACEN '. $invoiceValues['cliente_nombre'] . '</td>
</tr>

<tr>
    <td colspan="8" class="subtotal"><b>Validez de Cotizacion</b></td>
    <td class="subtotal">' . $invoiceValues['validez_cotizacion'] . '</td>
</tr>

<tr>
    <td colspan="8" class="subtotal"><b>Tiempo de Entrega</b></td>
    <td class="subtotal">' . $invoiceValues['tiempo_entrega'] . '</td>
</tr>

<tr>
    <td colspan="8" class="subtotal"><b>Firma Representante Legal</b></td>
    <td class="subtotal">/* poner imagen */</td>
</tr>
';

$output .= '</table>';


$output .= '</body></html>';

// Crear el PDF de la factura
$invoiceFileName = 'Cotizacion-PONCELET-' . $invoiceValues['id_cotizacion'] . '.pdf';

$dompdf = new Dompdf();

$dompdf->loadHtml($output);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($invoiceFileName, ['Attachment' => false]);
