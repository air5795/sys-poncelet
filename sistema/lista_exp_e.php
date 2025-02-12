<?php

session_start();
include "../conexion.php";


?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <?php include "includes/scripts.php"; ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="../img/ICONO.png">

    <title>PONCELET</title>

    <script src="js/jquery-3.6.1.js"></script>
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">
    <script src="js/jquery.dataTables.min.js"></script>


</head>

<body class="sb-nav-fixed">
    <?php include "includes/header.php"; ?>


    <!-- contenido del sistema-->

    <div id="layoutSidenav_content">
        <main>
        <div class="container-fluid px-4 ">
                    <div>
                    <h1 class="mt-4"><i class="fa-solid fa-cart-shopping"></i> Listar proyectos Especificos Comercialiadora</h1>
                        
                        <ol class="breadcrumb mb-2 ">
                            <li class="breadcrumb-item active">PONCELET/ Proyectos Comercializadora</li> 
                        </ol>

                <hr>
                    <?php
                            $sql_suma_bs = mysqli_query($conexion, "SELECT SUM(monto_bs) FROM exp_general;");
                            $result_sum = mysqli_fetch_array($sql_suma_bs);
                            $total = $result_sum['SUM(monto_bs)']; 

                            $sql_tfila = mysqli_query($conexion, "SELECT COUNT(id_exp) FROM exp_general;");
                            $result_f = mysqli_fetch_array($sql_tfila);
                            $total2 = $result_f['COUNT(id_exp)']; 

                    ?>
                <!-- llenado de tabla-->


                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Importante!</strong> Seleccionar los proyectos que quiere listar a la Experiencia Especifica.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> 
                </div>

                <!--  modal 
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gallery-modal">
                Launch demo modal
                </button>-->

                

                
                        


                

                <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Listado de Proyectos en Base de datos Poncelet
                            </div>
                            
                <div class="card-body">
                <form action="reporte_ee.php" method="POST">
                    
                    <button type="submit" class="btn btn-danger p-2 ">
                        <img src="img/PDF.svg" height="20px" width="20px" > Lista de Experiencia Especifica
                    </button>
                    
                    <a  href="rep_ImgEE.php" class="btn btn-outline-danger p-2 "> <img src="img/pdf.png" height="20px" width="20px"> Actas Experiencia Especifica </a>
                    
                    <hr>
                <table  style="font-size:11px ;" class=" table table-hover" id="datatable" class="display" >
                <thead class="table-secondary">
                    <tr class="">
                        <th>Check</th>
                        <th>Detalle</th>
                        <th>idº</th>
                        <th >Nombre del contratante / Persona y Direccion de contacto</th>
                        <th >Objeto del Contrato</th>
                        <th>Ubicacion</th>
                        <th >Monto final del contrato en (Bs)</th>
                        <th  >Periodo de ejecucion (Fecha de inicio y finalizacion)</th>
                        <th >Monto en $u$ (Llenado de uso alternativo)</th>
                        
                        <th>Profesional Responsable</th>

                        <th>imagen-1(Acta)</th>
                        
                        
                     
                    </tr>
                    </thead>
                    <?php
                    
                    
                    


                    // rescatar datos DB 
                    $query = mysqli_query($conexion, "SELECT * FROM exp_general 
                                                        ORDER BY id_exp ASC");

                   


                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_array($query)) {
                            if ($data['image'] != 'nodisponible.png' ) {
                                $image = 'sub-exp-comer/actas/'.$data['image'];
                                

                            }else {
                                $image = 'sub-exp-comer/'.$data['image'];
                            }
                            
                            $image2 = 'sub-exp-comer/actas/'.$data['image2'];
                            $image3= 'sub-exp-comer/actas/'.$data['image3'];

                        
                            

                            

                    ?>
                            <tr>
                                <form>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input  name="check[]" value="<?php echo $data['id_exp'] ?>" class="form-check-input " type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                        </div>
                                    </td>
                                <td><?php 

                                if (empty($data['detalle'])) {
                                    
                                    echo '<div class="alert alert-danger">'.'Sin Detalle';
                                }
                                else {
                                    echo '<div class="alert alert-info">'.$data['detalle'];
                                }

                               
                                    
                                


                                     ?>
                                    
                                </div></td>
                                <td><?php echo $data['id_exp'] ?></td>
                                <td><?php echo $data['nombre_contratante'] ?></td>
                                <td><?php echo $data['obj_contrato'] ?></td>
                                <td><?php echo $data['ubicacion'] ?></td>
                                <td class=" bg-success bg-opacity-10"><?php echo number_format($data['monto_bs'],2,'.',',').' Bs' ?></td>
                                <td><?php echo $data['fecha_ejecucion'] ?></td>
                                <td class=" bg-success bg-opacity-10"><?php echo number_format($data['monto_dolares'],2,'.',',').' $' ?></td>
                                
                                <td><?php echo $data['profesional_resp'] ?></td>

                                <td>
                                    <img style= "width:100px" src="<?php echo $image ?>" class="gallery-item"> 
                                </td>
                                

                                
                                
                            </tr>
                    <?php

                        }
                        
                    }
                    ?>
                
                    


                </table>

                </form>
                </div>
                </div>

                <!-- Modal para  ver imagenes -->
                <div class="modal fade" id="gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" >
                    <div class="modal-content modal-fullscreen ">
                    <div class="modal-header">
                        <!--<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>-->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" >
                        <img src="img/actas/acta_103_1_2021-02-22.jpg" class="modal-img" alt="modal img">
                    </div>
                    
                    </div>
                </div>
                </div>

                
                



        </main>
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
    </div>
    <!-- datatablesSimple -->
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    
    <!--<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>-->
    <script src="js/datatables-simple-demo.js"></script>

    <script>$(document).ready(function () {
    $('#datatable').DataTable({
        pageLength: 500,
        lengthMenu: [
            [5, 25, 50,150,500, -1],
            [5, 25, 50,150,500, 'All'],
        ],
        language:{
            url:'js/Spanish.json'
        }
    });
});</script>

<script>
    document.addEventListener("click",function(e){
        if(e.target.classList.contains("gallery-item")){
            const src = e.target.getAttribute("src");
            document.querySelector(".modal-img").src = src;

            const myModal = new bootstrap.Modal(document.getElementById('gallery-modal'));
            myModal.show();
        }
    });
</script>


    

</body>

</html>