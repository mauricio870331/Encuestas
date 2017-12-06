<?php

//funcion para conectar a la base de datos y verificar la existencia del usuario
function conexiones($usuario, $clave) {
	//conexion con el servidor de base de datos MySQL
	$conectar = mysqli_connect('localhost','root','');
	//seleccionar la base de datos para trabajar
	mysqli_select_db($conectar,'sondeo');
	
 	//sentencia sql para consultar el nombre del usuario	
	$sql = "SELECT * FROM administradores WHERE usuario = '". $usuario ."' AND password ='". $clave ."' ";
	//ejecucion de la sentencia anterior
	$ejecutar_sql=mysqli_query($conectar,$sql);
	//si existe inicia una sesion y guarda el nombre del usuario
	if (mysqli_num_rows($ejecutar_sql)!=0){
		//inicio de sesion
		session_start();
		//configurar un elemento usuario dentro del arreglo global $_SESSION
		$_SESSION['usuario']=$usuario;
		//retornar verdadero
		return true;
	} else {
		//retornar falso
		return false;		
	}
}
//funcion para verificar que dentro del arreglo global $_SESSION existe el nombre del usuario
function verificar_usuario(){
	//continuar una sesion iniciada
    ini_set("session.cookie_lifetime","86400");
    ini_set("session.gc_maxlifetime","86400");
	 session_start();
	//comprobar la existencia del usuario
	if ($_SESSION['usuario']){
		return true;
	}
}

?>