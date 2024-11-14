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
            height: 50px; /* Adicione altura fixa */
            position: absolute;
            top: 10px;
            align-self: center;
            left: 20px;
            object-fit: contain; /* Isso garante que a imagem mantenha a proporção */
        }
        .drop {
            display: none;
            position: absolute;
            background-color: #202020;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            right: 100px; /* Alinhamento à direita */
            top: 60px; /* Ajuste de acordo com a altura da imagem do avatar */
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
   
       
    </style>
</head>
<body>
    <header>
        <div class="container-top"></div>
        <P></P>
        </div>
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


            <div class="second-sac">
                <h1 class="title title-sac">Estoque</h1>

                <div class="first-column">
                    <img src="../icon/estoque.svg" alt="Animação Fabrica">
                </div>
                <div class="title title-sac">
                    <h2>Em Breve</h2>
                </div>
                <!-- Contagem Regressiva -->
                <div id="countdown" class="countdown">

                    <div>
                        <span id="days" class="number">00</span>
                        <div class="label">dias</div>
                    </div>
                    <div>
                        <span id="hours" class="number">00</span>
                        <div class="label">horas</div>
                    </div>
                    <div>
                        <span id="minutes" class="number">00</span>
                        <div class="label">minutos</div>
                    </div>
                    <div>
                        <span id="seconds" class="number">00</span>
                        <div class="label">segundos</div>
                    </div>
                </div>
            </div>
        </div>
         <div class="container-back">
            
            <div class="container-home">
                <div class="content-home first-content-home">
                    <div class="btn-expandir">  

                    </div>
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
        </div>    
    </header>
    <main>
        <!-- Your main content here -->
    </main>
    <footer>
        <!-- Your footer content here -->
    </footer>
    <script>
        // Defina a data para a contagem regressiva
        var countDownDate = new Date("Nov 23, 2024 00:00:00").getTime();

        // Atualize a contagem regressiva a cada segundo
        var x = setInterval(function() {

            // Pegue a data e a hora de agora
            var now = new Date().getTime();

            // Encontre a diferença entre agora e a data de contagem regressiva
            var distance = countDownDate - now;

            // Calcule o tempo para dias, horas, minutos e segundos
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Exiba o resultado nos elementos com id correspondentes
            document.getElementById("days").innerHTML = days;
            document.getElementById("hours").innerHTML = hours;
            document.getElementById("minutes").innerHTML = minutes;
            document.getElementById("seconds").innerHTML = seconds;

            // Se a contagem terminar, exiba uma mensagem
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRADO";
            }
        }, 1000);
    </script>
    
</body>
</html>
