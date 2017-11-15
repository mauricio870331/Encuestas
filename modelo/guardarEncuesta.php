<?php

session_start();
date_default_timezone_set('America/Bogota');
$fecha = date('Y-m-d H:i:s');
$nombre_usuario = $_SESSION['usuario'];
include './funciones_mysql.php';
$titulo = $_POST['titulo'];

$data = json_decode(@$_POST['DATA']); //TRAE VALORES DE LAS PREGUNTAS
$data2 = json_decode(@$_POST['DATA2']); //TRAE LAS PREGUNTAS CON LAS RESPUESTAS


try {
    $conexion = new Conexion("sondeo");

    $sql = "INSERT INTO encuesta (titulo,fecha_creacion,creada_por) VALUES('$titulo','$fecha','$nombre_usuario')";
    $conexion->execQuery($sql);
    $idEncuesta = $conexion->getUltimoId("id_encuesta", "encuesta"); //clave que servira como llave foranea de la tabla pregunta
    //--------- Guardar PREGUNTAS ---------------------

    foreach ($data as $valor) {

        $sql = "INSERT INTO pregunta(descripcion,id_encuesta) VALUES('$valor->id',$idEncuesta)";
        $conexion->execQuery($sql);
    }

    //--------- Guardar RESPUESTAS ---------------------

    foreach ($data2 as $valor2) {
        $consulta = "SELECT id_pregunta FROM pregunta WHERE descripcion = '$valor2->pregunta'";
        $resultado_pregunta = $conexion->findAll2($consulta);
        $sql2 = "INSERT INTO respuesta(descripcion,id_encuesta) VALUES('$valor2->respuesta',$idEncuesta)";
        $conexion->execQuery($sql2);
        $id_respuesta = $conexion->getUltimoId("id_respuesta", "respuesta");
        $sql3 = "INSERT INTO pregunta_respuesta(id_pregunta,id_respuesta,id_encuesta) VALUES(" . $resultado_pregunta[0]->id_pregunta . ",$id_respuesta,$idEncuesta)";

        $conexion->execQuery($sql3);
    }
    echo 1;
} catch (Exception $ex) {
    echo $ex->getMessage();
}