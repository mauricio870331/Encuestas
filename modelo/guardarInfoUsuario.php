<?php

include './funciones_mysql.php';
$conexion = new Conexion("sondeo");

date_default_timezone_set('America/Bogota');
$fecha = date('Y-m-d H:i:s');
$pregunta_respuesta = json_decode(@$_POST['respuestas']);

try {

    $nombre = @$_POST['nombre'];
    $documento = @$_POST['documento'];
    $telefono = @$_POST['telefono'];
    $email = @$_POST['email'];

    $sql = "INSERT INTO resultado_encuesta(usuario_encuestado,fecha_elaboracion,cedula,telefono,email,id_encuesta) VALUES('$nombre','$fecha','$documento','$telefono','$email'," . $_POST['id_encuesta'] . ")";
    $conexion->execQuery($sql);
    $resultado_encuesta = $conexion->getUltimoId("id_respuesta_encuesta", "resultado_encuesta", $documento);

    foreach ($pregunta_respuesta as $valor) {
        $respuesta_ta = "";
        if ($valor->opcion == 'TA') {
            $respuesta_ta = $valor->respuestaTA;
        }

        $sql = "INSERT INTO detalle_resp_encuesta(id_pregunta_respuesta,id_respuesta_encuesta,otra_respuesta) VALUES('$valor->id_pregunta_respuesta','$resultado_encuesta','$respuesta_ta')";
//        echo $sql;
//        die();
        $conexion->execQuery($sql);
    }
    echo 1;
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>