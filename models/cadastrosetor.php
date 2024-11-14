<?php
// PEGA DADOS CADASTRO
$sectorName = $_POST['sectorName'];
$codSector = $_POST['codSector'];
$data_atual = date('d/m/Y');

// configuração de credencial
$server = 'localhost';
$usuario = 'root';
$senha_banco = '';  // Senha do banco de dados
$banco = 'tcc_sisman';

// conexão com o banco
$conn = new mysqli($server, $usuario, $senha_banco, $banco);

if ($conn->connect_error) {
    die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
}

// Prepara a consulta SQL para inserir os dados
$smtp = $conn->prepare("INSERT INTO setor (nome, codsetor, data) VALUES (?, ?, ?)");
$smtp->bind_param("sss", $sectorName, $codSector, $data_atual);

if ($smtp->execute()) {
    echo "Setor cadastrado com sucesso";
} else {
    echo "Erro ao cadastrar o setor: " . $smtp->error;
}

$smtp->close();
$conn->close();
?>
