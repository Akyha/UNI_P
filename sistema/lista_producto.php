<?php 
    /*permisos admin rol (1) - vendedor rol (2)*/
    session_start();
    if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3 and $_SESSION['rol'] != 4)
    {
      header("location: ./");
    }
    
    include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>lista productos</title>
</head>
<body>
   <!-- codigo carga -->
     <div id="contenedor_carga">
        <div id="carga"></div>
     </div> 
   <!-- ----------- -->  
	<?php include "includes/header.php"; ?>
  <section id="container">	
  <h1><i class="fas fa-cube" ></i> Lista de productos</h1>
     <?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3){ ?>
     <a href="registro_producto.php" class="btn_new"><i class="fas fa-plus"></i> Registrar producto</a>
     <?php } ?>
     <form action="buscar_productos.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar"> 
        <button type="submit" value="Buscar" class="btn_search"><i class="fas fa-search"></i></button>
     </form>

<div class="containerTable">
     <table>
      
     	<tr>
            <th>Código</th>
            <th>Descripcion</th>
            <th>precio</th>
            <th>Existencia</th>
            <th>
               <?php
            $query_proveedor = mysqli_query($conection,"SELECT * FROM proveedor WHERE estatus = 1 ORDER BY proveedor ASC");
                $result_proveedor = mysqli_num_rows($query_proveedor);
         
             ?>

            <select name="proveedor" id="search_proveedor">
            <option value="" selected>PROVEEDOR</option>
       <?php 
           
            if($result_proveedor > 0){
           while ($proveedor = mysqli_fetch_array($query_proveedor)){
                      # code...
        ?>
        
   <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
              
          <?php 
                   }
                        
                }
                ?> 
        </select> 

            </th>
            <th>Foto</th>
          <?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3){ ?> <th>Acciones</th>	
          <?php } ?>
     	</tr>

         <?php
           //paginador
           $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS total_registro FROM producto AS p WHERE estatus = 1");

           $result_register = mysqli_fetch_array($sql_registe);
           $total_registro = $result_register['total_registro'];
           
           /*Definimos cantidad de registros por pagina*/
           $por_pagina = 4;

           if(empty($_GET['pagina']))
           {
             $pagina = 1;
           }else{
             $pagina = $_GET['pagina'];
           }

          $desde = ($pagina-1) * $por_pagina;
           $total_paginas = ceil($total_registro / $por_pagina);

            ///////////////////////////////////////////////
        
     /*ASC es ascendente, DESC es desendente. */
 $query = mysqli_query($conection, "SELECT p.codproducto, p.descripcion, p.precio, p.existencia, pr.proveedor, p.foto 
     FROM producto p
     INNER JOIN proveedor pr	
     ON p.proveedor = pr.codproveedor
     WHERE p.estatus = 1 ORDER BY p.codproducto DESC LIMIT $desde,$por_pagina
             ");

          //aqui voy
         //cerramos conexion bd pagina
         mysqli_close($conection);
         $result = mysqli_num_rows($query);
          if($result > 0){
           
           while ($data = mysqli_fetch_array($query)){
           	  if($data['foto'] != 'img_producto.png'){
           	  	 $foto = 'img/uploads/'.$data['foto'];
           	  }else{
           	  	$foto = 'img/'.$data['foto'];
           	  }
          ?>
  
<tr class="row<?php echo $data["codproducto"]; ?>">
<td><?php echo $data["codproducto"]; ?></td>
<td><?php echo $data["descripcion"]; ?></td>
<td class="celPrecio"><?php echo $data["precio"]; ?></td>
<td class="celExistencia"><?php echo $data["existencia"]; ?></td>
<td><?php echo $data["proveedor"]; ?></td>
<!-- funcion php para vizualizar foto en modal-->
<td class="img_producto"><img src="<?php echo $foto; ?>"           alt="<?php echo $data["descripcion"]; ?>"></td>
        
          <!-- permisos -->
          <?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3){ ?> 

        <td>
               <a class="link_add add_product" product="<?php echo $data["codproducto"]; ?>" href="#"><i class="fas fa-plus"></i>     Agregar</a>
                |

     			<a class="link_edit" href="editar_producto.php?id=<?php echo $data["codproducto"]; ?>"><i class="far fa-edit"></i>     Editar</a>
                |
            <?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){ ?> 
            <a class="link_delete del_product" href="#" product="<?php echo $data["codproducto"]; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>
           <?php } ?>
         </td>
            <?php } ?>  
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