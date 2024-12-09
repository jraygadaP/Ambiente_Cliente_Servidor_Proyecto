<?php
require_once 'config/database.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function registrar($nombre, $apellido, $email, $password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO Usuarios (Nombre, Apellido, Correo_Electronico, Contrasena) 
                VALUES (?, ?, ?, ?)";
                
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $email, $password_hash);
        
        return $stmt->execute();
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM Usuarios WHERE Correo_Electronico = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['Contrasena'])) {
                $_SESSION['user_id'] = $user['ID_Usuario'];
                $_SESSION['user_name'] = $user['Nombre'];
                $_SESSION['user_email'] = $user['Correo_Electronico'];
                return true;
            }
        }
        return false;
    }
}
?>