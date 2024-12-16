<?php
// Mostrar errores para la depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de configuración de la base de datos
require_once 'config/config.php'; 

// Crear la instancia de la base de datos y obtener la conexión
$db = Database::getInstance();
$conn = $db->getConnection();

// Verificar si la conexión a la base de datos está activa
if (!$conn) {
    header('Content-Type: application/json'); // Asegúrate de devolver siempre JSON
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error]);
    exit; // Asegúrate de que el script no siga ejecutándose
}

// Validar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'markAllAsRead') {
    $sql = "UPDATE notificaciones SET Leida = 1 WHERE Leida = 0";
    
    if ($conn->query($sql) === TRUE) {
        header('Content-Type: application/json'); // Asegúrate de devolver siempre JSON
        echo json_encode(['status' => 'success', 'message' => 'Todas las notificaciones se marcaron como leídas.']);
    } else {
        header('Content-Type: application/json'); // Asegúrate de devolver siempre JSON
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar las notificaciones: ' . $conn->error]);
    }
} else {
    header('Content-Type: application/json'); // Asegúrate de devolver siempre JSON
    echo json_encode(['status' => 'error', 'message' => 'Acción no válida o datos POST no recibidos.']);
}

$conn->close();
exit; // Evita que cualquier cosa adicional se envíe






