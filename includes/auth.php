
<?php
require_once 'config/database.php';
require_once 'init.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function registrar($nombre, $apellido, $email, $telefono, $password, $salario = null) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Usuarios (Nombre, Apellido, Correo_Electronico, Numero_de_Telefono, Contrasena) 
                VALUES (?, ?, ?, ?, ?)";
                
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("sssss", $nombre, $apellido, $email, $telefono, $password_hash);
        
        if (!$stmt->execute()) {
            die("Error en la consulta SQL: " . $stmt->error);
        }

        return true;
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM Usuarios WHERE Correo_Electronico = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            // Verifica la contraseña
            var_dump($user['Contrasena']);
            var_dump($password);
            if (password_verify($password, $user['Contrasena'])) {
                $_SESSION['user_id'] = $user['ID_Usuario'];
                $_SESSION['user_name'] = $user['Nombre'];
                $_SESSION['user_email'] = $user['Correo_Electronico'];
                return true;
            }
        }
        return false;
    }

    public function logout() {
        session_destroy();
        return true;
    }
}
?>