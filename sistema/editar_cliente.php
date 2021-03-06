<?php
    session_start();
    /*se restringe permiso 
    a rol 2 de editar clientes
       
    if($_SESSION['rol'] != 1)
    {
      header("location: ./");
    }*/
    
    include "../conexion.php";

    if(!empty($_POST))
    {
       $alert = '';
       if(empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']))
       {
          $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
       }else{

           $idcliente = $_POST['id'];
           $nit       = $_POST['nit'];
           $nombre    = $_POST['nombre'];
           $telefono  = $_POST['telefono'];
           $direccion = $_POST['direccion'];
          
    $result = 0;
   //if(is_numeric($nit)and !=0) 
   {
     $query = mysqli_query($conection,"SELECT * FROM cliente include
                        WHERE (nit = '$nit' AND idcliente != $idcliente) 
                        ");
    
     $result = mysqli_fetch_array($query);
     //$result = count($result);            
   }
           
          if($result > 0){
            $alert='<p class="msg_error">El nit ya existe, Ingrese otro.</p>';
           }else{
                
                if($nit == '')
                {
                   $nit = 0;
                }

            $sql_update = mysqli_query($conection, "UPDATE cliente
            SET nit = $nit, nombre='$nombre', telefono='$telefono', direccion='$direccion'WHERE idcliente = $idcliente");
                              
               if($sql_update){
                    $alert='<p class="msg_save">Cliente actualizado correctamente.</p>';
                }else{
                    $alert='<p class="msg_error">Error al actualizar el Cliente.</p>';
                }
           }
       }
    }

     //Mostrar datos
     if(empty($_REQUEST['id']))
     {
       header('location: lista_clientes.php');
       //cerramos conexion bd pagina
       mysqli_close($conection);
     }
     $idcliente= $_REQUEST['id'];

     $sql= mysqli_query($conection,"SELECT * FROM cliente
                                       WHERE idcliente = $idcliente and estatus = 1");

    //cerramos conexion bd pagina
    mysqli_close($conection);
    $result_sql = mysqli_num_rows($sql);
      
     if($result_sql ==0){
         header('location: lista_clientes.php');
     }else{
        while($data   = mysqli_fetch_array($sql)){
          $idcliente  = $data['idcliente'];
          $nit        = $data['nit'];
          $nombre     = $data['nombre'];
          $telefono   = $data['telefono'];
          $direccion  = $data['direccion'];
          
        }
     } 
      
  ?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
<?php include "includes/scripts.php"; ?>
<title>Actualizar cliente</title>
<link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <!-- codigo carga -->
<div id="contenedor_carga">
    <div id="carga"></div>
</div> 
   <!-- ----------- --> 
    <?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1><i class="far fa-edit"></i> Actualizar cliente</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            
           <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $idcliente; ?>">
            <label for="nit">NIT</label>
             <input type="number" name="nit" id="nit" placeholder="N??mero de  NIT" value="<?php echo $nit; ?>">
            <label for="nombre">Nombre</label>
             <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">
            <label for="telefono">Tel??fono</label>
             <input type="number" name="telefono" id="telefono" placeholder="Tel??fono" value="<?php echo $telefono; ?>">
            <label for="direccion">Direcci??n</label>
             <input type="text" name="direccion" id="direccion" placeholder="Direcci??n completa" value="<?php echo $direccion; ?>">

            <button type="submit" class="btn_save"><i class="fas fa-user-edit"></i> Actualizar cliente</button> 
            
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