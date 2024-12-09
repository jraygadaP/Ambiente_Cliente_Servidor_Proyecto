<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Aguinaldos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .main-card {
            background-color: #b3b3b3;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .info-card {
            background-color: #EED7C5;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 5px solid #9EC4BB;
        }
        .form-control {
            border: 2px solid #CCCCBB;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #9EC4BB;
            box-shadow: 0 0 0 0.2rem rgba(158, 196, 187, 0.25);
        }
        .btn-calculate {
            background-color: #9EC4BB;
            color: #2D2E2C;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-calculate:hover {
            background-color: #7DA099;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .result-card {
            display: none;
            margin-top: 25px;
            background-color: #F8F9FA;
            border-radius: 10px;
            padding: 20px;
            border: 2px solid #9EC4BB;
        }
        .footer {
            text-align: center;
            background-color: #2D2E2C;
            color: #FFFFFF;
            padding: 25px;
            margin-top: 50px;
        }
        h2 {
            color: #2D2E2C;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            position: relative;
            padding-bottom: 15px;
        }
        h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background-color: #9EC4BB;
        }
        .info-text {
            font-size: 0.95em;
            color: #666;
            margin-top: 15px;
            line-height: 1.6;
        }
        .feature-icon {
            font-size: 2rem;
            color: #9EC4BB;
            margin-bottom: 15px;
        }
        .highlight {
            background-color: #F7DECE;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        .example-box {
            background-color: #f8f9fa;
            border-left: 4px solid #9EC4BB;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .result-number {
            font-size: 1.25rem;
            font-weight: bold;
            color: #2D2E2C;
        }
        .input-group-text {
            background-color: #9EC4BB;
            color: white;
            border: none;
        }
        body {
            background-color: #e7e7e7ec;
            color: #2D2E2C;
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="main-card">
            <div class="text-center mb-4">
                <i class="fas fa-money-bill-wave feature-icon"></i>
                <h2>Calculadora de Aguinaldo</h2>
            </div>

            <div class="info-card">
                <h5><i class="fas fa-info-circle"></i> ¿Qué es el aguinaldo?</h5>
                <p>El aguinaldo es un beneficio laboral obligatorio en Costa Rica, equivalente a un mes adicional de salario que se paga en diciembre. Este derecho está establecido en la Ley N° 2412 y representa un treceavo mes de salario para todos los trabajadores.</p>
                
                <div class="example-box">
                    <h6><i class="fas fa-lightbulb"></i> Ejemplo práctico:</h6>
                    <p>Si un trabajador gana ₡400,000 mensuales y ha trabajado todo el año, su aguinaldo sería ₡400,000.</p>
                    <p>Si solo trabajó 6 meses, sería: (₡400,000 × 6) ÷ 12 = ₡200,000</p>
                </div>
            </div>

            <form id="aguinaldoForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Salario Mensual Base:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₡</span>
                                </div>
                                <input type="number" class="form-control" id="salarioBase" required 
                                       placeholder="Ingrese su salario mensual">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-alt"></i> Meses Trabajados:</label>
                            <input type="number" class="form-control" id="mesesTrabajados" 
                                   max="12" min="1" required placeholder="1-12 meses">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-plus-circle"></i> Extras y Comisiones (opcional):</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">₡</span>
                        </div>
                        <input type="number" class="form-control" id="extras" value="0" 
                               placeholder="Ingrese montos adicionales">
                    </div>
                </div>
                <button type="submit" class="btn-calculate">
                    <i class="fas fa-calculator"></i> Calcular Aguinaldo
                </button>
            </form>

            <div class="card result-card" id="resultCard">
                <h4 class="text-center mb-4"><i class="fas fa-chart-line"></i> Resultado del Cálculo</h4>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card p-3 text-center">
                            <h6>Aguinaldo Bruto</h6>
                            <p class="result-number">₡<span id="aguinaldoBruto">0</span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 text-center">
                            <h6>Aguinaldo Proporcional</h6>
                            <p class="result-number">₡<span id="aguinaldoProporcional">0</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h5><i class="fas fa-exclamation-circle"></i> Información Importante</h5>
                <ul class="info-text">
                    <li>El aguinaldo no está sujeto a deducciones de la CCSS ni del impuesto sobre la renta.</li>
                    <li>Debe pagarse dentro de los primeros 20 días de diciembre.</li>
                    <li>Se calcula con base en el promedio de salarios ordinarios y extraordinarios.</li>
                    <li>Los cálculos son aproximados y pueden variar según situaciones específicas.</li>
                </ul>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('aguinaldoForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir el envío del formulario
            
            const salarioBase = parseFloat(document.getElementById('salarioBase').value);
            const mesesTrabajados = parseFloat(document.getElementById('mesesTrabajados').value);
            const extras = parseFloat(document.getElementById('extras').value) || 0;

            const salarioTotal = salarioBase + extras;
            const aguinaldoBruto = salarioTotal;
            const aguinaldoProporcional = (aguinaldoBruto / 12) * mesesTrabajados;

            document.getElementById('aguinaldoBruto').textContent = aguinaldoBruto.toLocaleString('es-CR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('aguinaldoProporcional').textContent = aguinaldoProporcional.toLocaleString('es-CR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            document.getElementById('resultCard').style.display = 'block';
        });
    </script>
</body>
</html>