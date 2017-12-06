<?php

include './funciones_mysql.php';

$conexion = new Conexion("sondeo");

try {
    $id = $_POST['id'];
    $opcion = $_POST['opc'];
    $query = "";
    switch ($opcion) {
        case 1:
            $query = "DELETE FROM pregunta_respuesta WHERE id_respuesta=" . $id;
            $query .= ";DELETE FROM respuesta WHERE id_respuesta = " . $id;
            $queries = explode(";", $query);

            break;
        case 2:
            $query = "DELETE FROM pregunta_respuesta WHERE id_pregunta=" . $id;
            $query .= ";DELETE FROM pregunta WHERE id_pregunta = " . $id;
            break;
        case 3:
            $query = "DELETE FROM pregunta_respuesta WHERE id_encuesta = " . $id;
            $query .= ";DELETE FROM respuesta WHERE id_encuesta = " . $id;
            $query .= ";DELETE FROM pregunta WHERE id_encuesta = " . $id;
         

            break;
    }
    
    $queries = explode(";", $query);
    foreach ($queries as $value) {
        $conexion->execQuery($value);
    }
    
    echo 1;
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>