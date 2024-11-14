<?php

include('../models/protect.php');
include('../models/conexao.php');


// New SQL query for the new list
$newSql = "SELECT * FROM sensor_temp";
$newStmt = $conn->prepare($newSql);
$newStmt->execute();
$newResult = $newStmt->get_result();

// Display the new list
while ($newRow = $newResult->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($newRow['id']) . "</td>";
    echo "<td>" . htmlspecialchars($newRow['sensor_id']) . "</td>";
    echo "<td>" . htmlspecialchars($newRow['Temperatura']) . "</td>";
    echo "<td>" . htmlspecialchars($newRow['data']) . "</td>";
    echo "<td>" . htmlspecialchars($newRow['hora']) . "</td>";
    echo "<td>" . htmlspecialchars($newRow['location']) . "</td>";
    echo "<td>" . htmlspecialchars($newRow['maquina']) . "</td>";
    echo "<td>" . htmlspecialchars($newRow['unit']) . "</td>";
    echo "</tr>";
}



// Critérios de busca
$searchManutentor = $_GET['searchManutentor'] ?? '';
$searchSetor = $_GET['searchSetor'] ?? '';
$searchMaquina = $_GET['searchMaquina'] ?? '';
$searchData = $_GET['searchData'] ?? '';

// Consulta SQL com múltiplos critérios de busca
$sql = "SELECT * FROM ordem_os WHERE searchtipo_os = 'manual'";

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
                              
    </div>    
</header>
<main>
  
</main>
<footer>
    <!-- Your footer content here -->
</footer>
<script src="js/app.js"></script>
