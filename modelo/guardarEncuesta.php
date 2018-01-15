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



    $temp = array();

    foreach ($data as $valor) {

        $sql = "INSERT INTO pregunta(descripcion,id_encuesta) VALUES('$valor->id',$idEncuesta)";
        $conexion->execQuery($sql);
        $rs = $conexion->findAll2("SELECT @@identity AS id");
        $temp[$rs[0]->id] = $valor->id;
    }

   
    //--------- Guardar RESPUESTAS ---------------------//

    foreach ($data2 as $valor2) {
        $id_pregunta = array_search($valor2->pregunta, $temp);
        $sql2 = "INSERT INTO respuesta(descripcion,id_encuesta) VALUES('$valor2->respuesta',$idEncuesta)";
        $conexion->execQuery($sql2);
        $id_respuesta = $conexion->getUltimoId("id_respuesta", "respuesta");
        $sql3 = "INSERT INTO pregunta_respuesta(id_pregunta,id_respuesta,id_encuesta) VALUES(" . $id_pregunta . ",$id_respuesta,$idEncuesta)";
        $conexion->execQuery($sql3);
    }

    $actualiza = "UPDATE encuesta set link = '" . $_SERVER['HTTP_HOST'] . "/encuesta/redireccionVistaUsu.php?id=" . $idEncuesta . "' WHERE id_encuesta=" . $idEncuesta . "";
    $conexion->execQuery($actualiza);

    echo 1;
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>