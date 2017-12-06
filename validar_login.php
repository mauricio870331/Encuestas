<?php

     include ('modelo/funciones_mysql.php');
    //usuario y clave pasados por el formulario
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    //usa la funcion conexiones() que se ubica dentro de funciones.php

    $conexion = new Conexion("sondeo");

    $rs = $conexion->login($usuario,$clave);


    if ($conexion->getTotalFilas()>0){
        //si es valido accedemos a vis_administrador.html(vista administrador)
        session_start();
        $_SESSION['usuario']=$usuario;
        header('Location:vis_administrador.php?mensaje=bienvenido');
    } else {
        //si no es valido volvemos al formulario inicial
        header('Location:login.html?mensaje=error_login');
    }

?>