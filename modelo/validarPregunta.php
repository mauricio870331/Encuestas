<?php

    include './funciones_mysql.php';
    $conexion = new Conexion("sondeo");
    
    try{
        $id_pregunta = $_POST['id_pregunta'];
        $sql = "SELECT COUNT(*) pregunta FROM pregunta_respuesta WHERE id_pregunta =".$id_pregunta;
        $resultado = $conexion->findAll2($sql);
        echo $resultado[0]->pregunta;
        
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
    
?>