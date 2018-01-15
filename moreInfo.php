<?php
include 'modelo/funciones_mysql.php';
include ('./funcion_validarUsu.php');
date_default_timezone_set('America/Bogota');
$hora_ingreso = date("H:i:s");
//uso de la funcion verificar_usuario()
if (verificar_usuario()) {
    //si el usuario es verificado puede acceder al contenido permitido a el
    //echo "$_SESSION[usuario]<br/>";
    $nombre_usuario = $_SESSION['usuario'];
    $conexion = new Conexion("sondeo");

    //ARRAY CARGADO CON PREGUNTAS
    $resultado = $conexion->findAll2("SELECT * FROM pregunta WHERE id_encuesta =" . $_GET['id']);

    $array = array();
    $arrayPreguntas = array();
    $arrayRespuestas = array();
    foreach ($resultado as $key => $value) {
        //ARRAY CARGADO CON RESPUESTAS
        $array[] = $conexion->findAll2("SELECT * FROM pregunta_respuesta p inner join respuesta r on "
                . " p.id_respuesta = r.id_respuesta WHERE id_pregunta =" . $value->id_pregunta);
    }

    for ($i = 0; $i < count($resultado); $i++) {
        $arrayPreguntas[] = array("id_pregunta" => $resultado[$i]->id_pregunta, "descripcion" => $resultado[$i]->descripcion, "id_encuesta" => $resultado[$i]->id_encuesta, "respuestas" => array());
    }
    
    for ($j = 0; $j < count($array); $j++) {
        for ($k = 0; $k < count($array[$j]); $k++) {
            $arrayRespuestas[] = array("id" => $array[$j][$k]->id, "id_pregunta" => $array[$j][$k]->id_pregunta, "id_respuesta" => $array[$j][$k]->id_respuesta, "desc_respuesta" => $array[$j][$k]->descripcion);
        }
    }

    for ($k = 0; $k < count($arrayPreguntas); $k++) {
        for ($l = 0; $l < count($arrayRespuestas); $l++) {
            if ($arrayPreguntas[$k]["id_pregunta"] == $arrayRespuestas[$l]["id_pregunta"]) {
                $arrayPreguntas[$k]["respuestas"][] = $arrayRespuestas[$l];
            }
        }
    }
} else {
    //si el usuario no es verificado volvera al formulario de ingreso
    header('Location:login.html');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="dist/img/favicon.png" />
        <title>Listar Encuestas</title>        
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
                </section>             
                <section class="content">
                    <div class="box">                       
                        <div class="box-body">                           
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>   
                                            <h3>
                                                Encuesta: <?php echo $_GET['encuesta']; ?>
                                            </h3>  
                                        </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($arrayPreguntas as $valor) {
                                        ?>
                                        <tr>
                                            <td><span data-toggle="tooltip" title="" class="badge bg-green"><?php echo $valor["descripcion"] ?></span><br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="box box-solid"style="margin-left: 18%">

                                                            <div class="box-body" >
                                                                <div class="box-group" id="accordion">
                                                                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                                                    <div class="panel box box-primary">
                                                                        <div class="box-header with-border">
                                                                            <h4 class="box-title">
                                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $valor["id_pregunta"] ?>" >
                                                                                    <div class="box-header with-border">
                                                                                        <span data-toggle="tooltip" title="" class="badge bg-green">Ver Respuestas</span>
                                                                                    </div><!-- /.box-header -->
                                                                                </a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="collapse<?php echo $valor["id_pregunta"] ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                                            <!--<div id="collapseOne" class="panel-collapse collapse in">-->
                                                                            <div class="box-body">
                                                                                <ol>
                                                                                    <?php
                                                                                    foreach ($valor["respuestas"] as $respuestas) {
                                                                                        ?>
                                                                                        <li>
                                                                                        <?php
                                                                                        echo $respuestas["desc_respuesta"];
                                                                                        ?>
                                                                                        </li>
                                                                                        <?php } ?>
                                                                                </ol>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                                                                                                  
                                                                </div>
                                                            </div>                                          
                                                        </div>                                       
                                                    </div>                                                                               
                                                </div>                                                                           
                                            </td>
                                        </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                            <a href="listado_encuestas.php">
                            <input  type="button" name="regresar" id="regresar" value="Regresar" class="btn btn-block btn-primary" style="width: 8%">
                        </a>
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