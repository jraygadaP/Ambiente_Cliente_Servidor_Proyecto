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
    <title>Comparación de Préstamos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {
            background-color: #e7e7e7ec;
            color: #2D2E2C;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        .title-box {
            background-color: #9EC4BB;
            color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .loan-card {
            background-color: #FFFFFF;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }

        .loan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .loan-card h2 {
            color: #2D2E2C;
            font-size: 1.8rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .loan-details li {
            margin: 0.5rem 0;
            font-size: 1rem;
        }

        .btn-apply {
            background-color: #9EC4BB;
            color: #2D2E2C;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 100%;
            text-align: center;
        }

        .btn-apply:hover {
            background-color: #EED7C5;
        }

        .comparison-table {
            margin-top: 30px;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            margin-top: 40px;
            background-color: #9EC4BB;
            padding: 20px;
            border-radius: 10px;
            color: #FFFFFF;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        }

        .form-section input,
        .form-section select {
            margin-bottom: 15px;
        }

        .chart {
            margin-top: 30px;
            text-align: center;
        }

        .footer {
            text-align: center;
            background-color: #2D2E2C;
            color: #FFFFFF;
            padding: 20px;
            margin-top: 30px;
        }

        .footer p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

<div id="loanCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="loan-card text-center p-4" style="border: 2px solid #9EC4BB; border-radius: 15px;">
                <h2 style="color: #2D2E2C; font-weight: bold; font-size: 1.8rem;">Préstamo A</h2>
                <div class="loan-details mt-3">
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="fas fa-coins fa-3x" style="color: #EED7C5;"></i>
                        <div class="ml-3">
                            <h5>Monto</h5>
                            <p>₡10,000,000</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <i class="fas fa-percent fa-3x" style="color: #9EC4BB;"></i>
                        <div class="ml-3">
                            <h5>Tasa de interés</h5>
                            <p>5% anual</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <i class="fas fa-calendar-alt fa-3x" style="color: #EED7C5;"></i>
                        <div class="ml-3">
                            <h5>Plazo</h5>
                            <p>5 años</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <i class="fas fa-money-bill-wave fa-3x" style="color: #9EC4BB;"></i>
                        <div class="ml-3">
                            <h5>Cuota mensual</h5>
                            <p>₡188,000</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <i class="fas fa-calculator fa-3x" style="color: #EED7C5;"></i>
                        <div class="ml-3">
                            <h5>Costo total</h5>
                            <p>₡11,280,000</p>
                        </div>
                    </div>
                </div>
                <button class="btn-apply mt-4" style="font-size: 1.2rem;">Solicitar Préstamo</button>
            </div>
        </div>
        <!-- Repite para los demás préstamos -->
        <div class="carousel-item">
            <div class="loan-card text-center p-4" style="border: 2px solid #9EC4BB; border-radius: 15px;">
                <h2 style="color: #2D2E2C; font-weight: bold; font-size: 1.8rem;">Préstamo B</h2>
                <div class="loan-details mt-3">
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="fas fa-coins fa-3x" style="color: #EED7C5;"></i>
                        <div class="ml-3">
                            <h5>Monto</h5>
                            <p>₡10,000,000</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <i class="fas fa-percent fa-3x" style="color: #9EC4BB;"></i>
                        <div class="ml-3">
                            <h5>Tasa de interés</h5>
                            <p>4% anual</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <i class="fas fa-calendar-alt fa-3x" style="color: #EED7C5;"></i>
                        <div class="ml-3">
                            <h5>Plazo</h5>
                            <p>3 años</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <i class="fas fa-money-bill-wave fa-3x" style="color: #9EC4BB;"></i>
                        <div class="ml-3">
                            <h5>Cuota mensual</h5>
                            <p>₡295,000</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <i class="fas fa-calculator fa-3x" style="color: #EED7C5;"></i>
                        <div class="ml-3">
                            <h5>Costo total</h5>
                            <p>₡10,620,000</p>
                        </div>
                    </div>
                </div>
                <button class="btn-apply mt-4" style="font-size: 1.2rem;">Solicitar Préstamo</button>
            </div>
        </div>
        <!-- Añade más préstamos aquí -->
    </div>
    <a class="carousel-control-prev" href="#loanCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#loanCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Siguiente</span>
    </a>
</div>



       <div class="comparison-table">
           <h3 class="text-center">Tabla Comparativa de Préstamos</h3>
           <table class="table table-bordered text-center">
               <thead class="thead-light">
                   <tr>
                       <th>Préstamo</th>
                       <th>Monto</th>
                       <th>Tasa de Interés</th>
                       <th>Plazo</th>
                       <th>Cuota Mensual</th>
                       <th>Costo Total</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td>A</td>
                       <td>₡10,000,000</td>
                       <td>5%</td>
                       <td>5 años</td>
                       <td>₡188,000</td>
                       <td>₡11,280,000</td>
                   </tr>
                   <tr>
                       <td>B</td>
                       <td>₡10,000,000</td>
                       <td>4%</td>
                       <td>3 años</td>
                       <td>₡295,000</td>
                       <td>₡10,620,000</td>
                   </tr>
               </tbody>
           </table>
       </div>

       <div class="form-section">
           <h3>Personaliza tu Préstamo</h3>
           <form id="loanForm">
               <div class="form-group">
                   <label for="loanAmount">Monto del Préstamo:</label>
                   <input type="number" class="form-control" id="loanAmount" required>
               </div>
               <div class="form-group">
                   <label for="interestRate">Tasa de Interés (%):</label>
                   <input type="number" step="0.01" class="form-control" id="interestRate" required>
               </div>
               <div class="form-group">
                   <label for="loanTerm">Plazo (años):</label>
                   <select class="form-control" id="loanTerm" required>
                       <option value="1">1</option>
                       <option value="2">2</option>
                       <option value="3">3</option>
                       <option value="4">4</option>
                       <option value="5">5</option>
                   </select>
               </div>
               <button type="submit" class="btn btn-light">Calcular</button>
           </form>
       </div>

       <div class="chart">
           <h3>Distribución de Cuotas</h3>
           <canvas id="loanChart"></canvas>
       </div>
   </div>

   <?php include 'includes/footer.php'; ?>

   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <script>
       let myChart = new Chart(document.getElementById('loanChart').getContext('2d'), {
           type: 'bar',
           data: {
               labels: ['A', 'B'],
               datasets: [{
                   label: 'Cuotas Mensuales',
                   data: [188000, 295000],
                   backgroundColor: ['#9EC4BB', '#EED7C5']
               }]
           },
           options: {
               responsive: true,
               scales: {
                   y: {
                       beginAtZero: true
                   }
               }
           }
       });

       function updateChart(nuevaCuota) {
           myChart.data.labels = ['Préstamo Calculado'];
           myChart.data.datasets[0].data = [nuevaCuota];
           myChart.update();
       }

       document.getElementById('loanForm').addEventListener('submit', function(e) {
           e.preventDefault();
           
           const monto = parseFloat(document.getElementById('loanAmount').value);
           const tasaAnual = parseFloat(document.getElementById('interestRate').value);
           const plazo = parseInt(document.getElementById('loanTerm').value);

           const tasaMensual = (tasaAnual / 100) / 12;
           const numeroPagos = plazo * 12;
           const cuotaMensual = monto * (tasaMensual * Math.pow(1 + tasaMensual, numeroPagos)) 
                               / (Math.pow(1 + tasaMensual, numeroPagos) - 1);

           updateChart(cuotaMensual);
       });
   </script>

<script>
    // Función para mostrar el mensaje
    function showLoanMessage() {
        alert("Gracias por seleccionar el préstamo, se le enviará más información a su correo electrónico.");
    }

    // Seleccionar los botones y agregar el evento click
    document.querySelectorAll('.btn-apply').forEach(button => {
        button.addEventListener('click', showLoanMessage);
    });
</script>

</body>
</html>