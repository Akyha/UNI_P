<?php 

include("conexion.php");


if (isset($_POST['restablecer'])) {
    if (strlen($_POST['clave'])) {
    	
	    //$clave = trim($_POST['clave']);
	    $clave = md5($_POST['clave']);
	    $consulta = "UPDATE usuario Set clave = '$clave' WHERE idusuario = 107";
	    $resultado = mysqli_query($conection,$consulta);
	 }
   }

 ?>