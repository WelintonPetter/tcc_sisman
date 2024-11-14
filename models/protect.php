<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acesso Negado</title>
        <link rel="stylesheet" href="css/style.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f4f5f7;
                font-family: 'Inter', sans-serif;
                margin: 0;
                padding: 0;
                text-align: center;
            }

            .error-container {
                background-color: #ffffff;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                width: 100%;
            }

            .error-container img {
                width: 100%;
                margin-bottom: 20px;
            }

            .error-container h1 {
                font-size: 1.5rem;
                color: #495057;
                margin-bottom: 20px;
            }

            .error-container p {
                font-size: 1rem;
                color: #6c757d;
                margin-bottom: 30px;
            }

            .error-container a {
                text-decoration: none;
                padding: 12px 20px;
                border-radius: 5px;
                background-color: #007bff;
                color: #ffffff;
                font-size: 1rem;
                transition: background-color 0.3s ease;
            }

            .error-container a:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="error-container">
            <img src="../icon/error.svg" alt="Erro">
            <h1>Você não pode acessar esta página</h1>
            <p>Porque você não está logado.</p>
            <a href="/site/index.php">Entrar</a>
        </div>
    </body>
    </html>
    <?php
    die();
}

?>
