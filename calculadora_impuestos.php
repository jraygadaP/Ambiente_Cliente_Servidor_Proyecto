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
    <title>Calculadora de Impuestos - El Financiero</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .main-card {
            background-color: #FFFFFF;
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
        .tax-bracket {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border: 1px solid #9EC4BB;
        }
        .tax-bracket h5 {
            color: #2D2E2C;
            margin-bottom: 20px;
        }
        .tax-row {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        .tax-row:hover {
            background-color: #EED7C5;
        }
        .input-group-text {
            background-color: #9EC4BB;
            color: white;
            border: none;
        }
        .result-number {
            font-size: 1.25rem;
            font-weight: bold;
            color: #2D2E2C;
        }
        .example-box {
            background-color: #f8f9fa;
            border-left: 4px solid #9EC4BB;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        body {
            background-color: #e7e7e7ec;
            color: #2D2E2C;
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="main-card">
            <div class="text-center mb-4">
                <i class="fas fa-percentage feature-icon"></i>
                <h2>Calculadora de Impuesto sobre la Renta</h2>
            </div>

            <div class="info-card">
                <h5><i class="fas fa-info-circle"></i> ¿Qué es el Impuesto sobre la Renta?</h5>
                <p>El impuesto sobre la renta es un tributo que grava los ingresos percibidos por las personas físicas y jurídicas en Costa Rica. Se aplica de manera progresiva, lo que significa que a mayor ingreso, mayor es el porcentaje de impuesto a pagar.</p>
            </div>

            <div class="tax-bracket">
                <h5 class="text-center"><i class="fas fa-table"></i> Rangos de Impuesto 2024</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="tax-row">
                            <i class="fas fa-circle-check text-success"></i> Hasta ₡863,000: <strong>0%</strong>
                        </div>
                        <div class="tax-row">
                            <i class="fas fa-arrow-right text-info"></i> ₡863,001 a ₡1,267,000: <strong>10%</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="tax-row">
                            <i class="fas fa-arrow-right text-warning"></i> ₡1,267,001 a ₡2,223,000: <strong>15%</strong>
                        </div>
                        <div class="tax-row">
                            <i class="fas fa-arrow-trend-up text-danger"></i> Más de ₡2,223,000: <strong>20%</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="example-box">
                <h6><i class="fas fa-lightbulb"></i> Ejemplo práctico:</h6>
                <p>Si su salario mensual es de ₡1,500,000:</p>
                <ul>
                    <li>Primeros ₡863,000: No pagan impuesto (0%)</li>
                    <li>De ₡863,001 a ₡1,267,000 (₡403,999): Paga 10% = ₡40,399.90</li>
                    <li>De ₡1,267,001 a ₡1,500,000 (₡232,999): Paga 15% = ₡34,949.85</li>
                    <li>Total a pagar: ₡75,349.75</li>
                </ul>
            </div>

            <form id="impuestoForm" class="mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-dollar-sign"></i> Salario Bruto Mensual:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₡</span>
                                </div>
                                <input type="number" class="form-control" id="salarioBruto" required 
                                       placeholder="Ingrese su salario mensual">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-minus-circle"></i> Deducciones (CCSS, etc.):</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₡</span>
                                </div>
                                <input type="number" class="form-control" id="deducciones" value="0" 
                                       placeholder="Ingrese deducciones">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-calculate">
                    <i class="fas fa-calculator"></i> Calcular Impuesto
                </button>
            </form>

            <div class="card result-card" id="resultCard">
                <h4 class="text-center mb-4"><i class="fas fa-chart-pie"></i> Resultado del Cálculo</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-3 text-center">
                            <h6><i class="fas fa-coins"></i> Base Imponible</h6>
                            <p class="result-number">₡<span id="baseImponible">0</span></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 text-center">
                            <h6><i class="fas fa-hand-holding-usd"></i> Impuesto a Pagar</h6>
                            <p class="result-number">₡<span id="impuestoPagar">0</span></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 text-center">
                            <h6><i class="fas fa-wallet"></i> Salario Neto</h6>
                            <p class="result-number">₡<span id="salarioNeto">0</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h5><i class="fas fa-exclamation-circle"></i> Información Importante</h5>
                <ul class="info-text">
                    <li>Los cálculos son aproximados y pueden variar según situaciones específicas.</li>
                    <li>El impuesto se calcula de forma escalonada según los rangos establecidos.</li>
                    <li>Las deducciones de la CCSS y otros rubros pueden afectar la base imponible.</li>
                    <li>Se recomienda consultar con un profesional para casos específicos.</li>
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
        document.getElementById('impuestoForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevenir el envío del formulario
            
            const salarioBruto = parseFloat(document.getElementById('salarioBruto').value);
            const deducciones = parseFloat(document.getElementById('deducciones').value) || 0;
            const baseImponible = salarioBruto - deducciones;
            
            let impuesto = 0;
            
            if (baseImponible <= 863000) {
                impuesto = 0;
            } else if (baseImponible <= 1267000) {
                impuesto = (baseImponible - 863000) * 0.10;
            } else if (baseImponible <= 2223000) {
                impuesto = (1267000 - 863000) * 0.10 + (baseImponible - 1267000) * 0.15;
            } else {
                impuesto = (1267000 - 863000) * 0.10 + (2223000 - 1267000) * 0.15 + (baseImponible - 2223000) * 0.20;
            }
    
            const salarioNeto = baseImponible - impuesto;
    
            document.getElementById('baseImponible').textContent = baseImponible.toLocaleString('es-CR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('impuestoPagar').textContent = impuesto.toLocaleString('es-CR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('salarioNeto').textContent = salarioNeto.toLocaleString('es-CR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            document.getElementById('resultCard').style.display = 'block';
        });
    </script>
</body>
</html>