<?php

    include './funciones_mysql.php';
    $conexion = new Conexion("sondeo");

    try{
    $id_respuesta = $_POST['id_respuesta'];
    $id_pregunta = $_POST['id_pregunta'];
    $id_encuesta = $_POST['id_encuesta'];
    $respuesta = $_POST['respuesta'];
    
    $editar = "UPDATE respuesta SET descripcion = '".$respuesta."' WHERE id_respuesta = ".$id_respuesta." AND id_encuesta =".$id_encuesta;
    $conexion->execQuery($editar);   
    echo 1;
    
    } catch (Exception $e){
        echo $e->getMessage();     
        
    }
?>