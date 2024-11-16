<?php

// configuração de credencial
$server = '193.203.175.140';
$usuario = 'u215784649_root';
$senha_banco = 'bE8Fxvb#u*%pceDUL$f';
$banco = 'u215784649_siman';
$porta = 3306;

// conexão com o banco
$conn = new mysqli($server, $usuario, $senha_banco, $banco, $porta);

if ($conn->connect_error) {
    die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
    exit();
}

