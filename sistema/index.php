<?php 
	session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <?php include "includes/scripts.php"; ?>
	<title>Sistema de Ventas</title>
</head>
<body>
 <!-- codigo carga -->
<div id="contenedor_carga">
    <div id="carga"></div>
</div> 
   <!-- ----------- -->    
  <?php 

	include "includes/header.php"; 
	include "../conexion.php";

  //DATOS DE LA EMPRESA
  $nit = '';
  $nombreEmpresa = '';
  $razonSocial = '';
  $telEmpresa = '';
  $emailEmpresa = '';
  $dirEmpresa = '';
  $iva = '';

  $query_empresa = mysqli_query($conection,"SELECT * FROM configuracion");
  $row_empresa = mysqli_num_rows($query_empresa);
  if($row_empresa > 0)
  {
     while($arrInfoEmpresa = mysqli_fetch_assoc($query_empresa)){
       $nit           = $arrInfoEmpresa['nit'];
       $nombreEmpresa = $arrInfoEmpresa['nombre'];
       $razonSocial   = $arrInfoEmpresa['razon_social'];
       $telEmpresa    = $arrInfoEmpresa['telefono'];
       $emailEmpresa  = $arrInfoEmpresa['email'];
       $dirEmpresa    = $arrInfoEmpresa['direccion'];
       $iva           = $arrInfoEmpresa['iva'];
     }
  }

	$query_dash = mysqli_query($conection,"CALL dataDashboard();");
	$result_dash = mysqli_num_rows($query_dash);
	if($result_dash > 0){
		 $data_dash = mysqli_fetch_assoc($query_dash);
		 mysqli_close($conection);
	}



	?>
	<section id="container">
	    <div class="divContainer">
	    	<div>
	           <h1 class="titlePanelControl">Panel de control</h1>	
            </div>
            <div class="dashboard">
               <?php  
                  if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) 
                  {
                ?>	
               <a href="lista_usuarios.php">
               	  <i class="fas fa-users"></i>
               	  <p>
               	    <strong>Usuarios</strong><br>
               	    <span><?= $data_dash['usuarios']; ?></span>
               	   </p> 
               </a>
               <?php  
                   }
               ?>  
               <a href="lista_clientes.php">
               	 <i class="fas fa-users"></i>
               	 <p>
               	 	<strong>Clientes</strong><br>
               	 	<span><?= $data_dash['clientes']; ?></span>
               	 </p>
               </a>
               <?php  
                  if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) 
                  {
                ?>
               <a href="lista_proveedor.php">
               	 <i class="far fa-building"></i>
               	 <p>
               	 	<strong>Proveedores</strong><br>
               	 	<span><?= $data_dash['proveedores']; ?></span>
               	 </p>
               </a> 
               <?php  
                   }
               ?>
               <a href="lista_producto.php">
               	 <i class="fas fa-cubes"></i>
               	 <p>
               	 	<strong>Productos</strong><br>
               	 	<span><?= $data_dash['productos']; ?></span>
               	 </p>
               </a>
               <a href="ventas.php">
               	 <i class="far fa-file-alt"></i>
               	 <p>
               	 	<strong>Ventas</strong><br>
               	 	<span><?= $data_dash['ventas']; ?></span>
               	 </p>
               </a> 	
            </div>
        </div>

        <div class="divInfoSistema">
        	<div>
	           <h1 class="titlePanelControl">Configuraci??n</h1>	
            </div>
            <div class="containerPerfil">
            	<div class="containerDataUser">
            		<div class="logoUser">
            			<img src="img/logoUser.png">
            		</div>
            		<div class="divDataUser">
            			<h4>Informaci??n Personal</h4>
                  
            			<div>
                    <label>Nombre: <span><?php echo $_SESSION['nombre']; ?></span></label>
                  </div>  
                  <div>
        <label>Correo: <span><?php echo $_SESSION['email']; ?></span></label>
                  </div>  
                 
                   <h4>Datos Usuario</h4>
                   <div>
<label>Rol: <span><?php echo $_SESSION['rol_name']; ?></span></label> 
                   </div>
                   <div>
                   	   <label>Usuario: <span><?php echo $_SESSION['user']; ?></span></label>
                   </div>

                   <h4>Cambiar contrase??a</h4>
                   <form action="" method="post" name="frmChangePass" id="frmChangePass">
                        
                        <div>
                        	<input type="password" name="txtPassUser" id="txtPassUser" placeholder="Contrase??a actual" required>
                        </div>
                         <div>
                        	<input class="newPass" type="password" name="txtNewPassUser" id="txtNewPassUser" placeholder="Nueva contrase??a" required>
                        </div>
                        <div>
                        	<input class="newPass" type="password" name="txtPassConfirm" id="txtPassConfirm" placeholder="Confirmar contrase??a" required>
                        </div>

                       <div class="alertChangePass" style="display: none;">
                       </div>

                        <div>
                        	<button type="submit" class="btn_save btnChangePass"><i class="fas fa-key" ></i> Cambiar contrase??a</button>
                        </div>
                     </form>
                    </div>
            	</div><br>
               <?php if($_SESSION['rol'] == 1){ ?> 
            	 <div class="containerDataEmpresa">
            		 <div class="logoEmpresa">
            		 	 <img src="img/logoEmpresa.png">
            		 </div>
            		<h4>Datos de la empresa</h4>
              
   <form action="" method="post" name="frmEmpresa" id="frmEmpresa">
          <input type="hidden" name="action" value="updateDataEmpresa">

          <div>
          	<label>Nit:</label><input type="text" name="txtNit" id="txtNit" placeholder="Nit de la empresa" value="<?= $nit; ?>" required>
          </div>   
          <div>
          	<label>Nombre:</label><input type="text" name="txtNombre" id="txtNombre" placeholder="Nombre de la empresa" value="<?= $nombreEmpresa; ?>" required>
          </div>    
          <div>
          	<label>Raz??n social:</label><input type="text" name="txtRSocial" id="txtRSocial" placeholder="Raz??n social"    value="<?= $razonSocial; ?>">
          </div>
          <div>
          	<label>Tel??fono:</label><input type="text" name="txtTelEmpresa" id="txtTelEmpresa" placeholder="N??mero de tel??fono" value="<?= $telEmpresa; ?>" required>
          </div> 
          <div>
          	<label>Correo electr??nico:</label><input type="email" name="txtEmailEmpresa" id="txtEmailEmpresa" placeholder="Correo electr??nico" value="<?= $emailEmpresa; ?>" required>
          </div>
          <div>
          	<label>Direcci??n:</label><input type="text" name="txtDirEmpresa" id="txtDirEmpresa" placeholder="Direcci??n de la empresa" value="<?= $dirEmpresa; ?>" required>
          </div>    
          <div>
          	<label>Iva (%):</label><input type="text" name="txtIva" id="txtIva" placeholder="Impuesto al valor agregado (IVA)" value="<?= $iva; ?>" required>
          </div>      		 	
 
          <div class="alertFormEmpresa" style="display: none;"></div>
          
         <div>
          	<button type="submit" class="btn_save btnChangePass"><i class="far fa-save fa-lg"></i>  Guardar datos</button>
          </div> 
      </form>
   </div>
     <?php } ?>
  </div>
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