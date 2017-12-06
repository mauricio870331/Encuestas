<?php

include './funciones_mysql.php';
$conexion = new Conexion("sondeo");

try {

    $id_encuesta = $_POST['id_encuesta'];   
    $id_pregunta = $_POST['id_pregunta'];
    $sql = "DELETE FROM pregunta WHERE id_pregunta= " . $id_pregunta;
    $sql .= ";DELETE FROM pregunta_respuesta WHERE id_pregunta=" . $id_pregunta;
    $queries = explode(";", $sql);
    
    foreach ($queries as $value) {
         $conexion->execQuery($value);
    }   

    echo 1;
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>