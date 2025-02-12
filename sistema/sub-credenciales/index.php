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

        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
        
        

        

        <link rel="shortcut icon" href="../img/ICONO.png">
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PONCELET</title>

        <style>
            table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
            table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
                margin-right: .5em;
                display: inline-block;
                color: rgb(247 67 67);
                
                font-family: "cursiva"; /* Asegúrate de que la fuente Font Awesome esté cargada */
            }
        </style>



        
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
            <div class="col-sm-4">
                <h2><i class="bi bi-file-lock"></i> Credenciales PONCELET </h2>
                
            </div>

            <div class="col-sm-6 ">
                
                
            </div>

            

            

            
            

            <div class="col-sm-2 ">
                
                <div class="text-center">
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary  w-100" data-bs-toggle="modal" data-bs-target="#modalproductos" id="botonCrear">
                        <i class="bi bi-key"></i> Nueva Clave
                        </button>
                        
                </div>
            </div>
            
            
        </div>
        
        <hr style="background-color: red;">

        <div class="table-responsive" style="font-size: 11px; width:100%">
            <table id="datos_usuario" class="responsive display nowrap table table-hover " style="width:100%;font-size:13px;" >
                <thead>
                    <tr>
                        <th width = "10px">ID</th>
                        <th width = "15px">NOMBRE</th>
                        
                        <th>USUARIO</th>
                        <th>CONSTRASEÑA</th>
                        <th>IMG</th>
                        
                        <th width = "10px"></th>
                        <th width = "10px"></th>
                        <th width = "10px"></th>
                    </tr>
                </thead>
                <tbody>
                               
                            </tbody>
            </table>
        </div>
    </div>

<!-- FINAL tabla--> 

<!-- Modal NUEVO -->
<div class="modal fade" id="modalproductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-box"></i> Registro de Claves</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: azure;"></button>
            </div>
            
                <form action="" method="POST" id="formulario" enctype="multipart/form-data">
                    
                    <div class="modal-content">

                    <div class="modal-body">

                    

                 
                    <div class="row">

                        <div class="col-sm-12">
                            <label for="nombre" style="font-family: sans-serif;">Ingrese el Nombre del Lugar de el Credencial <span style="color:red"> *</span></label>
                            <input type="text" name="nombre" id="nombre" class="form-control form-control-sm">
                        </div>

                        <div class="col-sm-6">
                            <label for="pagina" style="font-family: sans-serif;">Ingrese la paginaweb <span style="color:red"> *</span></label>
                            <input type="text" name="pagina" id="pagina" class="form-control form-control-sm">
                        </div>


                        <div class="col-sm-6">
                            <label for="usuario" style="font-family: sans-serif;">Ingrese el Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control form-control-sm">
                        </div>
                        <div class="col-sm-6">
                            <label for="password" style="font-family: sans-serif;">Ingrese la contraseña </label>
                            <input type="text" name="password" id="password" class="form-control form-control-sm">
                        </div>  
                       


                        <div class="col-sm-6">
                            <label for="foto" style="font-family: sans-serif;">Ingrese Foto del Lugar</label>
                            <input type="file" class="form-control form-control-sm" name="foto" id="foto">
                        </div>
                        <div class="col-sm-6">
                            <span id="imagen-subida"></span>
                        </div>
                       
                        
                        
                        

                        



                        

                        

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_credencial" id="id_credencial">
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




 








<!-- modal editar categoria -->





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

        <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js" type="text/javascript"></script>
        
        





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
                $(".modal-title").text("Crear Clave");
                $("#action").val("Crear clave");
                $("#operacion").val("Crear");
                $('#imagen-subida').html("");
                /* $('#pdf-subido').html("");
                $('#certificado-subido').html(""); */
                $("#foto").html("");
                /* $("#ficha").html("");
                $("#certificado").html(""); */
                // Llamada a la función al cargar la página para inicializar las opciones del select
               

                
            });
            
            var dataTableactivo = $('#datos_usuario').DataTable({
                "responsive": true,
                "dom": 'Bfrtip',
                "buttons": [
                    {
                        extend: 'colvis',
                        className: 'btn-default',
                        text: '<i class="fas fa-plus-circle"></i> Mostrar columnas', // Utilizamos FontAwesome para el icono
                        columnText: function ( dt, idx, title ) {
                            return (idx+1)+': '+title;
                        }
                    }
                ],
                "pageLength": 7,
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url: "obtener_registros.php",
                    type: "POST"
                },
                "columnsdef":[
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
            var nombre = $('#nombre').val();
            var pagina = $('#pagina').val();
            var usuario = $('#usuario').val();
            var password = $('#password').val();
            var extension = $('#foto').val().split('.').pop().toLowerCase();
            /* var extension2 = $('#ficha').val().split('.').pop().toLowerCase();
            var extension3 = $('#certificado').val().split('.').pop().toLowerCase(); */
            if(extension != '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                {
                    alert("Fomato de imagen inválido");
                    $('#foto').val('');
                    return false;
                }
            }

           
            	
		    if(nombre != '' && pagina != '' && usuario != '' && password != '')
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
                            dataTableactivo.ajax.reload();
                           
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
            var id_credencial = $(this).attr("id");		
            $.ajax({
                url:"obtener_registro.php",
                method:"POST",
                data:{id_credencial:id_credencial},
                dataType:"json",
                success:function(data)
                    {
                        
                        //console.log(data);				
                        $('#modalproductos').modal('show');
                        $('#nombre').val(data.nombre);
                        $('#pagina').val(data.pagina); 
                        $('#usuario').val(data.usuario);
                        $('#password').val(data.password);
     
        
                        $('.modal-title').text("Editar Clave");
                        $('#id_credencial').val(id_credencial);
                        $('#imagen-subida').html(data.foto);
                        
                      
                        $('#action').val("Editar");
                        $('#operacion').val("Editar");

                        $('#modalproductos').on('hidden.bs.modal', function () {
                            dataTableactivo.ajax.reload();
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    }
                })
	        });

            //Funcionalidad de borrar
            $(document).on('click', '.borrar', function(){
                var id_credencial = $(this).attr("id");

                Swal.fire({
                title: 'Esta Seguro de Borrar ?',
                text: "El Registro con el ID = " + id_credencial,
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
                        data:{id_credencial:id_credencial},
                        success:function(data)
                        {
                            dataTableactivo.ajax.reload();
                        }
                    });

                    Swal.fire(
                    'Borrado con Exito!',
                    'Se Elimino de la Base de datos el Activo Fijo ',
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