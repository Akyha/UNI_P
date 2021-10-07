<?php 
	
$alert = '';
session_start();
if(!empty($_SESSION['active']))
{
	header('location: sistema/');
}else{

	if(!empty($_POST))
	{
		if(empty($_POST['usuario']) || empty($_POST['clave']))
		{
			$alert = 'Ingrese su usuario y su clave';
		}else{

			require_once "conexion.php";

			$user = mysqli_real_escape_string($conection,$_POST['usuario']);
			$pass = md5(mysqli_real_escape_string($conection,$_POST['clave']));

			$query = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.idrol,r.rol FROM usuario u 
                  INNER JOIN rol r
                  ON u.rol = r.idrol
				  WHERE u.usuario= '$user' AND u.clave = '$pass'");
			//mysqli_close($conection);
			$result = mysqli_num_rows($query);

			if($result > 0)
			{
				$data = mysqli_fetch_array($query);
				$_SESSION['active']   = true;
				$_SESSION['idUser']   = $data['idusuario'];
				$_SESSION['nombre']   = $data['nombre'];
				$_SESSION['email']    = $data['correo'];
				$_SESSION['user']     = $data['usuario'];
				$_SESSION['rol']      = $data['idrol'];
				$_SESSION['rol_name'] = $data['rol'];

				header('location: sistema/');
			}else{
				$alert = 'El usuario o la clave son incorrectos';
				//session_destroy();

			}


		}
            
	}
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
   
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Login | Sistema Facturación</title>
	<!--<link rel="stylesheet" type="text/css" href="css/style.css">-->
	 <link rel="stylesheet" href="css/estilos2.css">
	<link  href="../Jquery/style.css" rel="stylesheet" />
 </head>
<body>
 
 <section id="container">
		  <div class="contenedor-form">
        <div class="toggle">
            <span> Crear Cuenta</span>
        </div>
		
     <div class="formulario">
     	<img class="imgg" src="img/login.png" alt="Login">
		  <h3 class="inic">Iniciar sesión</h3>
		<form action="" method="post">	
		<!--<img src="img/login.png" alt="Login">-->
    <input type="text" name="usuario" placeholder="&#128273; Usuario" required>

    <input type="password" name="clave" placeholder="🔐 Contraseña" required>
    <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

    <input class="boton5" type="submit" value="Iniciar Sesión" name="btningresar"> 

    
 </form>
        </div>

   <!-- //////////////////////////////////////// -->	
     

<?php 
	
	$alert = '';
	/*session_start();*/
	require_once "conexion.php";
  
  if(!empty($_POST))
	{   
      
      if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nombre"]) && preg_match('/^[0-9a-zA-Z ]+$/',$_POST["registropassword"]) &&
        preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $_POST["registroemail"]))
                  
       {


		$alert='';
		if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
			 }else{
             $respuesta = "error";
             return $respuesta;
         }

		}else{

			$nombre = $_POST['nombre'];
			$email  = $_POST['correo'];
			$user   = $_POST['usuario'];
			$clave  = md5($_POST['clave']);
			$rol    = $_POST['rol'];

            echo $email."--------------------";
            echo $user."--------------------";

			$query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email'");
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">El correo o el usuario ya existe.</p>';
			}else{

				$query_insert = mysqli_query($conection,"INSERT INTO usuario(nombre,correo,usuario,clave,rol)
			   VALUES('$nombre','$email','$user','$clave','$rol')");
				
				if($query_insert){
					$alert='<p class="msg_save">Usuario creado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al crear el usuario.</p>';
				}

			}


		}

	}



 ?>

<script type="text/javascript">

const formulario = document.getElementById('formulario');
const inputs = document.querySelectorAll('#formulario input');

const expresiones = {
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	clave: /^.{4,12}$/, // 4 a 12 digitos.
}

const campos = {
	usuario: false,
	nombre: false,
	password: false,
	correo: false,
	telefono: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "nombre":
			validarCampo(expresiones.nombre, e.target, 'nombre');
		break;
		case "correo":
			validarCampo(expresiones.correo, e.target, 'correo');
		break;
		case "usuario":
			validarCampo(expresiones.usuario, e.target, 'usuario');
		break;
		case "clave":
			validarCampo(expresiones.password, e.target, 'clave');
			validarPassword2();
		break;
		
	}
}
</script>


<div class="formulario"> 
<form action="#" method="post">
<label for="nombre">Nombre</label>
<input type="text" name="nombre" id="nombre" placeholder="Nombre completo">
<label for="correo">Correo electrónico</label>
<input type="email" name="correo" id="correo" placeholder="Correo electrónico">
<label for="usuario">Usuario</label>
<input type="text" name="usuario" id="usuario" placeholder="Usuario">
<label for="clave">Clave</label>
<input type="password" name="clave" id="clave" placeholder="Clave de acceso">
<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
<label for="rol">Tipo Usuario</label>

				<?php 

					$query_rol = mysqli_query($conection,"SELECT * FROM rol");
					mysqli_close($conection);
					$result_rol = mysqli_num_rows($query_rol);

				 ?>

				<select type="hidden" name="rol" id="rol">
				<option value="4" selected>Visitante</option>	
				</select>
				<!--<p>Estoy de acuerdo con <a href="#">Terminos y Condiciones</a></p>-->
<input class="boton5" type="submit" value="Crear usuario"></form>
				
          
        </div>
        <div class="reset-password">
        	<!--<a href="EnviarPassword.php">Olvide mi Contraseña?</a>-->
        	<a href="reset_password.php">Olvide mi Contraseña?</a>
        </div>
    </div>

	</section>
	<script src="js/jquery-3.1.1.min.js"></script>    
    <script src="js/main.js"></script>
</body>
</html>