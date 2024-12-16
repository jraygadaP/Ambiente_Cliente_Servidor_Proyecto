<?php
// Requiere los archivos de configuración
require_once 'config/config.php'; // Asegúrate de que la ruta es correcta
require_once 'includes/auth.php';
require_once 'includes/header.php';

// Obtener la instancia de la clase Database y la conexión
$db = Database::getInstance();
$conn = $db->getConnection();

// Consultar las notificaciones de la base de datos
$sql = "SELECT ID_Notificacion, Descripcion, IF(Leida = 1, 'Sí', 'No') AS Leida FROM notificaciones ORDER BY ID_Notificacion DESC";
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Inicializar el array de notificaciones
$notificaciones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notificaciones[] = [
            'id' => $row['ID_Notificacion'],
            'texto' => $row['Descripcion'],
            'leida' => $row['Leida']
        ];
    }
} else {
    $notificaciones = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones - El Financiero</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e7e7e7ec;
            color: #2D2E2C;
            font-family: 'Arial', sans-serif;
        }
        .container { margin-top: 30px; }
        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .notification-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eaeaea;
            transition: background-color 0.3s ease;
        }
        .notification-item:hover {
            background-color: #f0f8ff;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .notification-item i {
            font-size: 22px;
            margin-right: 12px;
            color: #007bff;
            cursor: pointer;
        }
        .notification-item i:hover {
            color: #0056b3;
        }
        .notification-text {
            font-size: 16px;
            color: #333;
            flex-grow: 1;
        }
        .badge {
            border-radius: 20px;
            background-color: #e74c3c;
            color: white;
            font-size: 14px;
            padding: 5px 12px;
            margin-left: 10px;
        }
        .mark-all-btn {
            margin-top: 20px;
            text-align: center;
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

   <div class="container">
       <div class="card">
           <h2 class="text-center">Notificaciones</h2>

           <?php if (empty($notificaciones)): ?>
               <div class="text-center mt-4">
                   <p>No tienes notificaciones nuevas</p>
               </div>
           <?php else: ?>
               <?php foreach ($notificaciones as $notificacion): ?>
                   <div class="notification-item" data-id="<?php echo $notificacion['id']; ?>">
                       <i class="fas fa-bell"></i>
                       <span class="notification-text"><?php echo $notificacion['texto']; ?></span>
                       <?php if (!$notificacion['leida']): ?>
                           <span class="badge">Nuevo</span>
                       <?php endif; ?>
                   </div>
               <?php endforeach; ?>

               <div class="mark-all-btn">
                   <button type="button" id="markAllRead" class="btn btn-primary btn-sm">
                       Marcar todas como leídas
                   </button>
               </div>
           <?php endif; ?>
       </div>
   </div>

   <?php include 'includes/footer.php'; ?>

   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
   <script>
$(document).ready(function() {
    // Al hacer clic en el botón "Marcar todas como leídas"
    $('#markAllRead').click(function() {
        // Ocultar todos los "badges"
        $('.badge').fadeOut();

        // Realizar una solicitud AJAX para marcar todas las notificaciones como leídas
        $.ajax({
    url: 'marcar_todas_notificacion.php',
    method: 'POST',
    data: { action: 'markAllAsRead' },
    success: function(response) {
        try {
            // Intenta convertir la respuesta a JSON (siempre debería ser JSON)
            const res = JSON.parse(response);
            if (res.status === 'success') {
                console.log(res.message);
            } else {
                console.error(res.message);
            }
        } catch (e) {
            console.error('Error de respuesta no válida', response);
        }
    },
    error: function(xhr, status, error) {
        console.error('Error de red: ', error);
    }
});

    });

    // Al hacer clic en una notificación individual
    $('.notification-item').click(function() {
        $(this).find('.badge').fadeOut();
    });
});

</script>


</body>
</html>

<?php
$conn->close(); // Cerrar la conexión a la base de datos
?>
