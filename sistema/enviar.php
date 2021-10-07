<?php

include("Mailer/src/PHPMailer.php");
include("Mailer/src/SMTP.php");
include("Mailer/src/Exception.php");

/*var_dump("11111111111");
die();*/

try{

//$emailTo = $_POST["correo"];
$nm = $_POST["name"];	
$eml = $_POST["correo"];
$subject = $_POST["asunto"];
$bodyEmail = $_POST["mensaje"];

/*var_dump("11111111111");
die();*/

$fromemail = "admillanoss.a@gmail.com";
$fromname = "Usuario";
$host = "smtp.gmail.com";
$port = "587";
//$port = "465";
$SMTPAuth = "login";
$SMTPSecure = "tls";
//$SMTPSecure = "ssl";
$Password = "*********";	

$mail = new PHPMailer\PHPMailer\PHPMailer();	

$mail->isSMTP();
/* $mail->SMTPDebug = 1; -> sirve para mostrar todos los datos del smtp enviados a el correo electronico */
$mail->SMTPDebug = 0;
$mail->Host = $host;
$mail->Port = $port;
$mail->SMTPAuth = $SMTPAuth;
$mail->SMTPSecure = $SMTPSecure;
$mail->Username = $fromemail;
$mail->Password = $Password;

$mail->setFrom($fromemail, $fromname);
//correo a enviar emailTo
$mail->addAddress($fromemail);    

$mail->isHTML(true);

//datos
//$mail->Body = $nm;
//$mail->Body = $eml;

//asunto
$mail->Subject = $subject;

//mensaje textarea
$mail->Body = ("<br><b>Nombre: </b>".$nm. "<br><b>Correo: </b>".$eml. "<br><b>Mensaje: </b>".$bodyEmail. "<br><br><b>Gracias por comunicarse con nosotros, pronto responderemos su mensaje. </b>" );

if(!$mail->send()) {
    error_log(" MAILER: No se pudo enviar el correo electronico! ");
   
   } 
    //alert("Correo electronico enviado con exito!");
    //header("Location:index.php");
     //header("Location: gracias.html");
    echo "<script>alert('Mensaje enviado exitosamente');</script>";
    header("Location:contactanos.php");

}catch(Exception $e){

}



?>