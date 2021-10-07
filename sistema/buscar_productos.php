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

    <?php 
     
     $busqueda = '';
     $search_proveedor = '';
     if(empty($_REQUEST['busqueda']) && empty($_REQUEST['proveedor'])) 
     {
        header("location: lista_producto.php");
      } 

      if(!empty($_REQUEST['busqueda'])){
        $busqueda = $conection->real_escape_string($_REQUEST['busqueda']);
        /*$busqueda = strtolower($_REQUEST['busqueda']);*/
        $where = "( p.codproducto LIKE '%$busqueda%' OR p.descripcion LIKE '%$busqueda%' ) AND p.estatus = 1 ";
        $buscar = 'busqueda='.$busqueda;
        
      } 
       
       if(!empty($_REQUEST['proveedor'])){
        $search_proveedor = $_REQUEST['proveedor'];
        $where = "p.proveedor LIKE $search_proveedor AND p.estatus = 1";
        $buscar = 'proveedor='.$search_proveedor;
      } 

    ?>
  
     <h1><i class="fas fa-cube" ></i> Lista de productos</h1>
     <?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3){ ?>
     <a href="registro_producto.php" class="btn_new"><i class="fas fa-plus"></i> Registrar producto</a>
     <?php } ?>
     <form action="buscar_productos.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>"> 
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
              
             $pro = 0;
             if(!empty($_REQUEST['proveedor'])){
                $pro = $_REQUEST['proveedor'];
             }

            $query_proveedor = mysqli_query($conection,"SELECT * FROM proveedor WHERE estatus = 1 ORDER BY proveedor ASC");
                $result_proveedor = mysqli_num_rows($query_proveedor);
         
             ?>

            <select name="proveedor" id="search_proveedor">
            <option value="" selected>PROVEEDOR</option>
       <?php 
          if($result_proveedor > 0)
           {
              while ($proveedor = mysqli_fetch_array($query_proveedor)){
                     if($pro == $proveedor['codproveedor']) 
                      
                     {
        ?>
        
   <option value="<?php echo $proveedor['codproveedor']; ?>" selected><?php echo $proveedor['proveedor']; ?></option>
              
          <?php 
                   }else{
            ?>

      <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>

            <?php  

                   }
                 }    
                }
            ?> 
        </select> 

            </th>
            <th>Foto</th> 
            <?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){ ?> <th>Acciones</th>  
          <?php } ?>
      </tr>

         <?php
           //paginador
           $sql_registe = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM producto as p WHERE $where ");

           $result_register = mysqli_fetch_array($sql_registe);
           $total_registro = $result_register['total_registro'];

           //total_paginas con registros
           //echo $total_registro;
          
           
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
     WHERE $where
     ORDER BY p.codproducto DESC LIMIT $desde,$por_pagina
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
          <?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){ ?> 

        <td>
               <a class="link_add add_product" product="<?php echo $data["codproducto"]; ?>" href="#"><i class="fas fa-plus"></i>     Agregar</a>
                |

          <a class="link_edit" href="editar_producto.php?id=<?php echo $data["codproducto"]; ?>"><i class="far fa-edit"></i>     Editar</a>
                |
            <a class="link_delete del_product" href="#" product="<?php echo $data["codproducto"]; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>
          
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
        if ($total_paginas != 0) 
        {
     ?> 

     <div class="paginador">
         <ul>
             <?php 
                if($pagina != 1)
                 {
             ?>

           <li><a href="?pagina=<?php echo 1; ?>&<?php echo $buscar; ?>"><i class="fas fa-step-backward"></i></a></li>
           <li><a href="?pagina=<?php echo $pagina-1; ?>&<?php echo $buscar; ?>"><i class="fas fa-caret-left fa-lg"></i></a></li>  
         <?php 
            }
            for ($i=1; $i <= $total_paginas; $i++) { 
                # code...
                if($i == $pagina)
                {
                echo '<li class="pageSelected">'.$i.'</li>';
                }else{    
                echo '<li><a href="?pagina='.$i.'&'.$buscar.'">'.$i.'</a></li>';
               }
              }  

              if($pagina != $total_paginas)
              {
            ?>
           <li><a href="?pagina=<?php echo $pagina + 1; ?>&<?php echo $buscar; ?>"><i class="fas fa-caret-right fa-lg"></i></a></li> 
           <li><a href="?pagina=<?php echo $total_paginas; ?>&<?php echo $buscar; ?>"><i class="fas fa-step-forward"></i></a></li>  
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