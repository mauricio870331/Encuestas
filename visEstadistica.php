<?php
include 'modelo/funciones_mysql.php';
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
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Estadística Encuesta</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>   
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />  
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />   
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />  
        <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />  
        <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <div class="wrapper">      
            <header class="main-header">
                <a class="logo"><b>Admin</b> Encuestas</a>      
                <nav class="navbar navbar-static-top" role="navigation">         
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>          
                </nav>
            </header>  
            <aside class="main-sidebar"> 
                <section class="sidebar">       
                    <ul class="sidebar-menu">
                        <li class="treeview">
                            <a href="listado_encuestas.php">
                                <i class="fa fa-files-o"></i><span>Volver a Listado Encuestas</span>                                           
                            </a>      
                        </li>                  
                    </ul>  
                </section>            
            </aside>    
            <div class="content-wrapper">     
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">                                  
                                    <i class="fa fa-bar-chart-o"></i>
                                    <h3 class="box-title"><?php echo $titulo[0]->titulo ?></h3>
                                    <h3 class="box-title" style="margin-left: 800px">Total Encuestados:&numsp;<?php echo "<b>".$resultado_conteo[0]->total."</b>" ?></h3>
                                </div>
                                <div class="box-body">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>                       
                                            <tr>
                                                <th style="width: 25%!important; text-align: center">Pregunta</th>
                                                <th style="width: 10%!important; text-align: center">Respuesta</th>
                                                <th style="width: 10%!important; text-align: center">Total Respuestas</th>                       
                                            </tr>                   
                                        </thead>
                                        <tbody> 
                                            <?php foreach ($arrayPreguntas as $valor) { ?>  
                                                <tr>
                                                    <td>
                                                   <?php echo $valor['descripcion'] ?>
                                                    </td>  
                                                    <td style="text-align: center">
                                                     
                                                        <?php
                                                            foreach ($valor['respuestas'] as $value) {                                                     
                                                                   echo $value['respuesta']."<br>";                                                
                                                            }
                                                        ?>
                                                  
                                                    </td>                                                    
                                                    <td style="text-align: center">                                                    
                                                        <?php
                                                            foreach ($valor['respuestas'] as $value) { ?>
                                                                  <span class="badge bg-light-blue">
                                                                    <?php echo $value['total']; ?>
                                                                  </span>
                                                        <br>
                                                           <?php }?>                                            
                                                    </td>                                   
                                                </tr>
                                            <?php } ?>                        
                                        </tbody>                               
                                    </table>
                                </div>
                            </div>
                        </div>       
                    </div>     
                </section>      
            </div>
        </div>    
        <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>    
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>   
        <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>    
        <script src='plugins/fastclick/fastclick.min.js'></script>    
        <script src="dist/js/app.min.js" type="text/javascript"></script>    
        <script src="dist/js/demo.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(function () {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
    </body>
</html>