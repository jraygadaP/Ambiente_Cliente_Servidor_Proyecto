<?php
if (!isset($_SESSION)) {
    session_start();
}
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
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calculadora_impuestos.php">Calculadora de Impuestos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calculadora_aguinaldos.php">Calculadora de Aguinaldos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="comparacion_prestamos.php">Comparación de Préstamos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="administrador_presupuesto.php">Administración de Presupuestos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactenos.php">Contáctenos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="blog.php">Blog</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="notificacion.php">
                            <i class="fas fa-bell"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>