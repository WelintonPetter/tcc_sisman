<?php

include('protect.php');
include('../models/conexao.php');

// Obtém dados do formulário
$machineName = $_POST['machineName'];
$machineType = $_POST['machineType'];
$manufacturer = $_POST['manufacturer'];
$serialNumber = $_POST['serialNumber'];
$acquisitionDate = $_POST['acquisitionDate'];
$operationStatus = $_POST['operationStatus'];
$criticalityLevel = $_POST['criticalityLevel'];
$sector = $_POST['sector'];
$observations = $_POST['observations'];
$iduser = $_SESSION['nome']; // Certifique-se de que o nome da variável de sessão está correto

$data_atual = date('d/m/Y');



// Definições para validação de imagem
$allowedExtensions = ['jpg', 'jpeg', 'png'];
$maxFileSize = 2 * 1024 * 1024; // 2 MB em bytes

$imagePath = "";
if (isset($_FILES['machinePhoto']) && $_FILES['machinePhoto']['error'] == 0) {
    $imageFile = $_FILES['machinePhoto'];
    $imageExt = strtolower(pathinfo($imageFile['name'], PATHINFO_EXTENSION));
    $imageSize = $imageFile['size'];

    // Validação de extensão
    if (!in_array($imageExt, $allowedExtensions)) {
        die("Tipo de arquivo inválido. Apenas PNG e JPG são permitidos.");
    }

    // Validação de tamanho
    if ($imageSize > $maxFileSize) {
        die("O arquivo é muito grande. O tamanho máximo permitido é 2 MB.");
    }

    // Gera um nome único para o arquivo
    $uniqueImageName = uniqid('machine_', true) . '.' . $imageExt;
    $imagePath = '../arquivos/maquina/' . $uniqueImageName;

    // Move a imagem para o diretório de uploads
    if (!move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
        die("Falha ao fazer upload da imagem.");
    }
}

// Prepara a consulta SQL para inserir os dados
$sql = "INSERT INTO maquina (nome_maquina, tipo_maquina, fabricante, nr_serie, dt_compra, est_operacao, nl_critico, setor, observacao, path,id_usuario,data) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssss", $machineName, $machineType, $manufacturer, $serialNumber, $acquisitionDate, $operationStatus, $criticalityLevel, $sector, $observations, $imagePath,$iduser,$data_atual);

if ($stmt->execute()) {
    echo "Máquina cadastrada com sucesso";
} else {
    echo "Erro ao cadastrar a máquina: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
