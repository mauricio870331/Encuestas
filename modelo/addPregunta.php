<?php

include './funciones_mysql.php';

$conexion = new Conexion("sondeo");

try {

    $pregunta = $_POST['pregunta'];
    $id_encuesta = $_POST['id_encuesta'];

    $sql = "INSERT INTO pregunta(descripcion,id_encuesta) VALUES('$pregunta',$id_encuesta)";
    $conexion->execQuery($sql);
    
    echo 1;
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>