<?php include("conexion.php"); ?>

<style type="text/css">
  *{
  margin: 0;
  padding: 0;
  font-family: sans-serif;
  box-sizing: border-box;
}

body{
  background: #DEDEDE;
  display: flex;
  min-height: 100vh;
}

form{
  margin: auto;
  width: 50%;
  max-width: 500px;
  background: #f3f3f3;
  padding: 30px;
  border: 1px solid rgba(0,0,0,0.2);
}

a{
  margin: 125px;
  text-align: center;
  width: 50px;
}

h2{
  text-align: center;
  margin-bottom: 20px;
  color: rgba(0,0,0,0.5);
}

input{
  display: block;
  padding: 10px;
  width: 100%;
  margin: 25px 0;
  font-size: 20px;
}


input[type="submit"]{
  background: linear-gradient(#FFDA63, #FFB940);
  border: 0;
  color: brown;
  opacity: 0.8;
  cursor: pointer;
  border-radius: 20px;
  margin-bottom: 0;
}

input[type="submit"]:hover{
  opacity: 1;
}

input[type="submit"]:active{
  transform: scale(0.95);
}

@media (max-width: 768px){
  form{
    width: 75%;
  }
}

@media (max-width: 468px){
  form{
    width: 95%;
  }
}

.ok {
  text-align: center;
  width: 100%;
  padding: 12px;
  background-color: #1e6;
  color: #fff
}
.bad {
  text-align: center;
  width: 100%;
  padding: 12px;
  background-color: #a22;
  color: #fff
}
</style>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Restablecer contraseña</title>
	<link rel="stylesheet" type="text/css" href="css/diseño.css">
</head>
<body>
 <form action="reset_pass.php" method="post">
     	 <h2>RESTABLECER CONTRASEÑA</h2>
     	 <h2>ingresa nueva contraseña: </h2>
         <input type="password" placeholder="&#128272; Contraseña" name="clave"><input type="submit" name="restablecer" value="cambiar">
  </form>  
      <?php 
        include("reset_pass.php");
        ?>
</body>
</html>


