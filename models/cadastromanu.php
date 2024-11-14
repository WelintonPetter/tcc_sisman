<?php

include('../models/conexao.php');
// Obtém dados do formulário
$maintainerName = $_POST['maintainerName'];
$profisionName = $_POST['profisionName'];
$sectorJob = $_POST['sectorJob'];
$data_atual = date('d/m/Y');



// Consulta para buscar o último código de funcionário
$sql = "SELECT MAX(codfuncionario) AS ultimo_codigo FROM manutentor";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Incrementa o código do funcionário
$maintainerCod = isset($row['ultimo_codigo']) ? $row['ultimo_codigo'] + 1 : 1;

// Prepara a consulta SQL para inserir os dados
$sql = "INSERT INTO manutentor (nome, codfuncionario, profissao, setortranalho, data) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisss", $maintainerName, $maintainerCod, $profisionName, $sectorJob, $data_atual);

if ($stmt->execute()) {
    echo "Manutentor cadastrado com sucesso";
} else {
    echo "Erro ao cadastrar o manutentor: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
