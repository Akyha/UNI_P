<?php
    session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] !=2)
    {
      header("location: ./");
    }

   include "../conexion.php";
    
   if(!empty($_POST))
   {
   	  
      if(empty($_POST['producto'])) 
      {
         header("location: lista_producto.php");
         mysqli_close($conection);
      } 
      $idproducto = $_POST['idcliente'];
      
    
    $query_delete = mysqli_query($conection, "UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente ");  
      mysqli_close($conection);
      if($query_delete){
       header("location: lista_clientes.php");
    }else{
    	echo "Error al eliminar";
    }

}


   if(empty($_REQUEST['id']) )
   {
   	  header("location: lista_clientes.php");
      mysqli_close($conection);
   }else{
   	   
   	   $idcliente = $_REQUEST['id'];

   	   $query = mysqli_query($conection, "SELECT * FROM cliente WHERE idcliente = $idcliente ");
            mysqli_close($conection);
            $result = mysqli_num_rows($query);

            if($result > 0){
            	while ($data = mysqli_fetch_array($query)){
                # code..
            		$nit  = $data['nit'];
            		$nombre = $data['nombre'];
            		
            	}
           }else{
                header("location: lista_clientes.php"); 
              }
           }

      ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar cliente</title>
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
	<div class="data_delete">
     <i class="fas fa-user-times fa-7x" style="color: #e66262;"></i><br><br>
        <h3>¿Está seguro de eliminar el siguiente registro ?</h3>		
  <p>Nombre del Cliente: <span><?php echo $nombre; ?></span></p>
  <p>Nit: <span><?php echo $nit; ?></span></p>
        
    <form method="post" action="">
        <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
        <a href="lista_clientes.php" class="btn_cancel"><i class=""><i class="fas fa-ban"></i> Cancelar</a>
       <button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>
      </form>
  </div>
</section>
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