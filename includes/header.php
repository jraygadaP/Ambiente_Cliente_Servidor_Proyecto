<?php
if (!isset($_SESSION)) {
    session_start();
}
$logueado = isset($_SESSION['user_id']); // Verifica si el usuario está logueado
?>
<!DOCTYPE html>
<html lang="es">
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand mx-auto" href="index.php">El Financiero</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                
                <!-- Estos enlaces siempre estarán visibles -->
                <li class="nav-item">
                    <a class="nav-link text-truncate" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-truncate" href="contactenos.php">Contáctenos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-truncate" href="blog.php">Blog</a>
                </li>

                <?php if ($logueado): ?>
                    <!-- Estos enlaces se mostrarán solo si el usuario está logueado -->
                    <li class="nav-item">
                        <a class="nav-link text-truncate" href="calculadora_impuestos.php">Calculadora de Impuestos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-truncate" href="calculadora_aguinaldos.php">Calculadora de Aguinaldos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-truncate" href="comparacion_prestamos.php">Comparación de Préstamos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-truncate" href="administrador_presupuesto.php">Administración de Presupuestos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-truncate" href="notificacion.php">
                            <i class="fas fa-bell"></i>
                        </a>
                    </li>

                    <!-- Menú desplegable de usuario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <!-- Mostrar el nombre del usuario -->
                            <span class="dropdown-item-text font-weight-bold">
                                <i class="fas fa-user"></i> 
                                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </span>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="perfil.php">Mi Perfil</a>
                            <a class="dropdown-item" href="logout.php">Cerrar Sesión</a>
                        </div>
                    </li>

                <?php else: ?>
                    <!-- Este enlace solo se muestra si el usuario NO está logueado -->
                    <li class="nav-item">
                        <a class="nav-link text-truncate" href="login.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </nav>
</header>


