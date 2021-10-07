<?php include("conexion.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Email</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>
        
      <form action="enviar_correo.php" name="enviar_correo" method="post">
     	 <h2>RECUPERAR CONTRASEÑA</h2>
         <input type="email" placeholder="&#128272; Correo electronico" name="correo">
          <!--<input type="button" onclick="limpiarFormulario()" value="Limpiar formulario">-->
           <input type="submit" value="Submit">
          
             
         <br>
         <a href="index.php">Regresar</a>
     </form>   

      <!--<script>
              function limpiarFormulario() {
             document.getElementById("miForm").reset();
             }
      </script>--> 

</body>
</html>