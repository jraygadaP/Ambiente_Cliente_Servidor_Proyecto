<?php
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'includes/init.php';
require_once 'includes/header.php';

$db = Database::getInstance()->getConnection();

$user_id = $_SESSION['user_id'];
$sql = "SELECT Nombre, Apellido, Correo_Electronico, Numero_de_Telefono FROM Usuarios WHERE ID_Usuario = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$success_message = $error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_phone'])) {
        $new_phone = trim($_POST['telefono']);
        
        if (!empty($new_phone) && preg_match('/^\d{8,15}$/', $new_phone)) {
            $sql = "UPDATE Usuarios SET Numero_de_Telefono = ? WHERE ID_Usuario = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("si", $new_phone, $user_id);
            
            if ($stmt->execute()) {
                $success_message = "Número de teléfono actualizado con éxito.";
                $user['Numero_de_Telefono'] = $new_phone;
            } else {
                $error_message = "Error al actualizar el número de teléfono.";
            }
        } else {
            $error_message = "Por favor, ingresa un número de teléfono válido (8 a 15 dígitos).";
        }
    }

    if (isset($_POST['update_password'])) {
        $current_password = trim($_POST['current_password']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);

        if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
            // Verifica la contraseña actual
            $sql = "SELECT Contrasena FROM Usuarios WHERE ID_Usuario = ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_data = $result->fetch_assoc();

            if (password_verify($current_password, $user_data['Contrasena'])) {
                if ($new_password === $confirm_password) {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $sql = "UPDATE Usuarios SET Contrasena = ? WHERE ID_Usuario = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("si", $password_hash, $user_id);
                    
                    if ($stmt->execute()) {
                        $success_message = "Contraseña actualizada con éxito.";
                    } else {
                        $error_message = "Error al actualizar la contraseña.";
                    }
                } else {
                    $error_message = "Las contraseñas no coinciden.";
                }
            } else {
                $error_message = "La contraseña actual no es correcta.";
            }
        } else {
            $error_message = "Por favor, completa todos los campos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e7e7e7ec;
            color: #2D2E2C;
            font-family: 'Arial', sans-serif;
        }

        .title-box {
            background-color: #9EC4BB;
            color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-container {
            max-width: 500px;
            width: 100%;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 50px auto;
        }

        .btnlogin {
            background-color: #9EC4BB;
            color: #2D2E2C;
            width: 30%;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            padding: 8px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .btnlogin:hover {
            background-color: #CCCCBB;
            color: white;
        }

        footer {
            text-align: center;
            background-color: #2D2E2C;
            color: #FFFFFF;
            padding: 25px;
            margin-top: 50px;
        }

    </style>
</head>
<body>

    <div class="container mt-5">
        <h1 class="title-box">Mi Perfil</h1>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <h3>Información Personal</h3>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user['Nombre']); ?></p>
        <p><strong>Apellido:</strong> <?php echo htmlspecialchars($user['Apellido']); ?></p>
        <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($user['Correo_Electronico']); ?></p>

        <h3>Actualizar Número de Teléfono</h3>
        <form action="perfil.php" method="post">
            <div class="form-group">
                <label for="telefono">Número de Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user['Numero_de_Telefono']); ?>" required>
            </div>
            <button type="submit" name="update_phone" class="btnlogin">Actualizar Teléfono</button>
        </form>

        <hr>

        <h3>Actualizar Contraseña</h3>
        <form action="perfil.php" method="post">
            <div class="form-group">
                <label for="current_password">Contraseña Actual</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">Nueva Contraseña</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Nueva Contraseña</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="update_password" class="btnlogin">Actualizar Contraseña</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
