<?php
// Inclua a conexão com o banco de dados
include('../models/protect.php');
include('../models/conexao.php');


// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar dados do formulário
    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];
    $data_inicial = $_POST['dataExibicao'];
    $data_final = $_POST['dataFinalizacao'];
    
    // O nome do usuário será o nome logado, vindo da sessão
    $nomeusuario = $_SESSION['nome'];
    $idusuario = $_SESSION['id'];
    // Processamento da imagem, se houver
    $imagem = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem_nome = $_FILES['imagem']['name'];
        $imagem_tmp = $_FILES['imagem']['tmp_name'];
        $imagem_destino = "../arquivos/avisos/" . $imagem_nome; // Diretório para armazenar a imagem
        move_uploaded_file($imagem_tmp, $imagem_destino); // Move a imagem para o diretório
        $imagem = $imagem_destino;
    }


    // Captura a data e hora atuais
    $data_atual = date('Y-m-d'); // Data no formato YYYY-MM-DD
    $hora_atual = date('H:i:s'); // Hora no formato HH:MM:SS

    
    // Inserir dados na tabela do banco
    $sql = "INSERT INTO lembretes (titulo, mensagem, imagem, data_inicial, data_final, nomeusuario, idusuario, data, hora)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
    // Vincula os parâmetros
    $stmt->bind_param("sssssssss", $titulo, $mensagem, $imagem, $data_inicial, $data_final, $nomeusuario, $idusuario, $data_atual, $hora_atual);

    // Executa a query
    if ($stmt->execute()) {
    echo "Lembrete cadastrado com sucesso!";
    } else {
    echo "Erro ao cadastrar lembrete: " . $stmt->error;
    }

    // Fecha a conexão
    $stmt->close();
    } else {
    echo "Erro na preparação da consulta: " . $conn->error;
    }
}
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
            <h2>CADASTRAR lembretes</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateDates()">
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
                    <input type="file" id="imagem" name="imagem" onchange="previewImage(event)">
                    <br>
                    <img id="preview" src="#" alt="Pré-visualização" style="display:none; width: 200px; margin-top: 10px;"/>
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
<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0]; // Obtém o primeiro arquivo selecionado
        
        if (file) {
            const reader = new FileReader(); // Cria um FileReader para ler o arquivo
            reader.onload = function(e) {
                preview.src = e.target.result; // Define a imagem da pré-visualização
                preview.style.display = 'block'; // Exibe a imagem
            };
            reader.readAsDataURL(file); // Lê o arquivo como URL de dados
        }
    }
    function validateDates() {
        const dataExibicao = document.getElementById('dataExibicao').value;
        const dataFinalizacao = document.getElementById('dataFinalizacao').value;

        // Verificar se as datas foram preenchidas
        if (dataExibicao && dataFinalizacao) {
            // Converter as datas para objetos Date
            const dateExibicao = new Date(dataExibicao);
            const dateFinalizacao = new Date(dataFinalizacao);

            // Comparar as datas
            if (dateExibicao >= dateFinalizacao) {
                alert("A data de exibição não pode ser maior ou igual à data de finalização.");
                return false; // Impede o envio do formulário
            }
        }
        return true; // Permite o envio do formulário se as datas forem válidas
    }

    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0]; // Obtém o primeiro arquivo selecionado
        
        if (file) {
            const reader = new FileReader(); // Cria um FileReader para ler o arquivo
            reader.onload = function(e) {
                preview.src = e.target.result; // Define a imagem da pré-visualização
                preview.style.display = 'block'; // Exibe a imagem
            };
            reader.readAsDataURL(file); // Lê o arquivo como URL de dados
        }
    }
</script>


</html>