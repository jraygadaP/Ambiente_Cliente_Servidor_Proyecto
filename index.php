<?php
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - El Financiero</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
        
        .user-welcome {
            margin-right: 15px;
            color: #2D2E2C;
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

    <main>
        <div class="hero-section">
            <h1>Bienvenido a El Financiero</h1>
            <p>Tu aliado en la gestión de finanzas personales y empresariales</p>
            <a href="#features" class="btn btn-primary btn-lg mt-4">Explorar Funciones</a>
        </div>

        <div class="container my-5">
            <div class="row text-center" id="features">
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <i class="fas fa-calculator fa-3x mb-3 text-primary"></i>
                        <h4>Calculadoras</h4>
                        <p>Descubre nuestras calculadoras de impuestos, aguinaldos y más.</p>
                        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCalculadora">Ver más</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <i class="fas fa-piggy-bank fa-3x mb-3 text-success"></i>
                        <h4>Presupuestos</h4>
                        <p>Administra tus presupuestos de forma simple y rápida.</p>
                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalPresupuestos">Comenzar</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <i class="fas fa-chart-line fa-3x mb-3 text-info"></i>
                        <h4>Comparación</h4>
                        <p>Compara préstamos y opciones financieras.</p>
                        <button class="btn btn-outline-info" data-toggle="modal" data-target="#modalComparacion">Descubre más</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modalCalculadora">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Calculadoras</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Usa nuestras calculadoras de impuestos, aguinaldos y más para planificar tus finanzas.
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPresupuestos">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Presupuestos</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Administra tus presupuestos, controla tus gastos y ahorra con eficiencia.
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalComparacion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comparación de Préstamos</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Compara tasas de préstamos y encuentra la opción que mejor se adapte a tus necesidades.
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
