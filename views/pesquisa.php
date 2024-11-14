<?php

include('../models/protect.php');

// Configuração de credenciais
$server = 'localhost';
$usuario = 'root';
$senha_banco = '';  // Senha do banco de dados
$banco = 'tcc_sisman';

// Conexão com o banco de dados
$conn = new mysqli($server, $usuario, $senha_banco, $banco);

if ($conn->connect_error) {
    die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
}

// Inicializa variáveis de busca
$searchManutentor = isset($_POST['searchManutentor']) ? $conn->real_escape_string($_POST['searchManutentor']) : '';
$searchSetor = isset($_POST['searchSetor']) ? $conn->real_escape_string($_POST['searchSetor']) : '';
$searchMaquina = isset($_POST['searchMaquina']) ? $conn->real_escape_string($_POST['searchMaquina']) : '';
$searchData = isset($_POST['searchData']) ? $conn->real_escape_string($_POST['searchData']) : '';

// Pega o número de linhas por página
$linesPerPage = isset($_POST['linesPerPage']) ? intval($_POST['linesPerPage']) : 10;

// Consulta SQL com múltiplos critérios de busca
$sql = "SELECT * FROM ordem_os WHERE 1=1";

if (!empty($searchManutentor)) {
    $sql .= " AND manutentor_os LIKE ?";
}
if (!empty($searchSetor)) {
    $sql .= " AND setor_os LIKE ?";
}
if (!empty($searchMaquina)) {
    $sql .= " AND maquina_os LIKE ?";
}
if (!empty($searchData)) {
    $sql .= " AND data = ?";
}

// Adiciona o limite ao SQL
$sql .= " LIMIT ?";

$stmt = $conn->prepare($sql);

$types = '';
$values = [];

if (!empty($searchManutentor)) {
    $types .= 's';
    $values[] = "%$searchManutentor%";
}
if (!empty($searchSetor)) {
    $types .= 's';
    $values[] = "%$searchSetor%";
}
if (!empty($searchMaquina)) {
    $types .= 's';
    $values[] = "%$searchMaquina%";
}
if (!empty($searchData)) {
    $types .= 's';
    $values[] = $searchData;
}

// Adiciona o valor do limite
$types .= 'i'; // Tipo inteiro para o LIMIT
$values[] = $linesPerPage;

$stmt->bind_param($types, ...$values);
$stmt->execute();
$result = $stmt->get_result();

?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/stylebusca.css">
    <style>

    

    
       
    </style>
</head>
<body>
    <header>
        <div class="container-top"></div>
        <P></P>
        </div>
        <div class="container">
            
                <img src="../icon/avatar.png" alt="Foto de Perfil" class="avatar">    
                            
                <a href="../models/logout.php">
                    <img src="../icon/log-out.svg" alt="Out" class="out">
                </a> 

            
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
            <div class = nome>
                <h1>Buscar Ordem</h1>
            
            
                <!-- Formulário de Busca -->
                <form method="post" action="pesquisa.php">
                    
                    <input type="text" name="searchManutentor" placeholder="Buscar por manutentor" value="<?php echo htmlspecialchars($searchManutentor); ?>">
                    <input type="text" name="searchSetor" placeholder="Buscar por setor" value="<?php echo htmlspecialchars($searchSetor); ?>">
                    <input type="text" name="searchMaquina" placeholder="Buscar por máquina" value="<?php echo htmlspecialchars($searchMaquina); ?>">
                    <input type="date" name="searchData" placeholder="Buscar por data" value="<?php echo htmlspecialchars($searchData); ?>">
                    
                    <!-- Select para número de linhas -->
                    <label for="linesPerPage">Páginas:</label>
                    <select name="linesPerPage" id="linesPerPage">
                        <option value="10" <?php echo ($linesPerPage == 10) ? 'selected' : ''; ?>>10</option>
                        <option value="25" <?php echo ($linesPerPage == 25) ? 'selected' : ''; ?>>25</option>
                        <option value="50" <?php echo ($linesPerPage == 50) ? 'selected' : ''; ?>>50</option>
                        <option value="100" <?php echo ($linesPerPage == 100) ? 'selected' : ''; ?>>100</option>
                    </select>
                    
                    <button type="submit">Buscar</button>
                </form>  
            </div>    
            <br>
                 
            <!-- Tabela de Ordens -->
            <div class="order-container">
                <table>
                    <thead>
                        <tr>
                            <th>Número da Ordem</th>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th>Máquina</th>
                            <th>Setor</th>
                            <th>Manutentor</th>
                            <th>Data</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['numero_os']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tipo_os']); ?></td>
                                    <td><?php echo htmlspecialchars($row['descricao_os']); ?></td>
                                    <td><?php echo htmlspecialchars($row['maquina_os']); ?></td>
                                    <td><?php echo htmlspecialchars($row['setor_os']); ?></td>
                                    <td><?php echo htmlspecialchars($row['manutentor_os']); ?></td>
                                    <td><?php echo htmlspecialchars($row['data']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hora']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">Nenhuma ordem encontrada.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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