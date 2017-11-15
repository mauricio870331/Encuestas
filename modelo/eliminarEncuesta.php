<?php

include './funciones_mysql.php';
$conexion = new Conexion("sondeo");

try {
    
    $id_encuesta = $_POST['id_encuesta'];
    
    $query = "DELETE FROM pregunta_respuesta WHERE id_encuesta = " . $id_encuesta;
    $query .= ";DELETE FROM respuesta WHERE id_encuesta = " . $id_encuesta;
    $query .= ";DELETE FROM pregunta WHERE id_encuesta = " . $id_encuesta;
    $query .= ";DELETE FROM encuesta WHERE id_encuesta = " . $id_encuesta;

    $queries = explode(";", $query);
    foreach ($queries as $value) {
        $conexion->execQuery($value);
    }
    echo 1;
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>