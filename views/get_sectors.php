<?php
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

// Consulta SQL para obter setores
$sql = "SELECT codsetor, nome FROM setor";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<option value="'. $row['codsetor'] .'">'. $row['nome'] .'</option>';
    }
} else {
    echo '<option value="">Nenhum setor encontrado</option>';
}

$conn->close();
?>

