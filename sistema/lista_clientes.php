<?php 
    /*permisos admin rol (1) - vendedor rol (2)*/
    session_start();
    include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>lista clientes</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
  <div id="contenedor_carga">
        <div id="carga"></div>
     </div>   
	<?php include "includes/header.php"; ?>
  <section id="container">	
	
     <h1><i class="fas fa-users" ></i> Lista de clientes</h1>
     <a href="registro_cliente.php" class="btn_new"><i class="fas fa-plus"></i> Crear cliente</a>

     <form action="buscar_cliente.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar"> 
        <button type="submit" value="Buscar" class="btn_search"><i class="fas fa-search"></i></button>  
     </form>

<div class="containerTable">
     <table>
     	<tr>
            <th>ID</th>
            <th>Nit</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Acciones</th>		
     	</tr>

         <?php
           //paginador
           $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS total_registro FROM cliente WHERE estatus = 1");
           $result_register = mysqli_fetch_array($sql_registe);
           $total_registro = $result_register['total_registro'];
           
           /*Definimos cantidad de registros por pagina*/
           $por_pagina = 6;

           if(empty($_GET['pagina']))
           {
             $pagina = 1;
           }else{
             $pagina = $_GET['pagina'];
           }

           $desde = ($pagina-1) * $por_pagina;
           $total_paginas = ceil($total_registro / $por_pagina);
        
         /*ASC es ascendente, DESC es desendente.*/
         $query = mysqli_query($conection, "SELECT * FROM cliente 
               WHERE estatus = 1 ORDER BY idcliente ASC LIMIT $desde,$por_pagina
             ");
         //cerramos conexion bd pagina
         mysqli_close($conection);
         $result = mysqli_num_rows($query);
          if($result > 0){
           
           while ($data = mysqli_fetch_array($query)){
              if($data["nit"] == 0)
               {
                $nit = 'C/F';
               }else{
                 $nit = $data["nit"]; 
               }
               
        ?>
  
     	<tr>
     		    <td><?php echo $data["idcliente"]; ?></td>
            <td><?php echo $nit; ?></td>
            <td><?php echo $data["nombre"]; ?></td>
            <td><?php echo $data["telefono"]; ?></td>
            <td><?php echo $data["direccion"]; ?></td>
        <td>
     			<a class="link_edit" href="editar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="far fa-edit"></i> Editar</a>
                                                                           
  <?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){ ?> 
            |
<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data["idcliente"]; ?>"><i class="fas fa-ban"></i> Bloquear</a>
          
          <?php } ?>      
            
            </td>
     	   </tr>
     
         <?php 
    
            }
          }
     	
        ?>
     </table>
</div>
     <?php 

    if ($total_registro != 0)
          {
      ?>  

     <div class="paginador">
         <ul>
             <?php 
                if($pagina != 1)
                 {
             ?>

           <li><a href="?pagina=<?php echo 1; ?>"><i class="fas fa-step-backward"></i></a></li>
           <li><a href="?pagina=<?php echo $pagina-1; ?>"><i class="fas fa-caret-left fa-lg"></i></a></li>  
         <?php 
            }
            for ($i=1; $i <= $total_paginas; $i++) { 
                # code...
                if($i == $pagina)
                {
                echo '<li class="pageSelected">'.$i.'</li>';
                }else{    
                echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
               }
              }  

              if($pagina != $total_paginas)
              {
            ?>
           <li><a href="?pagina=<?php echo $pagina + 1; ?>"><i class="fas fa-caret-right fa-lg"></i></a></li> 
           <li><a href="?pagina=<?php echo $total_paginas; ?>"><i class="fas fa-step-forward"></i></a></li>  
           <?php } ?>  
         </ul>
     </div>

<?php } ?>

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