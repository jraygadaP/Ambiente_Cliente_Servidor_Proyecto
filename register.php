<?php
// Requiere los archivos de configuración
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'includes/init.php';
require_once 'includes/header.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth = new Auth();
    
    // Capturar y limpiar los datos
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm-password'] ?? '');

    // Validar los datos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido.';
    } elseif ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        // Intentar registrar al usuario
        try {
            $registrado = $auth->registrar($nombre, $apellido, $email, $telefono, $password);
            if ($registrado) {
                $success = 'Registro exitoso. Por favor, inicia sesión.';
            } else {
                $error = 'Error al registrar el usuario. Verifica la base de datos.';
            }
        } catch (Exception $e) {
            $error = 'El correo electrónico ya está registrado o hubo un problema con la base de datos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Financiero - Registro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e7e7e7ec;
            color: #2D2E2C;
            font-family: 'Arial', sans-serif;
        }
        .card {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 50px auto;
        }
        h2 {
            color: #2D2E2C;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control {
            border: 1px solid #CCCCBB;
            margin-bottom: 15px;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }
        .btn-register {
            background-color: #9EC4BB;
            color: #2D2E2C;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 100%;
            cursor: pointer;
        }
        .btn-register:hover {
            background-color: #EED7C5;
        }
        .info-text {
            font-size: 0.9em;
            color: #666;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Registro</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form action="register.php" method="post">
            <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
            <input type="text" class="form-control" name="apellido" placeholder="Apellido" required>
            <input type="email" class="form-control" name="email" placeholder="Correo Electrónico" required>
            <input type="tel" class="form-control" name="telefono" placeholder="Número de Teléfono">
            <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            <input type="password" class="form-control" name="confirm-password" placeholder="Confirmar Contraseña" required>
            <button type="submit" class="btn-register">Registrarse</button>
        </form>
        <p class="info-text">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
