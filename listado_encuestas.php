<?php
include ('./funcion_validarUsu.php');
date_default_timezone_set('America/Bogota');
$hora_ingreso = date("H:i:s");
//uso de la funcion verificar_usuario()
if (verificar_usuario()) {
    //si el usuario es verificado puede acceder al contenido permitido a el
    //echo "$_SESSION[usuario]<br/>";
    $nombre_usuario = $_SESSION['usuario'];
} else {
    //si el usuario no es verificado volvera al formulario de ingreso
    header('Location:login.html');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listado Encuestas</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>      
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />       
        <link href="plugins/maxcdn.css" rel="stylesheet" type="text/css" />     
        <link href="plugins/ionicFramework.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />     
        <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />     
        <link href="js/notificaciones.css" rel="stylesheet" type="text/css">        
    </head>

    <body class="skin-blue">     
        <div class="wrapper">
            <!-- INCLUYE CABECERA DONDE INDICA EL NOMBRE DE USUARIO LOGUEADO-->
            <?php include './header.php'; ?>
            <!-- ZONA DEL MENÙ-->
            <?php include 'menu.php'; ?>
            <!-- ZONA DEL MENÙ-->
            <div class="content-wrapper">             
                <section class="content-header">
                    <h1>
                        Listado Encuestas
                    </h1>         
                </section>             
                <section class="content">

                    <div class="box">                       
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Título Encuesta</th>     
                                        <th>Fecha Creación</th>
                                        <th>Creada Por</th>                                      
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include './modelo/funciones_mysql.php';
                                    $conexion = new Conexion("sondeo");
                                    $sql = "SELECT * FROM encuesta";
                                    $resultado = $conexion->findAll2($sql);

                                    foreach ($resultado as $valor) {
                                        ?>
                                        <tr>
                                            <td><?php echo $valor->titulo; ?></td>
                                            <td><?php echo $valor->fecha_creacion; ?></td>
                                            <td><?php echo $valor->creada_por; ?></td>
                                            <td>
                                                <a href="moreInfo.php?id=<?php echo $valor->id_encuesta; ?>&encuesta=<?php echo $valor->titulo; ?>"><i id="moreInfo" data-toggle="tooltip" title="Mas Informacion" class="fa fa-eye" aria-hidden="true"></i></a>&numsp;&numsp;
                                                <a href="editarEncuesta.php?id=<?php echo $valor->id_encuesta; ?>"><i class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Editar Encuesta"></i></a>&numsp;&numsp;                       
                                                <a data-toggle="tooltip" title="Eliminar Encuesta"><i class="fa fa-eraser" aria-hidden="true" style="cursor: pointer" data-toggle="modal" data-target="#myModal" onclick="setId(<?php echo $valor->id_encuesta; ?>)"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>                        
                        </div>
                        
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Encuesta</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Desea eliminar la encuesta?
                                        <input type="hidden" id="id_encuestav">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <button type="button" class="btn btn-primary" onclick="eliminarEncuesta()">Si</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>      
        <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
        <script src='plugins/fastclick/fastclick.min.js'></script>
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <script src="js/notificaciones.js"></script>
        <script src="dist/js/funciones.js" type="text/javascript"></script>

        <script>
                                $(document).ready(function () {


                                    $("#example1").dataTable();



                                    var mensaje = getParameterByName('mensaje');
                                    if (mensaje == 'registro') {
                                        showAlert("Encuesta Guardada con èxito", "success", 250, 60);
                                    }


                                    if (mensaje == 'errorEncuesta') {
                                        showAlert("Error al guardar la encuesta", "error", 250, 60);
                                    }

                                    if (mensaje == 'bienvenido') {
                                        showAlert("Bienvenido: <?php echo $nombre_usuario; ?>", "success", 250, 60);
                                    }
                                    
                                    if (mensaje == 'eliminarEncuesta') {
                                        showAlert("Encuesta Eliminada", "success", 250, 60);
                                    }

                                    if (mensaje == 'errorEliminarEncuesta') {
                                        showAlert("Error al eliminar la encuesta", "error", 250, 60);
                                    }
                            
                                    
                                    

                                });
                                function getParameterByName(name) {
                                    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                                    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                                            results = regex.exec(location.search);
                                    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
                                }


                                function showAlert(mensaje, cssClas, width, height) { //info,error,success
                                    if ($("#notificaciones").length == 0) {
                                        //creamos el div con id notificaciones
                                        var contenedor_notificaciones = $(window.document.createElement('div')).attr("id", "notificaciones");
                                        //a continuación la añadimos al body
                                        $('body').append(contenedor_notificaciones);
                                    }
                                    //llamamos al plugin y le pasamos las opciones
                                    $.notificaciones({
                                        mensaje: mensaje,
                                        width: width,
                                        cssClass: cssClas, //clase de la notificación
                                        timeout: 4000, //milisegundos
                                        fadeout: 1000, //tiempo en desaparecer
                                        radius: 5, //border-radius
                                        height: height

                                    });
                                }


        </script>
    </body>
</html>