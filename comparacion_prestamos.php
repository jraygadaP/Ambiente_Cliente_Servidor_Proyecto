<?php
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/header.php';

// Conexión a la base de datos utilizando la clase Database
$db = Database::getInstance();
$conexion = $db->getConnection();

// Consultar los préstamos desde la base de datos
$prestamos = [];
try {
    $stmt = $conexion->query("SELECT * FROM prestamos");
    $prestamos = $stmt->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Error al consultar los préstamos: " . $e->getMessage();
}

// Modificar préstamo si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['loanID'];
    $monto = $_POST['loanAmount'];
    $tasa = $_POST['interestRate'];
    $plazo = $_POST['loanTerm'];

    $cuota = $monto * ($tasa / 100 / 12) / (1 - pow(1 + $tasa / 100 / 12, -$plazo * 12));
    $costoTotal = $cuota * $plazo * 12;

    try {
        $stmt = $conexion->prepare("UPDATE prestamos SET Monto = ?, Tasa_de_Interes = ?, Plazo = ?, Cuota = ?, Costo = ? WHERE ID_Prestamo = ?");
        $stmt->bind_param("ddiddi", $monto, $tasa, $plazo, $cuota, $costoTotal, $id);
        $stmt->execute();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $e) {
        echo "Error al modificar el préstamo: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparación de Préstamos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
/* Estilo general */
body { background-color:#e7e7e7ec; color: #2D2E2C; font-family: 'Arial', sans-serif; }

/* Estilo del carrusel */
#loanCarousel .loan-card {
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
#loanCarousel .loan-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Botón de solicitar préstamo */
.btn-apply {
    background-color: #28a745;
    color: #ffffff;
    border-radius: 30px;
    padding: 10px 20px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
}
.btn-apply:hover {
    background-color: #218838;
    transform: scale(1.1);
}

/* Estilo de la tabla comparativa */
.table {
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}
.table th, .table td {
    text-align: center;
    vertical-align: middle;
}
.table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Estilo del formulario */
.form-section {
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 8px;
}
.form-section h3 {
    text-align: center;
    margin-bottom: 20px;
    color: #007bff;
}
.form-section .form-group label {
    font-weight: bold;
    color: #495057;
}
.form-section .btn-primary {
    background-color: #007bff;
    border: none;
    border-radius: 30px;
    padding: 10px 20px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
}
.form-section .btn-primary:hover {
    background-color: #0056b3;
    transform: scale(1.1);
}

.explanation-box {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    font-size: 16px;
    line-height: 1.5;
}

/* Estilo para la caja de comparación */
.comparison-box {
    background-color: #ffffff;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    font-size: 16px;
    line-height: 1.6;
}

.comparison-box h4 {
    text-align: center;
    color: #007bff;
    font-weight: bold;
    margin-bottom: 15px;
}

.comparison-box ul {
    list-style: none;
    padding: 0;
}

.comparison-box ul li {
    background-color: #f9f9f9;
    margin-bottom: 10px;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    position: relative;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.comparison-box ul li:hover {
    background-color: #e7f3ff;
    transform: translateY(-2px);
}

.comparison-box strong {
    display: block;
    margin-top: 20px;
    font-size: 18px;
    color:rgb(133, 172, 163);
    text-align: center;
    font-weight: bold;
}

/* Responsividad */
@media (max-width: 768px) {
    #loanCarousel .loan-card {
        padding: 15px;
    }
    .form-section {
        padding: 15px;
    }
}
</style>

</head>

<body>
<div class="container mt-5">

    <!-- Carrusel de préstamos -->
    <div id="loanCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($prestamos as $index => $prestamo): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="loan-card text-center p-4" style="border: 2px solid #9EC4BB; border-radius: 15px;">
                        <h2>Préstamo ID <?= htmlspecialchars($prestamo['ID_Prestamo']) ?></h2>
                        <p>Monto: ₡<?= number_format($prestamo['Monto'], 2) ?></p>
                        <p>Tasa de interés: <?= htmlspecialchars($prestamo['Tasa_de_Interes']) ?>% anual</p>
                        <p>Plazo: <?= htmlspecialchars($prestamo['Plazo']) ?> años</p>
                        <p>Cuota mensual: ₡<?= number_format($prestamo['Cuota'], 2) ?></p>
                        <p>Costo total: ₡<?= number_format($prestamo['Costo'], 2) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tabla Comparativa de Préstamos -->
    <div class="comparison-table mt-5">
        <h3>Tabla Comparativa de Préstamos</h3>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID Préstamo</th>
                    <th>Monto</th>
                    <th>Tasa de Interés</th>
                    <th>Plazo</th>
                    <th>Cuota Mensual</th>
                    <th>Costo Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prestamos as $prestamo): ?>
                    <tr>
                        <td><?= htmlspecialchars($prestamo['ID_Prestamo']) ?></td>
                        <td>₡<?= number_format($prestamo['Monto'], 2) ?></td>
                        <td><?= htmlspecialchars($prestamo['Tasa_de_Interes']) ?>%</td>
                        <td><?= htmlspecialchars($prestamo['Plazo']) ?> años</td>
                        <td>₡<?= number_format($prestamo['Cuota'], 2) ?></td>
                        <td>₡<?= number_format($prestamo['Costo'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Explicación del TIN -->
    <div class="explanation-box">
        <h4>¿Qué es la TIN (Tasa de Interés Nominal)?</h4>
        <p>La Tasa de Interés Nominal (TIN) es la tasa que se aplica al monto inicial de un préstamo para calcular los intereses. Se expresa como un porcentaje anual, pero no tiene en cuenta los costos adicionales, como comisiones o gastos de apertura.</p>
    </div>

    <!-- Comparación de préstamos -->
    <div class="comparison-box">
        <h4>Comparación entre Préstamos</h4>
        <ul>
            <?php 
                $mejorPrestamo = null;
                foreach ($prestamos as $prestamo) {
                    $monto = $prestamo['Monto'];
                    $tasa = $prestamo['Tasa_de_Interes'];
                    $plazo = $prestamo['Plazo'];
                    $cuota = $prestamo['Cuota'];
                    $costoTotal = $prestamo['Costo'];
                    
                    $mensaje = "El préstamo con ID {$prestamo['ID_Prestamo']} tiene una tasa de interés de {$tasa}%, 
                    con un monto de ₡" . number_format($monto, 2) . 
                    ", una cuota mensual de ₡" . number_format($cuota, 2) . 
                    " y un costo total de ₡" . number_format($costoTotal, 2) . ".";
                    
                    echo "<li>$mensaje</li>";

                    if (is_null($mejorPrestamo) || $costoTotal < $mejorPrestamo['Costo']) {
                        $mejorPrestamo = $prestamo;
                    }
                }
                
                if ($mejorPrestamo) {
                    echo "<br><strong>El mejor préstamo es el de ID {$mejorPrestamo['ID_Prestamo']} con un costo total de ₡" 
                         . number_format($mejorPrestamo['Costo'], 2) . ".</strong>";
                }
            ?>
        </ul>
    </div>

    <!-- Formulario para modificar préstamos -->
    <div class="form-section mt-5">
        <h3>Modificar Préstamo</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="loanID">ID del Préstamo:</label>
                <select name="loanID" class="form-control" required>
                    <?php foreach ($prestamos as $prestamo): ?>
                        <option value="<?= htmlspecialchars($prestamo['ID_Prestamo']) ?>">ID <?= htmlspecialchars($prestamo['ID_Prestamo']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="loanAmount">Monto del Préstamo:</label>
                <input type="number" name="loanAmount" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="interestRate">Tasa de Interés (%):</label>
                <input type="number" name="interestRate" step="0.01" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="loanTerm">Plazo (años):</label>
                <select name="loanTerm" class="form-control" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Modificar Préstamo</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
        document.querySelectorAll('.btn-apply').forEach(button => {
            button.addEventListener('click', function() {
                alert("Gracias por seleccionar el préstamo, se le enviará más información a su correo electrónico.");
            });
        });
    </script>
</body>
</html>










