<?php 
  session_start();

  include "../conexion.php";


?>  

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <?php include "includes/scripts.php"; ?>
  <title>Contactanos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://kit.fontawesome.com/cd33816f91.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
<!-------------------------------------------------------->
<?php include "includes/header.php"; 
include "includes/header.php"; ?> 
   <section id="container">
   
        <link rel="stylesheet" href="css/estilos.css">
  <div class="form_register">
   <div class="texto">
        <img type="button" src="img/contact.png" value="Abrir Ventana Modal" class="btn-abrir">
        <p>CONTACTANOS</p>
        <label>Correo: admillanoss.a@gmail.com</label>
        <!--<input type="button" value="Abrir Ventana Modal" class="btn-abrir">-->
    </div>
      <div class="pop-up">
        <div class="pop-up-wrap">
            <div class="pop-up-title">
                <h2>Bienvenidos</h2>
                <p>Mercallanos siempre de tu lado.</p>
            </div>
 <div class="subcription">
                <div class="line"></div>
                <i class="far fa-times-circle" id="close"></i>
                <div class="sub-content">
                    <h2>Contactanos</h2>
                    <p>Tus opiñones, felicitaciones, quejas o inquietudes son importantes para nosotros.</p>
         <form action="enviar.php" name="enviar"  method="post">
         <!--------------------------------------------------->
         
          <input type="text" name="name" id="name" class="subs-email" placeholder="Ingrese su nombre" required>
                    <div class="contenedor"> 
          
          <input type="email" name="correo" id="correo" class="subs-email" placeholder="Ingrese correo" required>
                    <div class="contenedor">

          <!--------------------------------------------------->
                      
          <input type="text" name="asunto" id="asunto" class="subs-email" placeholder="Ingrese asunto" required>
                    <div class="contenedor"> 
                    
           <textarea  id="mensaje" name="mensaje" class="subs-email" placeholder="Aquí escriba su mensaje." required></textarea>

           <button class="subs-send" type="submit">Enviar Consulta</button>

           </form>
           
                      </div>
                     
                        <a href="#"><img src="img/icons8-play-button.svg" alt=""></a>
                        <a href="#"><img src="img/icons8-facebook.svg" alt=""></a>
                        <a href="#"><img src="img/icons8-instagram.svg" alt=""></a>
                    </form>
                </div>
                
                <div class="line"></div>
            </div>
        </div>
    </div>
  
    <!-------------------------------------------------------->
  </section>
    <?php include "includes/footer.php"; ?>
</body>
</html>