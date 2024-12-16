<?php
// Incluir la configuración de la base de datos y la clase Database
require_once 'config/config.php';
require_once 'config/database.php';

$db = Database::getInstance(); 
$conn = $db->getConnection();

if (isset($_GET['id'])) { 
    $id = (int)$_GET['id']; // Convertir a entero para mayor seguridad

    if ($id <= 0) {
        die("ID inválido.");
    }

    $query = "DELETE FROM presupuesto WHERE ID_Presupuesto = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: administrador_presupuesto.php");
        exit();
    } else {
        die("No se pudo eliminar el registro o el ID no existe.");
    }

    $stmt->close();

} else { 
    die("No se proporcionó ningún ID.");
}
?>



