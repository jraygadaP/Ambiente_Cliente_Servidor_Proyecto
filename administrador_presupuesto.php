<?php
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

// Conexión a la base de datos utilizando la clase Database
$conn = Database::getInstance()->getConnection();

// Evitar que se envíen salidas antes de las cabeceras
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Presupuesto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color:#e7e7e7ec; color: #2D2E2C; font-family: 'Arial', sans-serif; }
        .container { margin-top: 30px; }
        .title-box { background-color: #9EC4BB; color: #FFFFFF; padding: 20px; border-radius: 10px; text-align: center; }
        .card { background-color: #FFFFFF; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .footer { text-align: center; background-color: #2D2E2C; color: #FFFFFF; padding: 20px; }
        .total-box {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .box-item {
        padding: 20px;
        margin-bottom: 10px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .box-item h4 {
        margin-top: 10px;
        font-weight: bold;
        font-size: 18px;
    }

    .box-item p.amount {
        font-size: 24px;
        font-weight: bold;
        margin-top: 5px;
    }

    /* Estilo para la caja de ingresos */
    .ingresos {
        background: linear-gradient(135deg, #32CD32, #6DD3B3);
        color: #ffffff;
    }

    .ingresos i {
        color: #ffffff;
    }

    /* Estilo para la caja de gastos */
    .gastos {
        background: linear-gradient(135deg, #FF6347, #FFBABA);
        color: #ffffff;
    }

    .gastos i {
        color: #ffffff;
    }

    /* Estilo para la caja de monto final */
    .final {
        background: linear-gradient(135deg, #2D2E2C, #666666);
        color: #ffffff;
    }

    .final i {
        color: #ffffff;
    }

    /* Animación de hover para resaltar los totales */
    .box-item:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
    </style>
</head>
<body>
   <div class="container">
       <div class="title-box">
           <h2>Administración de Presupuesto</h2>
           <p>Gestiona tus ingresos, controla tus gastos y alcanza tus metas financieras</p>
       </div>

       <div class="row">
           <div class="col-md-6">
               <div class="card">
                   <h4>Registrar Ingreso</h4>
                   <form action="" method="POST">
                       <div class="form-group">
                           <label for="incomeAmount">Monto</label>
                           <input type="number" name="income" class="form-control" required>
                       </div>
                       <div class="form-group">
                           <label for="incomeDescription">Descripción</label>
                           <input type="text" name="income_description" class="form-control" required>
                       </div>
                       <button type="submit" name="add_income" class="btn btn-success">Agregar Ingreso</button>
                   </form>
               </div>
           </div>
           <div class="col-md-6">
               <div class="card">
                   <h4>Registrar Gasto</h4>
                   <form action="" method="POST">
                       <div class="form-group">
                           <label for="expenseAmount">Monto</label>
                           <input type="number" name="expense" class="form-control" required>
                       </div>
                       <div class="form-group">
                           <label for="expenseDescription">Descripción</label>
                           <input type="text" name="expense_description" class="form-control" required>
                       </div>
                       <button type="submit" name="add_expense" class="btn btn-danger">Agregar Gasto</button>
                   </form>
               </div>
           </div>
       </div>

       <div class="row mt-4">
           <div class="col-md-12">
               <div class="card">
                   <h4>Historial de Transacciones</h4>
                   <table class="table table-striped">
                       <thead>
                           <tr>
                               <th>ID</th>
                               <th>Ingreso</th>
                               <th>Descripción de Ingreso</th>
                               <th>Gastos</th>
                               <th>Descripción de Gasto</th>
                               <th>Acciones</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php
                           $query = "SELECT * FROM presupuesto";
                           $stmt = $conn->query($query);
                           while ($row = $stmt->fetch_assoc()) {
                               echo "<tr>";
                               echo "<td>" . $row['ID_Presupuesto'] . "</td>";
                               echo "<td>" . $row['Ingreso'] . "</td>";
                               echo "<td>" . $row['Descripcion_Ingreso'] . "</td>";
                               echo "<td>" . $row['Gastos'] . "</td>";
                               echo "<td>" . $row['Descripcion_Gasto'] . "</td>";
                               echo "<td><a href='delete.php?id=" . $row['ID_Presupuesto'] . "' class='btn btn-danger btn-sm'>Eliminar</a></td>";
                               echo "</tr>";
                           }
                           ?>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>

   <?php
   if (isset($_POST['add_income'])) {
       $income = $_POST['income'];
       $income_description = $_POST['income_description'];
       $query = "INSERT INTO presupuesto (ID_Usuario, Ingreso, Descripcion_Ingreso, Gastos, Descripcion_Gasto) VALUES (1, ?, ?, 0, '')";
       $stmt = $conn->prepare($query);
       $stmt->bind_param("ds", $income, $income_description);
       $stmt->execute();
       header("Location: " . $_SERVER['PHP_SELF']);
       exit();
   }

   if (isset($_POST['add_expense'])) {
       $expense = $_POST['expense'];
       $expense_description = $_POST['expense_description'];
       $query = "INSERT INTO presupuesto (ID_Usuario, Ingreso, Descripcion_Ingreso, Gastos, Descripcion_Gasto) VALUES (1, 0, '', ?, ?)";
       $stmt = $conn->prepare($query);
       $stmt->bind_param("ds", $expense, $expense_description);
       $stmt->execute();
       header("Location: " . $_SERVER['PHP_SELF']);
       exit();
   }
   ?>

<?php
       // Calcular los totales
       $query_totals = "SELECT 
                           SUM(Ingreso) AS total_ingresos, 
                           SUM(Gastos) AS total_gastos 
                        FROM presupuesto";
       $result_totals = $conn->query($query_totals);
       $totals = $result_totals->fetch_assoc();

       $total_ingresos = $totals['total_ingresos'] ?? 0;
       $total_gastos = $totals['total_gastos'] ?? 0;
       $monto_final = $total_ingresos - $total_gastos;
       ?>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="total-box p-4">
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="box-item ingresos">
                        <i class="fas fa-wallet fa-2x"></i>
                        <h4>Total de Ingresos</h4>
                        <p class="amount">₡<?php echo number_format($total_ingresos, 2); ?></p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="box-item gastos">
                        <i class="fas fa-chart-line fa-2x"></i>
                        <h4>Total de Gastos</h4>
                        <p class="amount">₡<?php echo number_format($total_gastos, 2); ?></p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="box-item final">
                        <i class="fas fa-balance-scale fa-2x"></i>
                        <h4>Monto Final</h4>
                        <p class="amount">₡<?php echo number_format($monto_final, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


