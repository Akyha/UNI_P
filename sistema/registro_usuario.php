<?php
    session_start();
    if($_SESSION['rol'] != 1)
    {
      header("location: ./");
    }
    
    include "../conexion.php";

    if(!empty($_POST))
    { 

      
       //verificar si captura foto tipo file
       //print_r($_FILES);
       //exit;
       $alert='';
       //campos que deben deben ser ingresados
       if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol']))
       {
          $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
       }else{
           
           $nombre = $_POST['nombre'];
           $email  = $_POST['correo'];
           $user   = $_POST['usuario'];
           $clave  = md5($_POST['clave']);
           $rol    = $_POST['rol'];
      
           

           $foto = $_FILES['foto'];
           $nombre_foto = $foto['name'];
           $type = $foto['type'];
           $url_temp = $foto['tmp_name'];

           $imgUser = 'img_users.png';

           //condicion no hay img "vacio - encryptamiento"
           if($nombre_foto != '')
           {
              $destino     = 'fotos/';
              $img_nombre  = 'img_'.md5(date('d-m-Y H:m:s'));
              $imgUser = $img_nombre.'.jpg';
              $src         = $destino.$imgUser; 
           }
       
       $query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email' ");
      $result = mysqli_fetch_array($query);

      if($result > 0){
        $alert='<p class="msg_error">El correo o el usuario ya existe.</p>';
      }else{ 

        $query_insert = mysqli_query($conection,"INSERT INTO usuario(nombre,correo,usuario,clave,rol)
         VALUES('$nombre','$email','$user','$clave','$rol')");

        $query_insert = mysqli_query($conection,"INSERT INTO usuarios(foto,nombre,correo,usuario)
         VALUES('$imgUser','$nombre','$email','$user')");
   

          if($query_insert){
            if($nombre_foto != ''){
              move_uploaded_file($url_temp,$src);
            }
    $alert='<p class="msg_save">Usuario creado correctamente.</p>';
          }else{
    $alert='<p class="msg_error">Error al crear el usuario.</p>'; 
            
       }  
     }

    }   
        //mysqli_close($conection);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <?php include "includes/scripts.php"; ?>
  <title>Registro Usuario</title>
</head>
<body>
    <div id="contenedor_carga">
        <div id="carga"></div>
     </div>  

  <?php include "includes/header.php"; ?>
  <section id="container">
    
    <div class="form_register">
      <h1>Registro usuario</h1>
      <hr>
      <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            
            <!-- enctype servira para permitir adjuntar archivos en este
              caso una imagen o foto de producto -->
      <form action="" method="post" enctype="multipart/form-data">
        <!-- mostrar boton desplegable con proveedores usando php -->
           <form action="" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre completo">

           <label for="correo">Correo electrónico</label>
        <input type="email" name="correo" id="correo" placeholder="Correo electrónico">

           <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario" placeholder="Usuario">

          <label for="clave">Clave</label>
        <input type="password" name="clave" id="clave" placeholder="Clave de acceso">

           

             <label for="rol">Tipo Usuario</label>

        <?php 

          $query_rol = mysqli_query($conection,"SELECT * FROM rol");
          mysqli_close($conection);
          $result_rol = mysqli_num_rows($query_rol);

         ?>

        <select name="rol" id="rol">
          <?php 
            if($result_rol > 0)
            {
              while ($rol = mysqli_fetch_array($query_rol)) {
          ?>
              <option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
          <?php 
                # code...
              }
              
            }
           ?>
        </select>

          <div class="photo">
                   <label for="foto">Foto</label>
                   <div class="prevPhoto">
                   <span class="delPhoto notBlock">X</span>
                   <label for="foto"><img id="Wcam" src="img/cam.png"></label>
                   </div>
                   <div class="upimg">
                   <input type="file" name="foto" id="foto">
                   </div>
                   <div id="form_alert"></div>
             </div>

             <button type="submit" class="btn_save"><i class="far fa-save"></i> Crear usuario</button>
            


            </form>
          </div>
      </section>

  <?php include "includes/footer.php"; ?>
     <!-- codigo carga -->
    <script>
        window.onload = function(){
            var contenedor = document.getElementById('contenedor_carga');

            contenedor.style.visibility = 'hidden';
            contenedor.style.opacity = '0';
        }
    </script>
</body>
</html>