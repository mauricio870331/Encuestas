<?php

include './funciones_mysql.php';

$conexion = new Conexion("sondeo");

try {
    $pregunta = $_POST['pregunta'];
    $respuesta = $_POST['respuesta'];
    $id_encuesta = $_POST['id_encuesta'];
    
    $sql = "INSERT INTO respuesta (descripcion,id_encuesta) VALUES('$respuesta',$id_encuesta)";
    $sql .= ";INSERT INTO pregunta_respuesta(id_pregunta,id_respuesta,id_encuesta) "
         . "VALUES((SELECT id_pregunta from pregunta where descripcion = '".$pregunta."'),"
         . "(SELECT max(id_respuesta) from respuesta),$id_encuesta)";
    
    echo $sql;
    die();  
    
    $queries = explode(";", $sql);
  
    foreach ($queries as $value) {
        $conexion->execQuery($value);
    }    
    echo 1;    
} catch (Exception $ex) {
   echo $ex->getMessage();
   
}