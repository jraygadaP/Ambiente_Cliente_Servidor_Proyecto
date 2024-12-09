<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctenos - El Financiero</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e7e7e7ec;
            color: #2D2E2C;
            font-family: 'Arial', sans-serif;
        }

        .form-control {
            border: 1px solid #CCCCBB; 
        }

        .form-group label {
            color: #2D2E2C; 
        }

        .btn-primary {
            background-color: #9EC4BB;
            border-color: #9EC4BB; 
        }

        .btn-primary:hover {
            background-color: #EED7C5;
            border-color: #EED7C5; 
        }

        .container {
            margin-top: 50px;
        }

        .card {
            background-color: #FFFFFF; 
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2D2E2C; 
            font-weight: bold;
        }

        .footer {
            text-align: center;
            background-color: #2D2E2C;
            color: #FFFFFF;
            padding: 20px;
            margin-top: 50px;
        }
    </style>
</head>

<body>
   <?php include 'includes/header.php'; ?>

   <div class="container">
       <div class="card">
           <h2>Contáctenos</h2>
           <p class="lead">Nuestra página nació para ayudarte a gestionar tus finanzas de manera fácil y práctica. 
           Aparte de brindarte herramientas como la calculadora de impuestos y aguinaldos, también te damos 
           consejos de ahorro y cálculos importantes para tu economía. ¡Estamos aquí para ayudarte!</p>

           <form id="contact-form">
               <div class="form-group">
                   <label for="name">Nombre:</label>
                   <input type="text" class="form-control" id="name" required>
               </div>
               <div class="form-group">
                   <label for="email">Correo:</label>
                   <input type="email" class="form-control" id="email" required>
               </div>
               <div class="form-group">
                   <label for="message">Mensaje:</label>
                   <textarea class="form-control" id="message" rows="4" required></textarea>
               </div>
               <button type="submit" class="btn btn-primary">Enviar</button>
           </form>

           <div id="confirmation-message" class="alert alert-success mt-3" style="display: none;">
               <p>¡Gracias por tu mensaje! Nos pondremos en contacto contigo pronto.</p>
           </div>
       </div>
   </div>

   <div class="container mt-4 text-center">
       <p>Para consultas inmediatas, contáctanos al:</p>
       <p><i class="fas fa-phone-alt"></i> 506-0123-4567</p>
   </div>

   <?php include 'includes/footer.php'; ?>

   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
   <script>
       $(document).ready(function() {
           $('#contact-form').on('submit', function(e) {
               e.preventDefault();
               if (this.checkValidity()) {
                   $('#confirmation-message').show();
                   this.reset();
               }
               $(this).addClass('was-validated');
           });
       });
   </script>
</body>
</html>