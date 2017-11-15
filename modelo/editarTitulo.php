<?php

    include './funciones_mysql.php';
    $conexion = new Conexion("sondeo");
    
    try {
    
        $id_encuesta = $_POST['id_encuesta'];
        $titulo = $_POST['titulo'];
        
        $sql = "UPDATE encuesta SET titulo='".$titulo."' WHERE id_encuesta = ".$id_encuesta;
        $conexion->execQuery($sql);
        echo 1;
        
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>