<?php
include('../models/conexao.php');
include('../models/protect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados enviados
    $numero_os = $_POST['numero_os'];
    $novo_status = $_POST['status'];

    // Verificar se os dados estão preenchidos
    if (!empty($numero_os) && !empty($novo_status)) {
        // Preparar a consulta SQL para atualizar o status
        $sql = "UPDATE ordem_os SET status_os = ? WHERE numero_os = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Erro na preparação da consulta']);
            exit();
        }

        $stmt->bind_param('ss', $novo_status, $numero_os);

        if ($stmt->execute()) {
            // Sucesso na atualização
            echo json_encode(['success' => true]);
        } else {
            // Falha na execução da consulta
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a ordem']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}

$conn->close();
?>