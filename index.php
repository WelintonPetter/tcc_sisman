<?php
// Inicia a sessão se ainda não foi iniciada
if (!isset($_SESSION)) {
    session_start();
}

$erro = '';  // Variável para armazenar a mensagem de erro
$mensagem = '';  // Variável para armazenar mensagens de sucesso

// Configuração de credencial
$server = 'autorack.proxy.rlwy.net';
$usuario = 'root';
$senha_banco = 'xEHJLKakXUHgFvHFYyspNBILZQqiuEZs';  // Senha do banco de dados
$banco = 'railway';
$porta = 53266;  // Porta especificada na URL de conexão

// Conexão com o banco de dados
$conn = new mysqli($server, $usuario, $senha_banco, $banco, $porta);



if ($conn->connect_error) {
    die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se é um formulário de login ou cadastro
    if (isset($_POST['email-login'])) {
        // Processo de login
        $email = trim($_POST['email-login']);  // Remove espaços em branco
        $senha_usuario = trim($_POST['senha-login']);  // Remove espaços em branco

        // Prepara a consulta para verificar se o usuário existe e se a senha está correta
        $smtp = $conn->prepare("SELECT * FROM casastro WHERE email = ? AND senha = ?");
        $smtp->bind_param("ss", $email, $senha_usuario);
        $smtp->execute();

        // Armazena o resultado
        $result = $smtp->get_result();

        if ($result->num_rows > 0) {
            // Obtém os dados do usuário
            $usuario = $result->fetch_assoc();

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: /site/views/home.php");
            exit();  // Garante que o script seja encerrado após o redirecionamento
        } else {
            $erro = "E-mail ou senha incorretos. Tente novamente.";
        }

        $smtp->close();
    } elseif (isset($_POST['email-signup'])) {
        // Processo de cadastro
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email-signup']);
        $senha_usuario = trim($_POST['senha-signup']);
        $data_atual = date('d/m/Y');
        $hora_atual = date('H:i:s');

        if (empty($nome) || empty($email) || empty($senha_usuario)) {
            $erro = "Todos os campos são obrigatórios.";
        } else {
            // Prepara a consulta para inserir os dados do usuário
            $smtp = $conn->prepare("INSERT INTO casastro (nome, email, senha, data, hora) VALUES (?, ?, ?, ?, ?)");
            $smtp->bind_param("sssss", $nome, $email, $senha_usuario, $data_atual, $hora_atual);

            if ($smtp->execute()) {
                $mensagem = "Cadastro realizado com sucesso!";
            } else {
                $erro = "Erro ao realizar o cadastro: " . $smtp->error;
            }

            $smtp->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="/site/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" 
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<body>
    <div class="language-selector">
        <select id="language-select">
            <option value="pt">Português</option>
            <option value="en">English</option>
            <option value="es">Español</option>
        </select>
    </div>
    <div class="container">
        <div class="content first-content">
            <div class="first-column">        
                <img src="icon/register.svg" class ="left-login-image" alt="Animação Fabrica">
                <button id="signin" class="btn btn-primary">Entrar</button>
                <!-- Div para exibir a mensagem de erro -->          
            </div>    
            <div class="second-column">
                <h2 class="title title-second">Criar Conta</h2>
                <div class="social-media">
                    <ul class="list-social-media">
                        <li class="item-social-media">
                            <a class="link-social-media" href="#">
                                <i class="fab fa-google-plus-g"></i>
                            </a>
                        </li>                   
                    </ul>
                </div>
                <p class="description description-second">ou use seu e-mail para cadastro:</p>
                <form class="form" action="" method="post">
                    <label class="label-input" for="name">
                        <i class="far fa-user icon-modify"></i>
                        <input id="name" type="text" name="nome" placeholder="Nome">
                    </label>
                    <label class="label-input" for="email-signup">
                        <i class="far fa-envelope icon-modify"></i>
                        <input id="email-signup" type="email" name="email-signup" placeholder="Email">
                    </label>
                    <label class="label-input" for="password-signup">
                        <i class="fas fa-lock icon-modify"></i>
                        <input id="password-signup" type="password" name="senha-signup" placeholder="Senha">
                    </label>
                    <button type="submit" class="btn btn-second" id="signupButton">Cadastrar</button>
                    <?php if (!empty($mensagem)): ?>
                        <div class="success-message" style="color: green; margin-top: 10px; font-weight: bold;">
                            <?php echo $mensagem; ?>
                        </div>
                    <?php endif; ?> 
                    <?php if (!empty($erro)): ?>
                        <div class="error-message" style="color: red; margin-top: 10px; font-weight: bold;">
                            <?php echo $erro; ?>
                        </div>
                    <?php endif; ?>      
                        
                </form>
            </div>
        </div>
        <div class="content second-content">
            <div class="first-column">
                <img src="icon/factory.svg" alt="Animação Fabrica">
                <h2 class="title title-primary">Vamos Começar?</h2>
                <p class="description description-primary">Insira seus dados e inicie sua jornada de eficiência</p>
                <p class="description description-primary">na gestão de manutenção conosco.</p>
                <button id="signup" class="btn btn-primary">Cadastrar</button>
            </div>
            <div class="second-column">
                <h2 class="title title-second">Faça login na plataforma</h2>
                <div class="social-media">
                    <ul class="list-social-media">
                        <li class="item-social-media">
                            <a class="link-social-media" href="#">
                                <i class="fab fa-google-plus-g"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <p class="description description-second">ou use sua conta de e-mail:</p>
                <form class="form" action="" method="post">
                    <label class="label-input" for="email-login">
                        <i class="far fa-envelope icon-modify"></i>
                        <input id="email-login" type="email" name="email-login" placeholder="Email">
                    </label>
                    <label class="label-input" for="password-login">
                        <i class="fas fa-lock icon-modify"></i>
                        <input id="password-login" type="password" name="senha-login" placeholder="Senha">
                    </label>
                    
                    <div class="remember-forgot">
                        <label><input type="checkbox" name="remember"> lembrar-me </label>
                    </div>
                    
                    <a class="password" href="#">Esqueceu sua senha?</a>
                    <button type="submit" class="btn btn-second" id="signinButton">Entrar</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/app.js"></script>
</body>
</html>
