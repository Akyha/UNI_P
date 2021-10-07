<?php

include("conexion.php");
include("Mailer/src/PHPMailer.php");
include("Mailer/src/SMTP.php");
include("Mailer/src/Exception.php");



/*var_dump("11111111111");
die();*/

try{

$emailTo = $_POST["correo"];


/*var_dump("11111111111");
die();
*/

$fromemail = "admillanoss.a@gmail.com";
$subject = "Restablecer contrasena";
$fromname = "Servicio al cliente";
$host = "smtp.gmail.com";
$port = "587";
//$port = "465";
$SMTPAuth = "login";
$SMTPSecure = "tls";
//$SMTPSecure = "ssl";
$Password = "*********";	

$mail = new PHPMailer\PHPMailer\PHPMailer();	

$mail->isSMTP();
//$mail->SMTPDebug = 0;
$mail->SMTPDebug = 1;
$mail->Host = $host;
$mail->Port = $port;
$mail->SMTPAuth = $SMTPAuth;
$mail->SMTPSecure = $SMTPSecure;
$mail->Username = $fromemail;
$mail->Password = $Password;
//asunto
$mail->Subject = $subject;

$mail->setFrom($fromemail, $fromname);
//correo a enviar emailTo
$mail->addAddress($emailTo);    

$mail->isHTML(true);

//$user = "SELECT clave from datos where clave";

/*$resultado = mysqli_result($conex, "Tu contraseña olvidada es: " .$clave);
*/
/*$queryusuario 	= mysqli_query($conex,"SELECT * FROM datos WHERE email = '$emailTo'");
$nr 			= mysqli_num_rows($queryusuario); 
if ($nr == 1)
{
$mostrar		= mysqli_fetch_array($queryusuario); 
$pass 	= $mostrar['clave'];

$paracorreo 		= $correo;
$titulo				= "Recuperar Password";
$mensaje			= "Tu password es: ".$pass;
$tucorreo			= "From: xxxx@gmail.com";

if(mail($paracorreo,$titulo,$mensaje,$tucorreo))
{
	echo "<script> alert('Contraseña enviado');window.location= 'index.html' </script>";
}else
{
	echo "<script> alert('Error');window.location= 'index.html' </script>";
}
}
else
{
	echo "<script> alert('Este correo no existe');window.location= 'index.html' </script>";
}*/
/*VaidrollTeam*/

//mensaje buzon
//$mail->Body = "Tu contraseña es: " .$pass;
$mail->Body    = "'Has recibo un correo electronico si has sido tu y estas de acuerdo con la actualizacion de tu contraseña sigue este enlace de lo contrario por favor omitir el mensaje.<a href='http://localhost/facturacion/restablecer.php/'>www.resetpass.com</a>'";


/*$user_pass = mysqli_query($conn,"SELECT * FROM datos WHERE clave = '$clave'");
*/

if(!$mail->send()) {
    error_log("MAILER: No se envio! "); 
   }    

    echo "Correo electronico enviado con exito!"; 

}catch(Exception $e){

}



?>