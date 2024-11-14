<?php
include('../models/conexao.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if ($conn) {
        $query = "UPDATE notificacao SET status = 'X' WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo 'error: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            echo 'error: ' . $conn->error;
        }
    } else {
        echo 'error: unable to connect to database';
    }
} else {
    echo 'error: invalid request method';
}
?>