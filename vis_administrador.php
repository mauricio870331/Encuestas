<?php
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
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="dist/img/favicon.png" />
        <title>Crear Encuesta</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>  
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />      
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />      
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" /> 
        <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />  
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link href="js/notificaciones.css" rel="stylesheet" type="text/css">
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
                        Encuesta
                    </h1>         
                </section>             
                <section class="content">
                    <form>                  
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Título Encuesta</h3>          
                            </div>
                            <div class="box-body">                
                                <input type="text" name="titulo" id="titulo" size="55px">            
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Pregunta</h3> 
                            </div>
                            <div class="box-body">                
                                <input type="text" name="titulo" id="pregunta" size="55px">
                                <a><i class="fa fa-plus" aria-hidden="true"value="+" id="new_pregunta" style="font-size:18px;cursor: pointer " data-toggle="tooltip"title="Agregar Pregunta"></i></a>              

                                <!-- TABLA-->
                                <table class="table table-bordered" id="tbl_preguntas" style="margin-top: 15px">
                                    <tr>                      
                                        <th>Pregunta</th>                     
                                        <th style="width: 40px">Acción</th>
                                    </tr>
                                </table>
                                <!--FIN  TABLA-->                                
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Respuesta</h3>          
                            </div>
                            <div class="box-body"> 
                                <select id="selec_preguntas" style="width: 18%; height: 22px">
                                    <option value="" >seleccione Pregunta</option>
                                </select>
                                <input  type="text" name="respuesta" size="45px" id="respuesta" placeholder="Digite 'Otro' si desea una respuesta personalizada"> 
                                <a><i class="fa fa-plus" aria-hidden="true"value="+" id="new_respuesta" style="font-size:18px;cursor: pointer " data-toggle="tooltip"title="Agregar Respuesta"></i></a>   
                               
                                <!-- TABLA-->
                                <table class="table table-bordered" id="tbl_respuestas" style="margin-top: 15px">
                                    <tr>
                                        <th>Pregunta</th>    
                                        <th>Respuesta</th>                                                                                  
                                        <th style="width: 40px">Acción</th>
                                    </tr>
                                </table>
                                <!--FIN  TABLA-->                               
                                <input  type="button" name="enviar" id="enviar" value="Guardar" class="btn btn-block btn-primary" style="width: 8%">
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    
        <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>       
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>     
        <script src="plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>   
        <script src='plugins/fastclick/fastclick.min.js'></script>       
        <script src="dist/js/app.min.js" type="text/javascript"></script>
        <script src="js/notificaciones.js"></script>
        <script src="dist/js/funciones.js" type="text/javascript"></script>     

        <script>
    $(document).ready(function () {

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