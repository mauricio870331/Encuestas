<?php
include './modelo/funciones_mysql.php';
include ('./funcion_validarUsu.php');
date_default_timezone_set('America/Bogota');
$hora_ingreso = date("H:i:s");
//uso de la funcion verificar_usuario()
if (verificar_usuario()) {
    //si el usuario es verificado puede acceder al contenido permitido a el
    //echo "$_SESSION[usuario]<br/>";
    $nombre_usuario = $_SESSION['usuario'];

    //print "Desconectarse <a href='salir.php'/>aqui</a>";
} else {
    //si el usuario no es verificado volvera al formulario de ingreso
    header('Location:login.html');
}

$conexion = new Conexion("sondeo");
$resultado = $conexion->findAll2("SELECT * FROM encuesta WHERE id_encuesta =" . $_GET['id']);
$resultado_pre = $conexion->findAll2("SELECT * FROM pregunta WHERE id_encuesta =" . $_GET['id']);
$query = "SELECT p.id_pregunta, p.descripcion pregunta ,r.id_respuesta, r.descripcion respuesta FROM pregunta p inner join pregunta_respuesta pr on p.id_pregunta = pr.id_pregunta "
        . "inner join respuesta r on pr.id_respuesta = r.id_respuesta"
        . " WHERE p.id_encuesta = " . $_GET['id'] . " and r.id_encuesta = p.id_encuesta";

$consultaG = $conexion->findAll2($query);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Editar Encuesta</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link href="js/notificaciones.css" rel="stylesheet" type="text/css">
        <link href="js/editar.css" rel="stylesheet" type="text/css">
    </head>
    <body class="skin-blue">     
        <div class="wrapper">

            <?php include './header.php'; ?>

            <!-- ZONA DEL MENÙ-->
            <?php include 'menu.php'; ?>
            <!-- ZONA DEL MENÙ-->

            <div class="content-wrapper">             
                <section class="content-header">
                    <h1>
                        Editar Encuesta
                    </h1>         
                </section>             
                <section class="content">
                    <form>                  
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Título Encuesta</h3>          
                            </div>
                            <div class="box-body">                              
                                <input type="text" name="titulo" id="titulo2" size="55px" value="<?php echo $resultado[0]->titulo; ?>">
                                <a><i class="fa fa-floppy-o" aria-hidden="true" id="tituloEdit" style="font-size:18px;cursor: pointer " data-toggle="tooltip" title="Editar título" onclick="editarTitulo(<?php echo $_GET['id']; ?>)"></i></a>  
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Pregunta</h3> 
                            </div>
                            <div class="box-body">                
                                <input type="text" name="pregunta" id="pregunta2" size="55px" value="">
                                <a><i class="fa fa-plus" aria-hidden="true"value="+" id="preguntaEdit" style="font-size:18px;cursor: pointer " data-toggle="tooltip" title="Agregar Pregunta" onclick="agregarPregunta(<?php echo $_GET['id'] ?>)"></i></a>  


                                <!-- TABLA-->
                                <table class="table table-bordered" id="tbl_preguntas2" style="margin-top: 15px">
                                    <tr>                      
                                        <th>Pregunta</th>                                        
                                        <th style="width: 40px">Acción</th>
                                    </tr>
                                    <?php
                                    foreach ($resultado_pre as $valor) {
                                        ?>
                                        <tr>
                                            <td><?php echo $valor->descripcion; ?></td>
                                            <td><a><i class="fa fa-eraser" aria-hidden="true" data-toggle="tooltip" title="Eliminar Pregunta" style="cursor: pointer" onclick="validarPregunta(<?php echo $_GET['id'] ?>,<?php echo $valor->id_pregunta ?>)"></i></a></td>
                                        </tr>                                    
                                        <?php
                                    }
                                    ?>

                                </table>
                                <!--FIN  TABLA-->

                            </div>
                        </div>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Respuesta</h3>          
                            </div>
                            <div class="box-body"> 
                                <select id="selec_preguntas2" style="width: 18%; height: 22px">
                                    <option value="" >seleccione Pregunta</option>
                                    <?php
                                    foreach ($resultado_pre as $valor2) {
                                        ?>                                    
                                        <option value="<?php echo $valor2->descripcion; ?>">
                                            <?php echo $valor2->descripcion; ?></option>

                                        <?php
                                    }
                                    ?>

                                </select>
                                <input  type="text" name="respuesta" size="45px" id="respuesta2"> 
                                <a><i class="fa fa-plus" aria-hidden="true"value="+" id="new_respuesta2" style="font-size:18px;cursor: pointer " data-toggle="tooltip"title="Agregar Respuesta" onclick="agregar(<?php echo $_GET['id'] ?>)"></i></a>   

                                <!-- TABLA-->
                                <table class="table table-bordered editableTable" id="tbl_respuestas2" style="margin-top: 15px">
                                    <tr>    
                                        <th>Pregunta</th>    
                                        <th>Respuesta</th>                                                                                  
                                        <th style="width: 40px">Acción</th>                                    

                                    </tr>                                  
                                    <?php
                                    foreach ($consultaG as $valor3) {
                                        ?>  
                                        <tr>                                 
                                            <td id="pregunta<?php echo $valor3->id_pregunta ?>"><?php echo $valor3->pregunta; ?></td>                               
                                            <td id="respuesta<?php echo $valor3->id_pregunta ?>" data-idencuesta = "<?php echo $_GET['id']; ?>"data-idrespuesta="<?php echo $valor3->id_respuesta ?>" data-idpregunta="<?php echo $valor3->id_pregunta ?>"><?php echo $valor3->respuesta; ?></td>
                                            <td><a><i class="fa fa-eraser" aria-hidden="true" data-toggle="tooltip" title="Eliminar Respuesta" style="cursor: pointer" onclick="eliminar(<?php echo $valor3->id_respuesta ?>,<?php echo $_GET['id'] ?>, 1)"></i></a></td>
                                        </tr>                   
                                        <?php
                                    }
                                    ?>                         
                                </table>
                                <!--FIN  TABLA-->                        
                                <a href="listado_encuestas.php">
                                    <input  type="button" name="regresar" id="regresar" value="Regresar" class="btn btn-block btn-primary" style="width: 8%"> 
                                </a>

                                <input type="hidden" id="launchModal" class="btn btn-primary" data-toggle="modal" data-target="#myModal" />
                            </div>
                        </div>
                    </form>
                </section>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Esa pregunta tiene respuestas asociadas ¿Desea eliminarla?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-primary" onclick="eliminarPregunta()">Si</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- jQuery 2.1.3 -->
        <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src='plugins/fastclick/fastclick.min.js'></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <script src="js/notificaciones.js"></script>
        <script src="dist/js/funciones.js" type="text/javascript"></script>        


        <script>
                                                $(document).ready(function () {

                                                    var mensaje = getParameterByName('mensaje');

                                                    if (mensaje == 'errorEncuesta') {
                                                        showAlert("Error al guardar la encuesta", "error", 250, 60);

                                                    }

                                                    if (mensaje == 'editar') {
                                                        showAlert("Respuesta Editada con éxito", "success", 250, 60);

                                                    }

                                                    if (mensaje == 'errorEditar') {
                                                        showAlert("Error al editar la respuesta", "error", 250, 60);

                                                    }

                                                    if (mensaje == 'eliminarRespuesta') {
                                                        showAlert("Respuesta Eliminada", "success", 250, 60);

                                                    }

                                                    if (mensaje == 'agregarRespuesta') {
                                                        showAlert("Respuesta Añadida", "success", 250, 60);
                                                    }

                                                    if (mensaje == 'errorAgregar') {
                                                        showAlert("Error al agregar la respuesta", "error", 250, 60);
                                                    }

                                                    if (mensaje == 'agregarPregunta') {
                                                        showAlert("Pregunta Añadida", "success", 250, 60);
                                                    }

                                                    if (mensaje == 'errorPregunta') {
                                                        showAlert("Error al agregar la pregunta", "error", 250, 60);
                                                    }

                                                    if (mensaje == 'eliminarPregunta') {
                                                        showAlert("Pregunta Eliminada", "success", 250, 60);
                                                    }

                                                    if (mensaje == 'errorEliminarPregunta') {
                                                        showAlert("Error al eliminar la pregunta", "error", 250, 60);
                                                    }
                                                    
                                                    
                                                     if (mensaje == 'edtarTitulo') {
                                                        showAlert("Titulo Editado", "success", 250, 60);
                                                    }

                                                    if (mensaje == 'errorEditarTitulo') {
                                                        showAlert("Error al editar el titulo", "error", 250, 60);
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