<?php
include('../models/conexao.php');
include('../models/protect.php');

$manutentor = $_SESSION['nome']; // Usando o nome do usuário logado

// Recupera os dados do usuário logado (com base no nome)
$sql = "SELECT * FROM casastro WHERE nome = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $manutentor);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Se o usuário estiver cadastrado, pega os dados
    $usuario = $result->fetch_assoc();
} else {
    // Se não encontrado, redireciona ou exibe uma mensagem
    echo "Usuário não encontrado.";
    exit();
}

// Lógica para fazer upload da imagem
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../arquivos/user/';
        $imagemNome = $manutentor . '_' . basename($_FILES['imagem']['name']); // Renomeia a imagem para o nome do usuário
        $uploadFile = $uploadDir . $imagemNome;

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
            // Atualiza o caminho da imagem no banco de dados
            $sql = "UPDATE casastro SET imagem = ? WHERE nome = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $uploadFile, $manutentor);
            $stmt->execute();

            // Atualiza o valor da imagem na variável $usuario
            $usuario['imagem'] = $uploadFile;
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    }
}

// Processando o restante dos dados do formulário (caso o formulário tenha sido enviado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coletando os dados do formulário
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $cep = $_POST['cep'];
    $setor = $_POST['setor'];
    $data_admissao = $_POST['data_admissao'];
    $turno = $_POST['turno'];
    $escolaridade = $_POST['escolaridade'];
    $formacao = $_POST['formacao'];
    $email = $_POST['email'];
    $imagem = $_FILES['imagem']['name'];

    // Validando se a imagem foi enviada
    if ($imagem) {
        $imagem_tmp = $_FILES['imagem']['tmp_name'];
        $imagem_destino = "../arquivos/user/" . $manutentor . '_' . basename($imagem);
        move_uploaded_file($imagem_tmp, $imagem_destino);
    } else {
        $imagem_destino = $usuario['imagem']; // Caso não tenha imagem, mantém a anterior
    }

    // Atualizando os dados no banco de dados
    $sql = "UPDATE casastro SET nome = ?, data_nascimento = ?, telefone = ?, cpf = ?, endereco = ?, bairro = ?, cidade = ?, cep = ?, setor = ?, data_admissao = ?, turno = ?, escolaridade = ?, formacao = ?, email = ?, imagem = ? WHERE nome = ?";
    $stmt = $conn->prepare($sql);

    // Ajuste da string de tipos para 17 variáveis
    $stmt->bind_param("ssssssssssssssss", $nome, $data_nascimento, $telefone, $cpf, $endereco, $bairro, $cidade, $cep, $setor, $data_admissao, $turno, $escolaridade, $formacao, $email, $imagem_destino, $manutentor);

    if ($stmt->execute()) {
        echo "<script>
                document.getElementById('mensagem-sucesso').style.display = 'block';
              </script>";
    } else {
        echo "Erro ao atualizar os dados: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/conta.css">
    <style>
        /* Estilos para o modal */
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
        .modal input[type="date"],
        .modal input[type="tel"],
        .modal input[type="cpf"],
        .modal input[type="number"],
        .modal select {
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
                <div class="avatar">
                    <img src="<?php echo !empty($usuario['imagem']) ? $usuario['imagem'] : '../icon/avatar.png'; ?>" 
                        alt="usuário" 
                        style="width: 50px; height: 50px; border-radius: 50%;">
                </div>
                
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

<main><main>
    <div class="modal">
        <h2>CADASTRAR USUÁRIO</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div>
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" required>

                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo $usuario['data_nascimento']; ?>" required>

                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" value="<?php echo $usuario['telefone']; ?>" placeholder="(XX) XXXXX-XXXX" required>

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo $usuario['cpf']; ?>" placeholder="XXX.XXX.XXX-XX" required>

                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" value="<?php echo $usuario['endereco']; ?>" required>

                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" value="<?php echo $usuario['bairro']; ?>" required>

                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" value="<?php echo $usuario['cidade']; ?>" required>

                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" value="<?php echo $usuario['cep']; ?>" placeholder="XXXXX-XXX" required>

                <label for="setor">Setor:</label>
                <input type="text" id="setor" name="setor" value="<?php echo $usuario['setor']; ?>" required>

                <label for="data_admissao">Data de Admissão:</label>
                <input type="date" id="data_admissao" name="data_admissao" value="<?php echo $usuario['data_admissao']; ?>" required>

                <label for="turno">Turno:</label>
                <select id="turno" name="turno" required>
                    <option value="primeiro" <?php echo ($usuario['turno'] == 'primeiro') ? 'selected' : ''; ?>>Primeiro Turno</option>
                    <option value="noturno" <?php echo ($usuario['turno'] == 'noturno') ? 'selected' : ''; ?>>Segundo Turno</option>
                    <option value="terceiro" <?php echo ($usuario['turno'] == 'terceiro') ? 'selected' : ''; ?>>Terceiro Turno</option>
                </select>

                <label for="escolaridade">Escolaridade:</label>
                <input type="text" id="escolaridade" name="escolaridade" value="<?php echo $usuario['escolaridade']; ?>" required>

                <label for="formacao">Formação:</label>
                <input type="text" id="formacao" name="formacao" value="<?php echo $usuario['formacao']; ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>

                <label for="imagem">Imagem de Perfil:</label>
                <input type="file" id="imagem" name="imagem">
                <div>
                    <img src="<?php echo !empty($usuario['imagem']) ? $usuario['imagem'] : '../icon/avatar.png'; ?>" 
                        alt="usuário" 
                        style="width: 100px; height: 100px; ">
                </div>
                
                

                <button type="submit" style="margin-bottom: 20px;">Atualizar Cadastro</button>

            </div>
        </form>
    </div>
</main>
</body>
</html>
