<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = [];

    if (empty($_POST['nombre'])) $errores[] = "El campo 'Nombre' es obligatorio.";
    if (empty($_POST['email'])) $errores[] = "El campo 'Correo' es obligatorio.";
    if (empty($_POST['mensaje'])) $errores[] = "El campo 'Mensaje' es obligatorio.";

    if (empty($errores)) {
        $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $mensaje = htmlspecialchars($_POST['mensaje'], ENT_QUOTES, 'UTF-8');

        $consulta = "Nombre: $nombre\nCorreo: $email\nMensaje: $mensaje\n\n";

        $archivo = fopen("consultas.txt", "a");
        if ($archivo) {
            fwrite($archivo, $consulta);
            fclose($archivo);
            $exito = true;
        } else {
            $errores[] = "No se pudo guardar la consulta.";
        }
    }
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
            <p class="lead">¡Estamos aquí para ayudarte! Envíanos tu consulta.</p>

          
            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            
            <?php if (isset($exito) && $exito): ?>
                <div class="alert alert-success">
                    <p>¡Gracias por tu mensaje! Nos pondremos en contacto contigo pronto.</p>
                </div>
            <?php endif; ?>

            <form method="POST" id="contact-form">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje:</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>

    <div class="container mt-4 text-center">
        <p>Para consultas inmediatas, contáctanos al:</p>
        <p><i class="fas fa-phone-alt"></i> 506-0123-4567</p>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
