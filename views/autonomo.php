<?php

include('../models/protect.php');
include('../models/conexao.php');




// New SQL query for the new list
// New SQL query for the new list
$newSql = "SELECT * FROM sensor_temp ORDER BY id DESC LIMIT 10";
$newStmt = $conn->prepare($newSql);
$newStmt->execute();
$newResultS = $newStmt->get_result();

// Recuperar a última leitura de temperatura e o nome do sensor da tabela sensor_temp
$lastTempSql = "SELECT Temperatura, sensor_id FROM sensor_temp ORDER BY id DESC LIMIT 1";
$lastTempStmt = $conn->prepare($lastTempSql);
$lastTempStmt->execute();
$lastTempResult = $lastTempStmt->get_result();
$lastTempRow = $lastTempResult->fetch_assoc();
$lastTemp = $lastTempRow['Temperatura'] ?? 0; // Caso não tenha leitura, usar 0 como padrão
$lastSensorName = $lastTempRow['sensor_id'] ?? 'Sensor Desconhecido'; // Caso não tenha sensor, usar um nome padrão


$sensor_id = $_GET['sensor_id'] ?? '';

if ($sensor_id) {
    $stmt = $conn->prepare("SELECT Temperatura FROM sensor_temp WHERE sensor_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param('s', $sensor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $temperature = $result->fetch_assoc()['Temperatura'] ?? 0;

    echo json_encode(['temperature' => $temperature]);
} else {
    echo json_encode(['temperature' => 0]);
}

// Critérios de busca
$searchManutentor = $_GET['searchManutentor'] ?? '';
$searchSetor = $_GET['searchSetor'] ?? '';
$searchMaquina = $_GET['searchMaquina'] ?? '';
$searchData = $_GET['searchData'] ?? '';

// Consulta SQL com múltiplos critérios de busca
$sql = "SELECT * FROM ordem_os WHERE searchtipo_os <> 'manual'";

if (!empty($searchManutentor)) {
    $sql .= " AND manutentor_os LIKE ?";
}
if (!empty($searchSetor)) {
    $sql .= " AND setor_os LIKE ?";
}
if (!empty($searchMaquina)) {
    $sql .= " AND maquina_os LIKE ?";
}
if (!empty($searchData)) {
    $sql .= " AND data = ?";
}

// Adiciona o limite ao SQL
$sql .= " LIMIT ?";

$stmt = $conn->prepare($sql);

$types = '';
$values = [];

if (!empty($searchManutentor)) {
    $types .= 's';
    $values[] = "%$searchManutentor%";
}
if (!empty($searchSetor)) {
    $types .= 's';
    $values[] = "%$searchSetor%";
}
if (!empty($searchMaquina)) {
    $types .= 's';
    $values[] = "%$searchMaquina%";
}
if (!empty($searchData)) {
    $types .= 's';
    $values[] = $searchData;
}

// Define o tipo de dado para o limite (integer)
$types .= 'i';
$values[] = 10;  // Exemplo de limite fixo de 10

// Ligação dos parâmetros
$stmt->bind_param($types, ...$values);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/autonoma.css">
    <style>

.order-container {
    background-color: #f5f5f5;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    width:45%;
    margin: 20px auto;
    position: absolute;
    left: 75%;
    transform: translate(-50%, -50%);
    z-index: 1; /* Garante que a primeira lista fique sobreposta */
    
}


.order-container-sensor {
    background-color: #f5f5f5;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    width: 45%;
    margin: 20px auto;
    position: absolute;
    left: 75%;
    transform: translate(-50%, -50%);
    z-index: 1; /* Garante que a primeira lista fique sobreposta */
}


/* Específico para a primeira lista */
.order-container {
    top: 55%; /* Ajustado para aparecer na parte superior */
}

/* Específico para a segunda lista */
.order-container-sensor {
    top: 70%; /* Ajustado para aparecer logo abaixo da primeira lista */
    z-index: 0; /* Mantém a segunda lista abaixo da primeira */
}

.order-items {
    padding: 20px;
    margin: 20px auto;
    text-align: center;
}

.order-container table, .order-container-sensor table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    font-size: 14px;
}

.order-container th, .order-container td, 
.order-container-sensor th, .order-container-sensor td {
    padding: 10px;
    text-align: left;
}

.order-container th, .order-container-sensor th {
    background-color: #007bff;
    color: #ffffff;
}

.order-container tr:hover, .order-container-sensor tr:hover {
    background-color: #f5f5f5;
}

.order-container tr:nth-child(even), .order-container-sensor tr:nth-child(even) {
    background-color: #f9f9f9;
}

.order-container tr:nth-child(odd), .order-container-sensor tr:nth-child(odd) {
    background-color: #ffffff;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    table {
        font-size: 12px;
    }
    th, td {
        padding: 5px;
    }
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    table {
        font-size: 12px;
    }
    th, td {
        padding: 5px;
    }
}
</style>
</head>
<body>
    <header>
        <div class="container-back">
            <div class="container-top">
                <li class="drop-hover">
                    <img src="../icon/avatar.png" alt="Foto de Perfil" class="avatar">
                    <div class="drop">
                        <a href="#"><?php echo $_SESSION['nome']; ?></a>
                        <a href="#">Conta</a>
                        <a href="#">Dados da Empresa</a>
                        <a href="sac.html">Sac</a>
                    </div>
                    <a href="../models/logout.php">
                        <img src="../icon/log-out.svg" alt="Out" class="out">
                    </a>
                </li>                   
            </div>  

            <div class="container-home">
            <div class="content-home first-content-home">
                <div class="btn-expandir">  

                </div>
                <ul> 
                    <li class="item-menu">
                        <a href="home.php">
                            <span class="icon"><i class="bi bi-house-fill"></i></span>
                            <span class="txt-link">Início</span>
                        </a>
                    </li>                  
                    <li class="item-menu">
                        <a href="minha_area.php">
                            <span class="icon"><i class="bi bi-person-fill"></i></span>
                            <span class="txt-link">Minha Área</span>
                        </a>
                    </li>
                    <li class="item-menu">
                        <a href="cadastrar_os.php">
                            <span class="icon"><i class="bi bi-file-earmark-plus-fill"></i></span>
                            <span class="txt-link">Nova Ordem</span>
                        </a>
                    </li>                 
                    <li class="item-menu">
                        <a href="pesquisa.php">
                            <span class="icon"><i class="bi bi-search"></i></span>
                            <span class="txt-link">Pesquisar </span>
                        </a>
                    </li>
                    <li class="item-menu">
                        <a href="estoque.php">
                            <span class="icon"><i class="bi bi-box-seam-fill"></i></span>
                            <span class="txt-link">Estoque</span>
                        </a>
                    </li>
                    <li class="item-menu">
                        <a href="autonomo.php">
                            <span class="icon"><i class="bi bi-thermometer-half"></i></span>
                            <span class="txt-link">Autonomo</span>
                        </a>
                    </li>
                    <li class="item-menu">
                        <a href="cadastro.php">
                            <span class="icon"><i class="bi bi-building-add"></i></span>
                            <span class="txt-link">Nova Máquina</span>
                        </a>
                    </li>     
                </ul>
            </div>
        </div>
        <div class="sensor-selector">
            <label for="sensorSelect">Selecione o Sensor:</label>
            <select id="sensorSelect">
                <?php
                // Consulta para obter a lista de sensores disponíveis
                $sensorSql = "SELECT DISTINCT sensor_id FROM sensor_temp";
                $sensorStmt = $conn->prepare($sensorSql);
                $sensorStmt->execute();
                $sensorResult = $sensorStmt->get_result();

                while ($sensorRow = $sensorResult->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($sensorRow['sensor_id']) . '">' . htmlspecialchars($sensorRow['sensor_id']) . '</option>';
                }
                ?>
            </select>
        </div>

        <div id="chart_div" style="width: 400px; height: 120px;"></div>
        <div class="order-container">
            <table>
                <thead>
                    <tr>
                        <th>Número da Ordem</th>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Máquina</th>
                        <th>Setor</th>
                        <th>Manutentor</th>
                        <th>Data</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['numero_os']); ?></td>
                                <td><?php echo htmlspecialchars($row['tipo_os']); ?></td>
                                <td><?php echo htmlspecialchars($row['descricao_os']); ?></td>
                                <td><?php echo htmlspecialchars($row['maquina_os']); ?></td>
                                <td><?php echo htmlspecialchars($row['setor_os']); ?></td>
                                <td><?php echo htmlspecialchars($row['manutentor_os']); ?></td>
                                <td><?php echo htmlspecialchars($row['data']); ?></td>
                                <td><?php echo htmlspecialchars($row['hora']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">Nenhuma ordem encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="order-container-sensor">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Sensor</th>
                        <th>Temperatura</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Local</th>
                        <th>Maquina</th>
                        <th>Unit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($newResultS->num_rows > 0): ?>
                        <?php while ($newRow = $newResultS->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($newRow['id']); ?></td>
                                <td><?php echo htmlspecialchars($newRow['sensor_id']); ?></td>
                                <td><?php echo htmlspecialchars($newRow['Temperatura']); ?></td>
                                <td><?php echo htmlspecialchars($newRow['data']); ?></td>
                                <td><?php echo htmlspecialchars($newRow['hora']); ?></td>
                                <td><?php echo htmlspecialchars($newRow['location']); ?></td>
                                <td><?php echo htmlspecialchars($newRow['maquina']); ?></td>
                                <td><?php echo htmlspecialchars($newRow['unit']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">Nenhuma temperatura encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
                              
    </div>    
</header>
<main>
  
</main>
<footer>
    <!-- Your footer content here -->
</footer>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/app.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['gauge']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var lastTemp = <?php echo $lastTemp; ?>; // Passando a última temperatura do PHP para o JavaScript
        var sensorName = "<?php echo $lastSensorName; ?>"; // Passando o nome do sensor do PHP para o JavaScript

        var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            [sensorName, lastTemp], // Usando o nome do sensor e a última leitura de temperatura
        ]);

        var options = {
            greenFrom: 0, greenTo: 50,
            width: 400, height: 120,
            redFrom: 75, redTo: 100,
            yellowFrom:65, yellowTo: 74,
            minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);
    }
    
</script>
