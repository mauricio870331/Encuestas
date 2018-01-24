<?php
include ('./funcion_validarUsu.php');
date_default_timezone_set('America/Bogota');
$hora_ingreso = date("H:i:s");
include 'modelo/funciones_mysql.php';
$conexion = new Conexion("sondeo");

//ARRAY CARGADO CON PREGUNTAS
//print_r($_GET['id']);
//die();
$resultado = $conexion->findAll2("SELECT * FROM pregunta WHERE id_encuesta =" . @$_GET['id']);
$consulta = "SELECT titulo FROM encuesta WHERE id_encuesta=".$_GET['id'];
$resultado2 = $conexion->findAll2($consulta);

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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="dist/img/favicon.png" />
        <title>Vista Usuario</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>      
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />       
        <link href="plugins/maxcdn.css" rel="stylesheet" type="text/css" />     
        <link href="plugins/ionicFramework.css" rel="stylesheet" type="text/css" />
        <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />     
        <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />     
        <link href="js/notificaciones.css" rel="stylesheet" type="text/css">      
        <link href="plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="skin-green">     
        <div class="wrapper">        
            <div class="content-wrapper">           
                <section class="content-header">
                    <?php foreach ($resultado2 as $valor2) { ?>
                    <h1 style="text-align: center !important">
                        Formulario Encuesta - <?php echo $valor2->titulo;?>
                    </h1>       
                    <?php }?>                    
                </section>                
                <section class="content">
                    <div class="box" style = "width: 60%;margin-left: 20%;">                       
                        <div class="box-body">
                            <form role="form" id="form_encuesta">
                                <div class="box-body" >
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nombre Completo</label>
                                        <input type="text" class="form-control" placeholder="Nombre Completo" id="nombre" name="nombre">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Documento</label>
                                        <input type="text" class="form-control"  placeholder="Número de Documento" id="documento" name="documento">
                                    </div>
                                     <div class="form-group">
                                        <label for="exampleInputEmail1">Teléfono</label>
                                        <input type="text" class="form-control"  placeholder="Número de teléfono o celular" id="telefono" name="telefono">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" class="form-control"  placeholder="Email" id="email" name="email">
                                    </div> 
                                    <!-- for ini -->
                                    <?php
                                  
                                    foreach ($arrayPreguntas as $valor) {
                                        ?>
                                        <label id="pregunta_<?php echo $valor["id_pregunta"]; ?>"><?php echo $valor["descripcion"] ?></label><br><br>
                                        <ol>
                                            <?php
                                            foreach ($valor["respuestas"] as $respuestas) {
                                                ?>
                                                <li>
                                                    <div class="form-group" style="margin-top: -7px;">
                                                        <?php
                                                        if (strcmp($respuestas["desc_respuesta"], "otro") == 0) {
                                                            echo $respuestas["desc_respuesta"];
                                                            ?>
                                                            <br> <textarea data-opcion="TA" data-idrespuesta="<?php echo $respuestas["id"]; ?>" type="textarea" name="pregunta_<?php echo $valor['id_pregunta']; ?>" cols="80" id="otro_<?php echo $valor['id_pregunta']; ?>" onclick="clearoptions(<?php echo $valor['id_pregunta']; ?>);addPreguntaRespuesta(<?php echo $valor['id_pregunta']; ?>,<?php echo $respuestas["id"]; ?>, 'TA', 'otro_<?php echo $valor['id_pregunta']; ?>')"></textarea>

                                                        <?php } else { ?>

                                                            <input type="radio" 
                                                                   name="pregunta<?php echo $valor['id_pregunta']; ?>"
                                                                   value="<?php echo $respuestas["id"]; ?>" data-opcion="RB" data-idrespuesta="<?php echo $respuestas["id"]; ?>" class="flat-red" id="<?php echo $valor['id_pregunta']; ?>" onclick="addPreguntaRespuesta(<?php echo $valor['id_pregunta']; ?>,<?php echo $respuestas["id"]; ?>, 'RB','')" style="cursor:pointer"/>

                                                            <?php echo $respuestas["desc_respuesta"];
                                                            }
                                                        ?>
                                                    </div> 
                                                </li>
                                            <?php } ?>
                                        </ol>
                                        <?php 
                                    } ?>
                                    <!-- for fin -->
                                </div>
                                <div class="box-footer">
                                    <input type="button" data-id="<?php echo $_GET['id'] ?>" class="btn btn-primary" value="Enviar" id="btn_enviar">
                                </div>
                            </form>         
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
        <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script src='plugins/fastclick/fastclick.min.js'></script>
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <script src="js/notificaciones.js"></script>
        <script src="dist/js/funciones.js" type="text/javascript"></script>
        <script src="js/notify.js" type="text/javascript"></script>
        
        <script>
        $(document).ready(function () {  
     
        $("#example1").dataTable();
        var mensaje = getParameterByName('mensaje');

        if (mensaje === 'registro') {
            showAlert("Encuesta Guardada con èxito", "success", 250, 60);
        }

        if (mensaje === 'errorEncuesta') {
            showAlert("Error al guardar la encuesta", "error", 250, 60);
        }

        if (mensaje === 'eliminarEncuesta') {
            showAlert("Encuesta Eliminada", "success", 250, 60);
        }

        if (mensaje === 'errorEliminarEncuesta') {
            showAlert("Error al eliminar la encuesta", "error", 250, 60);
        }        

        if (mensaje === 'errorRegistroEncuestaUsu') {
            showAlert("Error al enviar la encuesta", "error", 250, 60);
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