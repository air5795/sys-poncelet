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
        <title>PONCELET</title>
        
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
                <h2><i class="fa-solid fa-database"></i> BD - Mercaderia</h2>
                
            </div>

            <?php

                $result=mysqli_query($conexion,"SELECT count(*) as total from inventario");
                $data=mysqli_fetch_assoc($result);
                $data['total'];

            ?>

            <div class="col-sm-2">
                <a class="btn btn-secondary w-100 disabled" href=""> <strong><i class="bi bi-box-seam"> - </i>  <?php echo $data['total']; ?> </strong>  Productos  </a>
            
                
            </div>

            <div class="col-sm-2">
                <a class="btn btn-danger w-100 " href="../reporte_inventario.php"> <strong><i class="bi bi-printer"></i> </strong>  IMPRMIR </a>
            </div>


            

            <div class="col-sm-2 ">
                
                <div class="text-center">
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-danger  w-100" data-bs-toggle="modal" data-bs-target="#modalproductos" id="botonCrear">
                        <i class="fa-solid fa-plus"></i> Nuevo Producto
                        </button>
                        
                </div>
            </div>
            
            
        </div>
        
        <hr style="background-color: red;">

        <div class="table-responsive" style="font-size: 11px; width:100%">
            <table id="datos_usuario" class="table table-hover table-striped" style="width:100%" >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th width="25%">ARTICULO</th>
                        <th>FECHA REGISTRADA</th>
                        <th>STOCK</th>
                       
                        
                        <th>FOTO</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

<!-- FINAL tabla--> 

<!-- Modal NUEVO -->
<div class="modal fade" id="modalproductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-box"></i> Registro de Productos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: azure;"></button>
            </div>
            
                <form action="" method="POST" id="formulario" enctype="multipart/form-data">
                    
                    <div class="modal-content">

                    <div class="modal-body">

                    

                 
                    <div class="row">

                        <div class="col-12">
                            <label for="nombre" style="font-family: sans-serif;">Ingrese el nombre del Articulo <span style="color:red"> *</span></label>
                            <input type="text" name="articulo" id="articulo" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label for="stock" style="font-family: sans-serif;">Ingrese el Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control form-control-sm">
                        </div> 
                        

                        <div class="col-6">
                            <label for="foto" style="font-family: sans-serif;">Ingrese Foto</label>
                            <input type="file" class="form-control form-control-sm" name="foto" id="foto">
                        </div>
                        <div class="col-6">
                            <span id="imagen-subida"></span>
                        </div>
                        
                        
                        

                        



                        

                        

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_inv" id="id_inv">
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
                $(".modal-title").text("Crear Producto");
                $("#action").val("Crear Producto");
                $("#operacion").val("Crear");
                $('#imagen-subida').html("");
                
                $("#foto").html("");
                

                
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
            var articulo = $('#articulo').val();
            var stock = $('#stock').val();
            
            var extension = $('#foto').val().split('.').pop().toLowerCase();
            
            if(extension != '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                {
                    alert("Fomato de imagen inválido");
                    $('#foto').val('');
                    return false;
                }
            }

           
            	
		    if(articulo != '' && stock != '')
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
                            $('#modalproductos').modal('hide');
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
            var id_inv = $(this).attr("id");		
            $.ajax({
                url:"obtener_registro.php",
                method:"POST",
                data:{id_inv:id_inv},
                dataType:"json",
                success:function(data)
                    {
                        
                        //console.log(data);				
                        $('#modalproductos').modal('show');
                        $('#articulo').val(data.articulo);
                        $('#stock').val(data.stock);
                       
                        $('.modal-title').text("Editar Producto");
                        $('#id_inv').val(id_inv);
                        $('#imagen-subida').html(data.foto);
                        
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
                var id_inv = $(this).attr("id");

                Swal.fire({
                title: 'Esta Seguro de Borrar ?',
                text: "El Registro con el ID = " + id_inv,
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
                        data:{id_inv:id_inv},
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