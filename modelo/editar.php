<?php

include './funciones_mysql.php';
$conexion = new Conexion("sondeo");

try {


    if ($_POST['opcion'] == 'opc1') {

        $id_pregunta = $_POST['id_pregunta'];
        $id_encuestaP = $_POST['id_encuesta'];
        $valorTd = $_POST['respuesta']; //nuevo valor en la td a editar

        $editar = "UPDATE pregunta SET descripcion = '" . $valorTd . "' WHERE id_pregunta = " . $id_pregunta . " AND id_encuesta = " . $id_encuestaP;
        
    } else {

        $id_respuesta = $_POST['id_respuesta'];
        $id_encuesta = $_POST['id_encuesta'];
        $respuesta = $_POST['respuesta']; //nuevo valor
        $id_pregunta_R = $_POST['idpregunta_R'];

        $editar = "UPDATE respuesta SET descripcion = '" . $respuesta . "' WHERE id_respuesta = " . $id_respuesta . " AND id_encuesta =" . $id_encuesta;
    }
    
    $conexion->execQuery($editar);
    echo 1;
    
} catch (Exception $e) {
    echo $e->getMessage();
}