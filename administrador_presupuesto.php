<?php
require_once 'config/config.php';
require_once 'includes/auth.php';

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
    <title>Administración de Presupuesto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #a5a5a598;
            color: #2D2E2C;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #9EC4BB;
        }
        .navbar a {
            color: #2D2E2C !important;
            font-weight: bold;
        }
        .navbar-brand {
            font-size: 1.5rem;
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
        .card {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 100%;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        .summary-section {
            background-color: #9EC4BB;
            color: #FFFFFF;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-top: 30px;
        }
        .transaction-list,
        .goals-list,
        .tips-list {
            list-style: none;
            padding: 0;
        }
        .transaction-list li,
        .goals-list li,
        .tips-list li {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #CCCCBB;
            padding: 10px 0;
        }
        .footer {
            text-align: center;
            background-color: #2D2E2C;
            color: #FFFFFF;
            padding: 20px;
            margin-top: 30px;
        }
        .card h4 {
            color: #2D2E2C;
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-action {
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
        .btn-action:hover {
            background-color: #EED7C5;
        }
        .summary-section h4 {
            margin-bottom: 10px;
        }
        .expense-list {
            list-style-type: none;
            padding: 0;
        }
        .expense-list li {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #CCCCBB;
        }
    </style>
</head>

<body>
   <?php include 'includes/header.php'; ?>

   <div class="container">
       <div class="title-box">
           <h2>Administración de Presupuesto</h2>
           <p>Gestiona tus ingresos, controla tus gastos y alcanza tus metas financieras</p>
       </div>

       <div class="row">
           <div class="col-md-6">
               <div class="card">
                   <h4>Registrar Ingreso</h4>
                   <form id="incomeForm">
                       <div class="form-group">
                           <label for="incomeAmount">Monto</label>
                           <input type="number" class="form-control" id="incomeAmount" 
                                  placeholder="Ej. 5000" required>
                       </div>
                       <div class="form-group">
                           <label for="incomeCategory">Categoría</label>
                           <select class="form-control" id="incomeCategory" required>
                               <option value="Salario">Salario</option>
                               <option value="Bonos">Bonos</option>
                               <option value="Otros">Otros</option>
                           </select>
                       </div>
                       <button type="submit" class="btn-action">Agregar Ingreso</button>
                   </form>
               </div>
           </div>

           <div class="col-md-6">
               <div class="card">
                   <h4>Registrar Gasto</h4>
                   <form id="expenseForm">
                       <div class="form-group">
                           <label for="expenseAmount">Monto</label>
                           <input type="number" class="form-control" id="expenseAmount" 
                                  placeholder="Ej. 200" required>
                       </div>
                       <div class="form-group">
                           <label for="expenseCategory">Categoría</label>
                           <select class="form-control" id="expenseCategory" required>
                               <option value="Alquiler">Alquiler</option>
                               <option value="Transporte">Transporte</option>
                               <option value="Comida">Comida</option>
                               <option value="Entretenimiento">Entretenimiento</option>
                           </select>
                       </div>
                       <button type="submit" class="btn-action">Agregar Gasto</button>
                   </form>
               </div>
           </div>
       </div>

       <div class="summary-section">
           <h4>Resumen del Presupuesto</h4>
           <div class="row text-center">
               <div class="col-md-4">
                   <div class="card" style="background-color: #02585146; color: #FFFFFF;">
                       <div class="card-body">
                           <h5 class="card-title">Ingresos Totales</h5>
                           <p class="card-text">₡<span id="totalIncome">0</span></p>
                       </div>
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="card" style="background-color: #02585146; color: #FFFFFF;">
                       <div class="card-body">
                           <h5 class="card-title">Gastos Totales</h5>
                           <p class="card-text">₡<span id="totalExpense">0</span></p>
                       </div>
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="card" style="background-color: #02585146; color: #FFFFFF;">
                       <div class="card-body">
                           <h5 class="card-title">Presupuesto Restante</h5>
                           <p class="card-text">₡<span id="remainingBudget">0</span></p>
                       </div>
                   </div>
               </div>
           </div>
       </div>

       <div class="row mt-4">
           <div class="col-md-6">
               <div class="card">
                   <h4>Metas Financieras</h4>
                   <ul class="goals-list">
                       <li><span>Ahorro para Vacaciones:</span> <span>₡3000 / ₡5000</span></li>
                       <li><span>Fondo de Emergencia:</span> <span>₡2000 / ₡10000</span></li>
                       <li><span>Compra de Vehículo:</span> <span>₡15000 / ₡25000</span></li>
                   </ul>
               </div>
           </div>
           <div class="col-md-6">
               <div class="card">
                   <h4>Historial de Transacciones</h4>
                   <ul id="transactionList" class="transaction-list">
                       <!-- Las transacciones se agregarán dinámicamente -->
                   </ul>
               </div>
           </div>
       </div>

       <div class="row mt-4">
           <div class="col-md-12">
               <div class="card">
                   <h4>Consejos Financieros</h4>
                   <ul class="tips-list">
                       <li>Establece un presupuesto mensual y cúmplelo.</li>
                       <li>Ahorra al menos el 20% de tus ingresos mensuales.</li>
                       <li>Evita las deudas de alto interés, como las tarjetas de crédito.</li>
                       <li>Revisa tus gastos regularmente para identificar áreas de mejora.</li>
                   </ul>
               </div>
           </div>
       </div>
   </div>

   <?php include 'includes/footer.php'; ?>

   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <script>
       let totalIngresos = 0;
       let totalGastos = 0;

       document.getElementById('incomeForm').addEventListener('submit', function(e) {
           e.preventDefault();
           const monto = parseFloat(document.getElementById('incomeAmount').value);
           const categoria = document.getElementById('incomeCategory').value;
           
           totalIngresos += monto;
           actualizarResumen();
           agregarTransaccion('Ingreso', categoria, monto);
           this.reset();
       });

       document.getElementById('expenseForm').addEventListener('submit', function(e) {
           e.preventDefault();
           const monto = parseFloat(document.getElementById('expenseAmount').value);
           const categoria = document.getElementById('expenseCategory').value;
           
           totalGastos += monto;
           actualizarResumen();
           agregarTransaccion('Gasto', categoria, monto);
           this.reset();
       });

       function actualizarResumen() {
           document.getElementById('totalIncome').textContent = totalIngresos.toLocaleString('es-CR', {
               minimumFractionDigits: 2,
               maximumFractionDigits: 2
           });
           document.getElementById('totalExpense').textContent = totalGastos.toLocaleString('es-CR', {
               minimumFractionDigits: 2,
               maximumFractionDigits: 2
           });
           document.getElementById('remainingBudget').textContent = (totalIngresos - totalGastos).toLocaleString('es-CR', {
               minimumFractionDigits: 2,
               maximumFractionDigits: 2
           });
       }

       function agregarTransaccion(tipo, categoria, monto) {
           const lista = document.getElementById('transactionList');
           const item = document.createElement('li');
           item.innerHTML = `
               <span>${tipo}: ${categoria}</span>
               <span>${tipo === 'Ingreso' ? '+' : '-'} ₡${monto.toLocaleString('es-CR', {
                   minimumFractionDigits: 2,
                   maximumFractionDigits: 2
               })}</span>
           `;
           lista.insertBefore(item, lista.firstChild);
       }
   </script>
</body>
</html>