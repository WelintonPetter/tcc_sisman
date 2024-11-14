<?php

// configuração de credencial
$server = 'localhost';
$usuario = 'root';
$senha_banco = '';  // Senha do banco de dados
$banco = 'tcc_sisman';

// conexão com o banco
$conn = new mysqli($server, $usuario, $senha_banco, $banco);

if ($conn->connect_error) {
    die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
    exit();
}

