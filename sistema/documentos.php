<?php
    session_start();
    include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <?php include "includes/scripts.php";?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="shortcut icon" href="../img/ICONO.png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <title>PONCELET</title>    
    </head>

    <body class="sb-nav-fixed">
    <?php include "includes/header.php";?>
        <!-- contenido del sistema-->


        
        <div id="layoutSidenav_content">
            <div class="container px-4 ">
            <h1 class="mt-4 col text-md-left d-none d-sm-block"><i class="fa-solid fa-folder-open"></i> Documentos y Recursos Empresa PONCELET</h1>
            <h1 class="mt-4 col text-center d-sm-none"><i class="fa-solid fa-folder-open"></i> Documentos PONCELET</h1>

   
                <hr>
                <!-- contenido del sistema --> 
                <div class="container text-center">
                    <div class="row">

                        <div class="col-sm-6">
                            <h3 style="color: #ff5301;text-align:left ;">Cargar Documentos</h3> 
                            <div style="width:100%">
                                <form style="text-align: center;" method="POST" action="documentos_CargarFicheros.php" enctype="multipart/form-data">
                                <div style="text-align:center; width:100% ;background-color: #ff7b56;border: none;" class="form-group btn btn-danger w-100">
                                <label style="color: white;" class="btn w-100" for="my-file-selector">Carga tu Archivo aqui<br><br>
                                <input required="" type="file" name="file" id="exampleInputFile"> 
                                </label>
                                </div> <br><br>
                                <button  class="btn btn-primary w-100 " type="submit">Subir archivo al sistema --></button>
                                </form>
                                </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="table-responsive">
                                <table style="font-size: 11px;" class="table table-sm text-sm-center " >
                                <thead class="table-light">
                                <tr>
                                <th>#</th>
                                <th>Nombre del Archivo</th>
                               
                                <th>Fecha de subida </th>
                                <th>Descargar</th>
                                            
                                <th>Eliminar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $archivos = scandir("subidas");
                                $num=0;
                                for ($i=2; $i<count($archivos); $i++)
                                {$num++;


                        
                                ?>
                                <th scope="row"><?php echo $num;?></th>
                                <td><?php echo $archivos[$i]; ?></td>
                                <td style="color:#ff5301">
                                    <?php 
                                    
                                    //'subidas/'.$archivos[$i]
                                   
                                    //echo "Last change: ".date("F d Y H:i:s.",filectime('subidas/'.$archivos[$i]));
                                    $nombre_archivo = ('subidas/'.$archivos[$i]);
                                    if (file_exists($nombre_archivo)) {
                                        echo  date("d-M-Y ", filectime($nombre_archivo));
                                    }
                                    

                                
                                     ?>

                                </td>
                                <td><a title="Descargar Archivo" href="subidas/<?php echo $archivos[$i]; ?>" download="<?php echo $archivos[$i]; ?>" class="btn btn-primary" style="font-size:14px;"> <i class="fa-sharp fa-solid fa-download"></i>  </a></td>
                                <td><a title="Eliminar Archivo" href="documentos_Eliminar.php?name=subidas/<?php echo $archivos[$i]; ?>" class="btn btn-danger" style="font-size:14px;" onclick="return confirm('Esta seguro de eliminar el archivo?');">  <i class="fa-solid fa-trash"></i> </a></td>
                                </tr>
                                <?php }?> 

                                </tbody>
                                </table>
                                </div> 
                            </div>
                            
                        </div>
                        </div>

                        
                    </div>
                

                
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; @irsoft - 2023</div>
                            <div>
                                
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
    </body>
</html>

