<?php


session_start();
include "../conexion.php";

$idRecibo = trim($_POST['idRecibo']);
$nombre = trim($_POST['names']);
$monto = trim($_POST['montos']);
$concepto = trim($_POST['concept']);
$fecha = trim($_POST['fech']);



require_once 'pdf/vendor/autoload.php';
use Dompdf\Dompdf;
ob_start();
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cotización</title>

  <style type="text/css">
    /** Define the margins of your page **/
    @page {
                margin: 100px 25px;
            }

            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;
                font-size: 20px !important;

                /** Extra personal styles **/
                background-color: #008B8B;
                color: white;
                text-align: center;
                line-height: 35px;
            }
      
            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 
                font-size: 20px !important;

                /** Extra personal styles **/
                background-color: #008B8B;
                color: white;
                text-align: center;
                line-height: 35px;
            }
    * {
      font-family: Verdana, Arial, sans-serif;
    }
    table{
      font-size: x-small;
    }
    tfoot tr td{
      font-weight: bold;
      font-size: x-small;
    }
    .gray {
      background-color: lightgray;
    }

    .success {
      color: green;
    }
    .fon{
      font-size: 10px;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

 

    #watermark2 {
                position: fixed;

                /** 
                    Establece una posición en la página para tu imagen
                    Esto debería centrarlo verticalmente
                **/
                bottom:   16cm;
                left:     4cm;

                /** Cambiar las dimensiones de la imagen **/
                width:    12cm;
                height:   8cm;

                /** Tu marca de agua debe estar detrás de cada contenido **/
                z-index:  -1000;
            }
    
  </style>
</head>
<body >
        <header>
          <img src="img/FONDITO.png" height="100%" width="100%" />                                 

        </header>

  <!-- Cabecera -->

        <div id="watermark2">
            <img style="opacity:0.1;" src="img/ICONOGRANDE.png" height="100%" width="100%" />
        </div>
                         

  <table border="1" width="100%" style="border-collapse:collapse; font-size:larger;" >
  
    
            <tr >
            <th  colspan="3" style="background-color: #ff5050; text-align:left;font-size:15px;" > <span style="color:white">DATOS DE LA EMPRESA</span></th>
            </tr>
            

            <tr class="fon" style="font-size: 11px;">
                <td> <strong> REPRESENTANTE LEGAL : </strong> ARISPE PONCE DENIS DANIEL </td>
                <td> <strong> CIUDAD : </strong> POTOSÍ</td>
                <td> <strong> NIT : </strong> 5505982013</td>
            
            </tr>

            <tr class="fon" style="font-size: 11px;">
            <td colspan="3"> <strong> DIRECCION : </strong> OFICINA CENTRAL GUALBERTO VILLARROEL N°12 EDIF PLAZA AMB 7 PISO 4 </td>
            
            </tr>
            <tr class="fon" style="font-size: 11px;">
            <td> <strong> TELEFONO : </strong> 72867168 - 70022060 </td>
            <td colspan="2"> <strong> EMAIL : </strong> comercializadora.naxsan@gmail.com</td>
            </tr>
    
  </table>

  <table>
                          <tr style="text-align: right; border:solid white;">
                              <td colspan="1" style="background-color:white;text-align: left; color:#5c5c5c; border:solid white "> 
                              <STRONG style="font-size:10px;"> Fecha de Impresion de Recibo:  </STRONG></td>
                              <td colspan="3" style="text-align: left; border:solid white "><span style="color:#5c5c5c;">
                                  <?php 
                                  header('Content-Type: text/html; charset=utf-8');
                                  
                                  setlocale(LC_TIME, "spanish");
                                  echo utf8_encode(strftime("%A, %d de %B de %Y"));?>
                                  </span>
                              </td>
                          </tr>
                        </table>
  <table width="100%" border="1">
    <tr>
      <td style="opacity:0.5;border:#ff5050;background-color:#ff5050; text-align: right; padding:7px;">
      <?php echo '<strong>Recibo: </strong> REC-00000'.$idRecibo ; ?></td>
    </tr>
  </table>

  <div class="container" style="padding: 5px;  ">
    <!-- Información del recibo -->
    <table border="1" width="100%"  style="border-collapse: collapse;">
            <tr style="background-color: coral;">
                <th style="background-color:GRAY; text-align:left;font-size:25px;" > <span style="color:white">RECIBO DE PAGO </span></th>
            </tr>
        
    </table>

    <table border="1" width="100%"  style="border-collapse: collapse; font-size:13px">
        <tr>
            <td width="30%"><strong>Recibi del (Sr): </strong>  </td>
            <td><?php echo $nombre; ?></td>
        </tr>
        <tr>
            <td width="30%"><strong>Por Concepto de: </strong>  </td>
            <td><?php echo $concepto; ?></td>
        </tr>
        <tr>
            <td width="30%"><strong>Monto: </strong>  </td>
            <td><?php echo $monto.' Bs'; ?></td>
        </tr>
        <tr>
            <td width="30%"><strong>Cantidad en letras: </strong>  </td>
            <td>

                <?php
                    require_once "CifrasEnLetras.php";
                    $v=new CifrasEnLetras(); 
                    //Convertimos el total en letras
                    $letra=($v->convertirEurosEnLetras($monto));

                    echo 'Son '.$letra;
                ?>

            </td>
        </tr>
        <tr>
            <td><strong>Fecha de Pago: </strong>  </td>
            <td><?php 
            setlocale(LC_TIME, 'es_ES');
            $timestamp = strtotime($fecha);
            $fecha_formateada = strftime("%d de %B de %Y", $timestamp);
            echo $fecha_formateada; ?></td>
        </tr>
    </table>
    <br><br>

    <table style="padding:30px" width="100%">
            <tr>
              <td style="border-top: 2px solid black ; text-align:center">Recibi Conforme</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td style="border-top: 2px solid black ; text-align:center">Entregue Conforme</td>
            </tr>
            <tr>
            <td >NOMBRE Y CI : </td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td style=" text-align:center"></td>
            </tr>
  </table>
  </div>

  

 
 
  

  
</body>
</html>
                <?php 
                    $html = ob_get_clean();
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($html);
                    $dompdf->setPaper('A4','portrait');
                    //$dompdf->setPaper('letter','portrait');
                    //$dompdf->setPaper('A4', 'landscape');
                    $canvas = $dompdf->getCanvas(); 
 

                    $dompdf->render();

                    $dompdf->stream('recibo-'.$idRecibo,array('attachment'=>0)); 
                                    
                ?>

