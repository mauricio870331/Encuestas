<?php 
include_once './modelo/funciones_mysql.php'; 
$conexion = new Conexion("sondeo");

try {
    
    $resultadoP = $conexion->findAll2("select id_pregunta,descripcion from pregunta where id_encuesta= " . $_GET['id']); //PREGUNTAS   
    $arrayPreguntas = array();   
    $arrayRespuestas = array();
    
        //CONSULTA QUE TRAE ID_PREGUNTA RESPUESTA Y TOTAL-RESPUESTAS
        $resultado2 = $conexion->findAll2($sql = "SELECT p.id_pregunta id_pregunta, r.descripcion respuesta, count(dr.id_pregunta_respuesta) total FROM encuesta e 
            inner join pregunta_respuesta pr on e.id_encuesta = pr.id_encuesta and pr.id_encuesta = " . $_GET['id'] . "
            inner join pregunta p on pr.id_pregunta = p.id_pregunta and p.id_encuesta = " . $_GET['id'] . "
            inner join respuesta r on pr.id_respuesta = r.id_respuesta and r.id_encuesta = " . $_GET['id'] . "
            inner join detalle_resp_encuesta dr on pr.id = dr.id_pregunta_respuesta
            WHERE e.id_encuesta = " . $_GET['id'] . "
            group by e.titulo, p.descripcion, r.descripcion");
        
        foreach ($resultadoP as $value) {
            $arrayPreguntas[] = array("id_pregunta"=>$value->id_pregunta,"descripcion"=>$value->descripcion, "respuestas"=> array());//SE ALMACENA LA CONSULTA $resultadoP EN UN NUEVO ARRAY $arrayPreguntas
        }
        
        foreach ($resultado2 as $value) {
            $arrayRespuestas[] = array("id_pregunta"=>$value->id_pregunta,"respuesta"=>$value->respuesta,"total"=>$value->total);//SE ALMACENA LA CONSULTA $resultado2 EN UN NUEVO ARRAY $arrayRespuestas
        }
        
        for ($index = 0; $index < count($arrayPreguntas); $index++) {// UNIÓN DE $arrayPreguntas Y $arrayRespuestas
            foreach ($arrayRespuestas as $value) {
                if ($arrayPreguntas[$index]['id_pregunta'] == $value['id_pregunta']) {
                    $arrayPreguntas[$index]['respuestas'][] = $value;
                }
            }
        }
        
    $consulta = "SELECT titulo FROM encuesta WHERE id_encuesta=" . $_GET['id'];
    $titulo = $conexion->findAll2($consulta); //titulo encuesta
    $conteo = "SELECT COUNT(id_encuesta) total FROM resultado_encuesta WHERE id_encuesta =". $_GET['id'];//CONSULTA PERSONAS ENCUESTADAS   
    $resultado_conteo = $conexion->findAll2($conteo);
    
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Gráfico</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<style type="text/css">
{demo.css}
</style>
<script type="text/javascript">
$(function () {
    $(document).ready(function () {
        // Build the chart
        $('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Gráfico Estadístico'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Browser share',
                 data: [               
                <?php 
                foreach ($arrayPreguntas as $valor){ ?>                                        
                ['<?php foreach ($valor['respuestas'] as $value) {echo $value['respuesta']." ";}?>',<?php foreach ($valor['respuestas'] as $value){ ?><?php echo $value['total']; ?><?php }?>],<?php } ?>]
            }]
        });
    });

});
</script>
</head>
<body  bgcolor="#eeeeee">
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>
<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
</body>
</html>