<?php
    
    session_start();
    include "../../conexion.php";



?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        
        <link rel="stylesheet" href="css/estilos3.css">
        <link rel="stylesheet" href="css/estilos2.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">

        <link rel="shortcut icon" href="../img/ICONO.png">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>NAXSAN</title>
        
    </head>
    <body class="sb-nav-fixed">
    <?php include "../menu.php"?>
    

        <!-- contenido del sistema-->

        <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid ">
                    <div class="container-fluid  ">
                    
                     
                        <br>
                        
<!-- contenido del sistema 2--> 

<!-- Contenedor tabla--> 

<div class="container-fluid  fondo ">    
        <div class="row">
            <div class="col-sm-6">
                <h2><i class="bi bi-arrow-down-left-circle-fill"></i> Salidas de Trabajo  </h2>
                
            </div>

            <?php

                $result=mysqli_query($conexion,"SELECT count(*) as total from salidas");
                $data=mysqli_fetch_assoc($result);
                $data['total'];

            ?>

            <div class="col-sm-2">
                
            
                
            </div>
            <div class="col-sm-2">
                <a class="btn btn-danger w-100 disabled " href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" > <strong><i class="bi bi-file-pdf-fill"></i>   </strong> Imprimir </a>
            
                
            </div>




<!-- Modal Imprimir -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-file-pdf-fill"></i>  Imprimir Informes</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">


      
      <form action="reporte.php"  class="form-inline" method="POST" name="formFechas" id="formFechas">
      <div class="row">
            <div class="col-sm-4">
            <label for="">Elegir Personal</label>
                <select style="width: 100%;font-size:12px ; border-radius: 25px;border: 2px solid gray;" name="personal" id="select" class=" form-select" required >
                    <option value="jazmin">Jazmin Velasco Diaz </option>
                    <option value="mavel">Mavel Condori Flores</option>
                    <option value="ale">Alejandro Iglesias Raldes </option>
                    <option value="nicol">Mariana Nicol Erquicia Camacho </option>
                    <option value="edwin">Edwin Mario Pinto Ramirez </option>
                                                

                </select>
                                            
            </div>
            <div class="col-sm-4">
                <label for="">Fecha Inicio</label>
                <input style="border-radius: 25px;border: 2px solid gray;" class="form-control form-control-sm" type="date" name="fecha_inicio" id="" required > 
            </div>
            <div class="col-sm-4">
                <label for="">Fecha Final</label>
                <input style="border-radius: 25px;border: 2px solid gray;" class="form-control form-control-sm" type="date" name="fecha_final" id="" required >

            </div>
            

            <p></p>

            <div class="col-sm-4">
            <input class="btn btn-danger btn-sm w-100" type="submit" value="INFORME GENERAL" >
            </div>

                                        
            
            </div>
        </form>





        <form action="reporte2.php"  class="form-inline" method="POST" name="formFechas" id="formFechas">
      <div class="row">
            <div class="col-sm-4">
            <label for="">Elegir Personal</label>
                <select style="width: 100%;font-size:12px ; border-radius: 25px;border: 2px solid gray;" name="personal" id="select" class=" form-select" required >
                    <option value="jazmin">Jazmin Velasco Diaz </option>
                    <option value="mavel">Mavel Condori Flores</option>
                    <option value="ale">Alejandro Iglesias Raldes </option>
                    <option value="nicol">Mariana Nicol Erquicia Camacho </option>
                    <option value="edwin">Edwin Mario Pinto Ramirez </option>
                                                

                </select>
                                            
            </div>
            <div class="col-sm-4">
                <label for="">Fecha Inicio</label>
                <input style="border-radius: 25px;border: 2px solid gray;" class="form-control form-control-sm" type="date" name="fecha_inicio" id="" required > 
            </div>
            <div class="col-sm-4">
                <label for="">Fecha Final</label>
                <input style="border-radius: 25px;border: 2px solid gray;" class="form-control form-control-sm" type="date" name="fecha_final" id="" required >

            </div>
            

            <p></p>

                                        
            <div class="col-sm-4 ">
                <input class="btn btn-danger btn-sm w-100 " type="submit" value="INFORME DE COTIZACIONES" >
            </div>
            </div>
        </form>

        <form action="reporte3.php"  class="form-inline" method="POST" name="formFechas" id="formFechas">
      <div class="row">
            <div class="col-sm-4">
            <label for="">Elegir Personal</label>
                <select style="width: 100%;font-size:12px ; border-radius: 25px;border: 2px solid gray;" name="personal" id="select" class=" form-select" required >
                    <option value="jazmin">Jazmin Velasco Diaz </option>
                    <option value="mavel">Mavel Condori Flores</option>
                    <option value="ale">Alejandro Iglesias Raldes </option>
                    <option value="nicol">Mariana Nicol Erquicia Camacho </option>
                    <option value="edwin">Edwin Mario Pinto Ramirez </option>
                                                

                </select>
                                            
            </div>
            <div class="col-sm-4">
                <label for="">Fecha Inicio</label>
                <input style="border-radius: 25px;border: 2px solid gray;" class="form-control form-control-sm" type="date" name="fecha_inicio" id="" required > 
            </div>
            <div class="col-sm-4">
                <label for="">Fecha Final</label>
                <input style="border-radius: 25px;border: 2px solid gray;" class="form-control form-control-sm" type="date" name="fecha_final" id="" required >

            </div>
            

            <p></p>

                                        
            <div class="col-sm-4 ">
                <input class="btn btn-danger btn-sm w-100 " type="submit" value="INFORME DE PROYECTOS" >
            </div>
            </div>
        </form>


 

        

        
                                        
                                        
                                        

                                        
                                            
                                        

                                        
                                    
                                        
                                        
                                       

                                    

           
                                
                                 
                                
        

        

       


        
      </div>
      
    </div>
  </div>
</div>
















<!-- 
            <div class="col-sm-2">
                <a class="btn btn-danger w-100" style="background-color: cadetblue;border:none;" href="http://localhost/poncelet-sis/sistema/cotizador/"><i class="bi bi-file-earmark-ruled"></i> Cotizador Poncelet </a>
                
            </div> -->

            

            <div class="col-sm-2 ">
                
                <div class="text-center">
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-secondary boton w-100" data-bs-toggle="modal" data-bs-target="#modalsalidas" id="botonCrear">
                        <i class="bi bi-arrow-down-left-circle-fill"></i> Registrar Salida
                        </button>
                        
                </div>
            </div>
            
            
        </div>

        <!-- <button style="background-color: blue;border: blue 1px solid;" type="" class="btn btn-primary"> </button> Edwin Pinto
        <button type="" class="btn btn-secondary"> </button> Nicol Erquicia
        <button type="" class="btn btn-success"></button> Alejandro Iglesias
        <button type="" class="btn btn-danger"></button> Mavel Condori
        <button type="" class="btn btn-warning"></button> Jazmin Velasquez -->
        
        <hr style="background-color: red;">

        <div class="table-responsive" style="font-size: 11px; width:100%">
            <table id="datos_usuario" class="table table-hover table-striped table-bordered" style="width:100%; text-align:center;" >
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">PERSONAL</th>
                        <th>FECHA</th>
                        <th>HORA DE SALIDA </th>
                        <th>LUGAR</th>
                        <th>MOTIVO</th>
                        <?php
                        if($_SESSION['rol'] == 1){

                            ?>
                        
                        <th></th>
                        <th></th>

                        <?php 
                    
                    } ?>
                        
                    </tr>
                </thead>
            </table>
        </div>
    </div>

<!-- FINAL tabla--> 

<!-- Modal NUEVO -->
<div class="modal fade" id="modalsalidas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-box"></i> Registro de proyectos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: azure;"></button>
            </div>
            
                <form action="" method="POST" id="formulario" enctype="multipart/form-data">
                    
                    <div class="modal-content">

                    <div class="modal-body">

                    

                 
                    <div class="row">
                    <div class="col-sm-12">

                            <label for="">Elegir Personal</label>
                                <!-- <select style="width: 100%;font-size:12px ; border-radius: 25px;border: 2px solid gray;" name="personal" id="personal" class=" form-select" required >
                                <option value="">Escoje una Opción </option>
                                <option value="Jazmin Velasco Diaz">Jazmin Velasco Diaz </option>
                                <option value="Mavel Condori Flores">Mavel Condori Flores</option>
                                <option value="Alejandro Iglesias Raldes">Alejandro Iglesias Raldes </option>
                                <option value="Mariana Nicol Erquicia Camacho">Mariana Nicol Erquicia Camacho </option>
                                <option value="Edwin Mario Pinto Ramirez">Edwin Mario Pinto Ramirez </option>
                                                            

                            </select> -->
                            <select style="width: 100%; font-size: 12px; border-radius: 25px; border: 2px solid gray;" name="personal" id="personal" class="form-select" required>
                            <option value="">Escoje una Opción</option>

                            <?php

                                // Consultar los nombres desde la tabla 'usuario'
                                $sql = "SELECT nombre FROM usuario where estatus = '1'";
                                $result = $conexion->query($sql);
                            // Generar opciones dinámicamente desde la base de datos
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["nombre"] . '">' . $row["nombre"] . '</option>';
                                }
                            } else {
                                echo "0 resultados encontrados";
                            }

                            
                            ?>

                        </select>

                        </div>

                        <div class="col-sm-12">
                            <span for="inputFirstName">Lugar </span>
                            <input class="form-control form-control-sm  bg-opacity-10" name="lugar" id="lugar" type="text" value="" required />
                        </div>
                        
                        <div class="col-sm-12">
                            <span for="inputFirstName">Motivo </span>
                            <input class="form-control form-control-sm  bg-opacity-10" name="motivo" id="motivo" type="text" value="" required />
                        </div> 

                        

                        <br>

                        

                        

                       

                        

                        
                        
                        

                        



                        

                        

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_salida" id="id_salida">
                        <input type="hidden" name="operacion" id="operacion">

                        <input type="reset" value="Limpiar" class="btn btn-secondary"> 
                        <input type="submit" name="action" id="action" class="btn btn-success" value="Registrar">
                        
                    </div>
                    </div>
                    </div>
                </form>
            </div>


            
        </div>



        </div>



</div>

<!-- FINAL MODAL -->
<!-- Modal para  ver imagenes -->

                <div class="modal fade" id="gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered ">
                        <div class="modal-content modal-fullscreen ">
                            <div class="modal-header">
                                <!--<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>-->
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="img/actas/acta_103_1_2021-02-22.jpg" class="modal-img" alt="modal img" width="100%" height="100%">
                            </div>

                        </div>
                    </div>
                </div>
<!-- FINAL Modal para  ver imagenes -->
                

<!-- FINAL CONTENIDO--> 
                
            </div>
        </div>

    </main>

</div>

        

    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous" ></script>
        
        <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>


        <script>

       

            window.addEventListener('DOMContentLoaded', event => {
            // Toggle the side navigation
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                // Uncomment Below to persist sidebar toggle between refreshes
                // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
                //     document.body.classList.toggle('sb-sidenav-toggled');
                // }
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
                });
            }

            });
        </script>

<script type="text/javascript">
        $(document).ready(function(){

                
                $("#botonCrear").click(function(){
                $("#formulario")[0].reset();
                $(".modal-title").text("Registrar Salida");
                $("#action").val("Registrar Salida");
                $("#operacion").val("Crear");
            });
            
            var dataTable = $('#datos_usuario').DataTable({
                "pageLength": 25,
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url: "obtener_registros.php",
                    type: "POST"
                },
                //CONDICIONAL DE COLORES EN TABLA 
                /*"createdRow": function(row,data,index){
                        if (data[7] == 'proceso') {
                            $('td', row).eq(7).css({
                                'background-color':'#f3f39b',
                                'color':'black',
                                'text-align':'center',
                            });
                        }else{
                            $('td', row).eq(7).css({
                                'color':'black',
                                'background-color':'#84f585',
                                'text-align':'center',
                    

                            });
                        }
                    },*/
                "columnsDefs":[
                    {
                    "targets":[0, 3, 4],
                    "orderable":false,
                    },
                ],
                "language": {
                "decimal": "",
                "emptyTable": "No hay registros",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
            });

    
            
            //Aquí código inserción
            $(document).on('submit', '#formulario', function(event){
            event.preventDefault();
            var personal = $('#personal').val();
            var fecha = $('#fecha').val();
            var lugar = $('#lugar').val();
            var hora = $('#hora').val();
            var motivo = $('#motivo').val();
        
            	
		    if(personal != '' && fecha != '' && hora != '' && lugar != '' && motivo != '' )
                {
                    $.ajax({
                        url:"crear.php",
                        method:'POST',
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        success:function(data)
                        {
                            Swal.fire(
                            'Exitoso!',
                            'Se registro correctamente',
                            'success'
                            ),
                            $('#formulario')[0].reset();
                            $('#modalsalidas').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
                }
                else
                {
                    Swal.fire(
                    'Algunos Campos son Obligatorios ?',
                    'Revisa el formulario',
                    'warning'
                    );
                }
	        });


            //Funcionalidad de editar
            $(document).on('click', '.editar', function(){		
            var id_salida = $(this).attr("id");		
            $.ajax({
                url:"obtener_registro.php",
                method:"POST",
                data:{id_salida:id_salida},
                dataType:"json",
                success:function(data)
                    {
                        
                        //console.log(data);				
                        $('#modalsalidas').modal('show');
                        $('#personal').val(data.personal);
                       
                        $('#lugar').val(data.lugar);
                        $('#motivo').val(data.motivo);
                        
                        
                        $('.modal-title').text("Editar Salida");
                        $('#id_salida').val(id_salida);
                    
                        $('#action').val("Editar");
                        $('#operacion').val("Editar");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    }
                })
	        });

            //Funcionalidad de borrar
            $(document).on('click', '.borrar', function(){
                var id_salida = $(this).attr("id");

                Swal.fire({
                title: 'Esta Seguro de Borrar ?',
                text: "El Registro con el ID = " + id_salida,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#72db88',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Borralo!'
                }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url:"borrar.php",
                        method:"POST",
                        data:{id_salida:id_salida},
                        success:function(data)
                        {
                            dataTable.ajax.reload();
                        }
                    });

                    Swal.fire(
                    'Borrado con Exito!',
                    'Se Elimino de la Base de datos el Producto ',
                    'success'
                    )
                }
                else{
                    return false;
                }
                });

            });

        });         
    </script>


<script>
    document.addEventListener("click",function(e){
        if(e.target.classList.contains("gallery-item")){
            const src = e.target.getAttribute("id");
            document.querySelector(".modal-img").src = src;

            const myModal = new bootstrap.Modal(document.getElementById('gallery-modal'));
            myModal.show();
        }
    });
</script>

<script type="text/javascript">
        

        function calcular_a_bs(){
            try{
                var b = parseFloat(document.getElementById("pc").value) || 0;
                decimal = b.toFixed(2);
                proceso = (decimal *(30/100))+b;
                result = proceso.toFixed(2);
                document.getElementById("pv").value = result;
            } catch(e){}
        }


    </script>

    <script>

        //MODO OSCURO 

        const bdark = document.querySelector('#bdark');
        const main = document.querySelector('main');
        const body = document.querySelector('body');

        bdark.addEventListener('click',e =>{
            main.classList.toggle('darkmode');
        });

        bdark.addEventListener('click',e =>{
            body.classList.toggle('darkmode');
        });

        

        const table = document.querySelector('table');
            bdark.addEventListener('click',e =>{
            table.classList.toggle('table-dark');
        });





    </script>
        

        
        
       


        </body>
</html>