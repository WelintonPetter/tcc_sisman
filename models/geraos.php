<?php
include('protect.php');

// Configuração de credenciais
$server = 'localhost';
$usuario = 'root';
$senha_banco = '';  // Senha do banco de dados
$banco = 'tcc_sisman';

// Conexão com o banco de dados
$conn = new mysqli($server, $usuario, $senha_banco, $banco);

if ($conn->connect_error) {
    die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
}

// Consulta para buscar o último número de ordem
$sql = "SELECT MAX(numero_os) AS ultimo_numero FROM ordem_os";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Incrementa o número da ordem
$numeroOs = isset($row['ultimo_numero']) ? $row['ultimo_numero'] + 1 : 1;

// Obtém dados do formulário
$orderTipo = $_POST['orderTipo'];
$orderDescription = $_POST['orderDescription'];
$orderMaquinaId = $_POST['orderMaquina'];
$orderPriority = $_POST['orderPriority'];
$sectorId = $_POST['sector'];
$orderManutentorId = $_POST['orderManutentor'];
$iduser = $_SESSION['nome']; // Certifique-se de que o nome da variável de sessão está correto

$data_atual = date('Y-m-d');
$hora_atual = date('H:i:s');

$statusnoti = 'N';
$status = 'Nao_Atendida';
$tiposearchtipo_os = 'manual';



// Consulta para obter o nome da máquina com base no ID
$sql = "SELECT nome_maquina FROM maquina WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderMaquinaId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$orderMaquina = $row['nome_maquina'];

// Consulta para obter o nome do setor com base no ID
$sql = "SELECT nome FROM setor WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sectorId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$sector = $row['nome'];

// Consulta para obter o nome e o código do manutentor com base no ID
$sql = "SELECT nome, codfuncionario FROM manutentor WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderManutentorId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$orderManutentor = isset($row['nome']) ? $row['nome'] : '';
$matricula_manu = isset($row['codfuncionario']) ? $row['codfuncionario'] : '';

// Certifique-se de que a SQL query e os parâmetros estejam corretos
$sql = "INSERT INTO ordem_os 
        (numero_os, tipo_os, citicidade_os, descricao_os, maquina_os, setor_os, manutentor_os, matricula_manu, criador_os, data, hora, status_os, searchtipo_os) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssssssssss", $numeroOs, $orderTipo, $orderPriority, $orderDescription, $orderMaquina, $sector, $orderManutentor, $matricula_manu, $iduser, $data_atual, $hora_atual, $status, $tiposearchtipo_os);






if ($stmt->execute()) {
    echo "Ordem criada com sucesso";
} else {
    echo "Erro ao criar a ordem: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>