<?php

include('../models/protect.php');

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/estoque.css">
    <style>
        .countdown {
            display: flex;
            justify-content: center;
            gap: 20px;
            font-family: Arial, sans-serif;
            color: rgb(255, 255, 255);
        }

        .countdown div {
            text-align: center;
        }

        .countdown .number {
            font-size: 48px;
            font-weight: bold;
        }

        .countdown .label {
            font-size: 18px;
            text-transform: uppercase;
        }
        .avatar{
            align-self: center;
            cursor:pointer;
            width: 50px;
            position: absolute;
            top:5px;
            right:100px ;
            filter: drop-shadow(4px 4px 4px rgba(0,0,0,0.90));
        }
        .out{
            width: 40px;
            position: absolute;
            top:10px;
            align-self: center;
            right:30px ;
        }

        .back {
            width: 50px;
            height: 50px;
            position: absolute;
            top: 10px;
            align-self: center;
            left: 20px;
            object-fit: contain;
        }
        .drop {
            display: none;
            position: absolute;
            background-color: #202020;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            right: 100px;
            top: 60px;
        }
        .drop a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .drop a:hover {
            background-color: #58af9b;
        }
        .container-top{
            background-color: #090c0b;
            padding: 50px;
        }
        .modal {
            background-color: #459a87;
            width: 500px;
            padding: 30px;
            border-radius: 8px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            color: white;
            text-align: center;
        }
        .modal form div {
            margin-bottom: 15px;
        }
        .modal input[type="text"],
        .modal input[type="file"],
        .modal input[type="date"] {
            width: calc(100% - 20px);
            padding: 8px;
            border-radius: 4px;
            border: none;
        }
        .modal button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .modal button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <div class="container-top"></div>
        <div class="container">
            <header>
                <img src="../icon/avatar.png" alt="Foto de Perfil" class="avatar">    
                <a href="../models/logout.php">
                    <img src="../icon/log-out.svg" alt="Out" class="out">
                </a> 
                <a href="../models/home.php">
                    <img src="../icon/back.svg" alt="back" class="back">
                </a>                                            
            </header>
        </div>
        <div class="container-back">
            <div class="container-home">
                <div class="content-home first-content-home">
                    <div class="btn-expandir"></div>
                    <ul> 
                        <li class="item-menu">
                            <a href="home.php">
                                <span class="icon"><i class="bi bi-house-fill"></i></span>
                                <span class="txt-link">Início</span>
                            </a>
                        </li>                  
                        <li class="item-menu">
                            <a href="minha_area.php">
                                <span class="icon"><i class="bi bi-person-fill"></i></span>
                                <span class="txt-link">Minha Área</span>
                            </a>
                        </li>
                        <li class="item-menu">
                            <a href="cadastrar_os.php">
                                <span class="icon"><i class="bi bi-file-earmark-plus-fill"></i></span>
                                <span class="txt-link">Nova Ordem</span>
                            </a>
                        </li>                 
                        <li class="item-menu">
                            <a href="pesquisa.php">
                                <span class="icon"><i class="bi bi-search"></i></span>
                                <span class="txt-link">Pesquisar </span>
                            </a>
                        </li>
                        <li class="item-menu">
                            <a href="estoque.php">
                                <span class="icon"><i class="bi bi-box-seam-fill"></i></span>
                                <span class="txt-link">Estoque</span>
                            </a>
                        </li>
                        <li class="item-menu">
                            <a href="autonomo.php">
                                <span class="icon"><i class="bi bi-thermometer-half"></i></span>
                                <span class="txt-link">Autonomo</span>
                            </a>
                        </li>
                        <li class="item-menu">
                            <a href="cadastro.php">
                                <span class="icon"><i class="bi bi-building-add"></i></span>
                                <span class="txt-link">Nova Máquina</span>
                            </a>
                        </li>     
                    </ul>
                </div>
            </div>
        </div>    
    </header>
    <main>
        <div class="modal">
            <h2>CADASTRAR LEMBRES</h2>
            <form>
                <div>
                    <label for="titulo">TÍTULO:</label>
                    <input type="text" id="titulo" name="titulo">
                </div>
                <div>
                    <label for="mensagem">Mensagem:</label>
                    <input type="text" id="mensagem" name="mensagem">
                </div>
                <div>
                    <label for="imagem">Carregar imagem:</label>
                    <input type="file" id="imagem" name="imagem">
                </div>
                <div>
                    <label for="dataExibicao">Data para exibição:</label>
                    <input type="date" id="dataExibicao" name="dataExibicao">
                </div>
                <div>
                    <label for="dataFinalizacao">Data Finalizar exibição:</label>
                    <input type="date" id="dataFinalizacao" name="dataFinalizacao">
                </div>
                <div>
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <!-- Your footer content here -->
    </footer>
</body>
</html>