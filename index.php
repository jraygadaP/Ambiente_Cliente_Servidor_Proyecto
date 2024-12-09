<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Verificar si el usuario está logueado
$logueado = isset($_SESSION['user_id']);
$nombreUsuario = $logueado ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - El Financiero</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/finanzas.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 100px 20px;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero-section p {
            font-size: 1.2rem;
            margin-top: 20px;
        }

        .feature-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.2s ease-in-out;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
        
        .user-welcome {
            margin-right: 15px;
            color: #2D2E2C;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">El Financiero</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <?php if ($logueado): ?>
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
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="contactenos.php">Contáctenos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                    <?php if ($logueado): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="notificacion.php">
                            <i class="fas fa-bell"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($nombreUsuario); ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="perfil.php">Mi Perfil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Cerrar Sesión</a>
                        </div>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="hero-section">
            <h1>Bienvenido a El Financiero</h1>
            <?php if ($logueado): ?>
                <p>Bienvenido de vuelta, <?php echo htmlspecialchars($nombreUsuario); ?>!</p>
            <?php else: ?>
                <p>Tu aliado en la gestión de finanzas personales y empresariales</p>
            <?php endif; ?>
            <a href="#features" class="btn btn-primary btn-lg mt-4">Explorar Funciones</a>
        </div>

        <div class="container my-5">
            <div class="row text-center" id="features">
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <i class="fas fa-calculator fa-3x mb-3 text-primary"></i>
                        <h4>Calculadoras</h4>
                        <p>Herramientas para calcular impuestos, aguinaldos y más.</p>
                        <a href="<?php echo $logueado ? 'calculadora_impuestos.php' : 'login.php'; ?>" 
                           class="btn btn-outline-primary">
                            <?php echo $logueado ? 'Ver más' : 'Iniciar sesión para ver más'; ?>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <i class="fas fa-piggy-bank fa-3x mb-3 text-success"></i>
                        <h4>Presupuestos</h4>
                        <p>Administra tus finanzas con nuestras herramientas de presupuesto.</p>
                        <a href="<?php echo $logueado ? 'administrador_presupuesto.php' : 'login.php'; ?>" 
                           class="btn btn-outline-success">
                            <?php echo $logueado ? 'Comenzar' : 'Iniciar sesión para comenzar'; ?>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <i class="fas fa-chart-line fa-3x mb-3 text-info"></i>
                        <h4>Comparación</h4>
                        <p>Encuentra los mejores préstamos y opciones financieras.</p>
                        <a href="<?php echo $logueado ? 'comparacion_prestamos.php' : 'login.php'; ?>" 
                           class="btn btn-outline-info">
                            <?php echo $logueado ? 'Descubre más' : 'Iniciar sesión para descubrir'; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> El Financiero. Todos los derechos reservados. 
           <a href="contactenos.php">Contáctanos</a>.</p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>