<?php

include './funciones_mysql.php';
$conexion = new Conexion("sondeo");

try {
    //CONSULTA QUE TRAE LOS USUARIOS QUE HAN REALIZADO LA ENCUESTA
    $sql = "SELECT id_pregunta_respuesta, descripcion, COUNT(id_pregunta_respuesta) total
            from resultado_encuesta
            inner join detalle_resp_encuesta on resultado_encuesta.id_respuesta_encuesta = detalle_resp_encuesta.id_respuesta_encuesta
            INNER JOIN pregunta_respuesta on detalle_resp_encuesta.id_pregunta_respuesta = pregunta_respuesta.id
            INNER JOIN respuesta ON respuesta.id_respuesta = pregunta_respuesta.id_respuesta  
            GROUP by 1,2 ";
    
//    var donutData = [
//                    {label: "Series2", data: 30, color: "#3c8dbc"},
//                    {label: "Series3", data: 20, color: "#0073b7"},
//                    {label: "Series4", data: 50, color: "#00c0ef"}
//                ];
    
    $resultado = $conexion->findAll2($sql);
    echo 1;
    $array = array();
    $array2 = array();
    $i = 0;
    
    foreach ($resultado as $value) {
        $array['label'] = $value->descripcion;
        $array['data'] = $value->total;
        $array['color'] = "#3c8dbc";
        array_push($array2, $array);
    }
    
    echo json_encode($array2);
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}

?>