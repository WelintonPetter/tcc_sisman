<?php
include('../models/protect.php');
include('../models/conexao.php');



// Consulta para buscar setores
$sql = "SELECT id, nome FROM setor";
$result = $conn->query($sql);

$setoresOptions = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $setoresOptions .= "<option value='{$row['id']}'>{$row['nome']}</option>";
    }
} else {
    $setoresOptions = "<option value=''>Nenhum setor encontrado</option>";
}

// Consulta SQL para obter máquinas
$sql = "SELECT id, nome_maquina FROM maquina";
$result = $conn->query($sql);

$maquinas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $maquinas[] = $row;
    }
}


// Consulta para buscar máquinas com caminho da imagem
$sql = "SELECT id, nome_maquina, path FROM maquina";
$result = $conn->query($sql);

$maquinasOptions = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $maquinasOptions .= "<option value='{$row['id']}' data-image='{$row['path']}'>{$row['nome_maquina']}</option>";
    }
} else {
    $maquinasOptions = "<option value=''>Nenhuma máquina encontrada</option>";
}

// Consulta para buscar mantenedores
$sql = "SELECT id, nome FROM manutentor";
$result = $conn->query($sql);

$manutentorOptions = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $manutentorOptions .= "<option value='{$row['id']}'>{$row['nome']}</option>";
    }
} else {
    $manutentorOptions = "<option value=''>Nenhum mantenedor encontrado</option>";
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/new_cadastro.css">
    <style>
        .form-container {
            display: none;
        }
        .form-container.active {
            display: block;
        }
        .image-preview {
            display: none;
            max-width: 100%;
            height: auto;
        }
        .hide-image {
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="container-back">
            <div class="container-top">
                <li class="drop-hover">
                    <img src="../icon/avatar.png" alt="Foto de Perfil" class="avatar">
                    <div class="drop">
                        <a href="#"><?php echo $_SESSION['nome']; ?></a>
                        <a href="#">Conta</a>
                        <a href="#">Dados da Empresa</a>
                        <a href="sac.html">Sac</a>
                    </div>
                    <a href="../models/logout.php">
                        <img src="../icon/log-out.svg" alt="Out" class="out">
                    </a>
                </li>                   
            </div>  
            <div class="container-home">
                <div class="content-home first-content-home">
                    <ul>  
                        <li class="item-menu">
                            <a href="home.php">
                                <span class="icon"><i class="bi bi-house-fill"></i></span>
                                <span class="txt-link">Início</span>
                            </a>
                        </li> 
                                        
                        <li class="item-menu">
                            <button onclick="showForm('orderForm')">
                                <span class="icon"><i class="bi bi-tools"></i></span>
                                <span class="txt-link">Corretiva</span>
                            </button>  
                        </li>
                        <li class="item-menu">
                            <button onclick="showForm('orderpreventive')">
                                <span class="icon"><i class="bi bi-wrench"></i>
                                </span>
                                <span class="txt-link">Preventiva</span>
                            </button> 
                        </li>               
                        <li class="item-menu">
                            <button onclick="showForm('orderpreditiva')">
                                <span class="icon"><i class="bi bi-speedometer2"></i>
                                </span>
                                <span class="txt-link">Preditiva</span>
                            </button>                          
                        </li>
    
                    </ul>
                </div>
            </div>
            <div class="container">  
                <div class="second-sac">
                    <h2 class="title title-sac">Cadastrar</h2>   
                    <img src="/icon/system.svg" class ="left-login-image" alt="Animação Fabrica">
                    <form id="orderForm" class="form-container" enctype="multipart/form-data" action="/models/geraos.php" method="post">
                            <h2 class="title title-sac">Nova Ordem de Serviço</h2>

                            <label class="label-input" for="orderTipo">
                                <i class="fas fa-wrench icon-modify"></i>
                                <select id="orderTipo" name="orderTipo" required>
                                    <option value="">Tipo de Ordem</option>
                                    <option value="Corretiva">Corretiva planejada</option>
                                    <option value="corretiva nao planejada">Corretiva não planejada</option>
                                    <option value="corretiva paliativa">Corretiva paliativa</option>
                                    <option value="corretiva curativa">Corretiva curativa</option>
                                </select>
                            </label>

                            <label class="label-input" for="sector">
                                <i class="fas fa-building icon-modify"></i>
                                <select id="sector" name="sector" required>
                                    <option value="">Selecione o Setor</option>
                                        <?php echo $setoresOptions; ?>
                                </select>
                            </label>

                            <label class="label-input" for="orderDescription">
                                <i class="fas fa-sticky-note icon-modify"></i>
                                <textarea id="orderDescription" name="orderDescription" placeholder="Descrição da Ordem" rows="3" required></textarea>
                            </label>

                            <label class="label-input" for="orderMaquina">
                                <i class="fas fa-cogs icon-modify"></i>
                                <select id="orderMaquina" name="orderMaquina" required>
                                    <option value="">Selecione a Máquina</option>
                                    <?php echo $maquinasOptions; ?>
                                </select>
                            </label>

                            <label class="label-input" for="orderPriority">
                                <i class="fas fa-exclamation-circle icon-modify"></i>
                                <select id="orderPriority" name="orderPriority" required>
                                    <option value="">Nível de Criticidade</option>
                                    <option value="Baixo">Baixo</option>
                                    <option value="Médio">Médio</option>
                                    <option value="Alto">Alto</option>
                                    <option value="Crítico">Crítico</option>
                                </select>
                            </label>

                            <label class="label-input" for="orderManutentor">
                                <i class="fas fa-user icon-modify"></i>
                                <select id="orderManutentor" name="orderManutentor" required>
                                    <option value="">Selecione o Manutentor</option>
                                    <?php echo $manutentorOptions; ?>
                                </select>
                            </label>

                            <button type="submit" class="btn btn-second-cadastro" id="signupButton">Criar Ordem</button>
                        </form>
    




                        <form id="orderpreventive" class="form-container" enctype="multipart/form-data" action="/models/geraos.php" method="post">
                            <h2 class="title title-sac">Nova Ordem Preventiva</h2>

                            <label class="label-input" for="orderTipo">
                                <i class="fas fa-wrench icon-modify"></i>
                                <select id="orderTipo" name="orderTipo" required>
                                    <option value="">Tipo de Ordem</option>
                                    <option value="Corretiva">Corretiva planejada</option>
                                    <option value="corretiva nao planejada">Corretiva não planejada</option>
                                    <option value="corretiva paliativa">Corretiva paliativa</option>
                                    <option value="corretiva curativa">Corretiva curativa</option>
                                </select>
                            </label>

                            <label class="label-input" for="sector">
                                <i class="fas fa-building icon-modify"></i>
                                <select id="sector" name="sector" required>
                                    <option value="">Selecione o Setor</option>
                                        <?php echo $setoresOptions; ?>
                                </select>
                            </label>

                            <label class="label-input" for="orderDescription">
                                <i class="fas fa-sticky-note icon-modify"></i>
                                <textarea id="orderDescription" name="orderDescription" placeholder="Descrição da Ordem" rows="3" required></textarea>
                            </label>

                            <label class="label-input" for="orderMaquina">
                                <i class="fas fa-cogs icon-modify"></i>
                                <select id="orderMaquina" name="orderMaquina" required>
                                    <option value="">Selecione a Máquina</option>
                                    <?php echo $maquinasOptions; ?>
                                </select>
                            </label>

                            <label class="label-input" for="orderPriority">
                                <i class="fas fa-exclamation-circle icon-modify"></i>
                                <select id="orderPriority" name="orderPriority" required>
                                    <option value="">Nível de Criticidade</option>
                                    <option value="Baixo">Baixo</option>
                                    <option value="Médio">Médio</option>
                                    <option value="Alto">Alto</option>
                                    <option value="Crítico">Crítico</option>
                                </select>
                            </label>

                            <label class="label-input" for="orderManutentor">
                                <i class="fas fa-user icon-modify"></i>
                                <select id="orderManutentor" name="orderManutentor" required>
                                    <option value="">Selecione o Manutentor</option>
                                    <?php echo $manutentorOptions; ?>
                                </select>
                            </label>

                            <button type="submit" class="btn btn-second-cadastro" id="signupButton">Criar Ordem</button>
                        </form>
                        <div id="mensagem"></div>
                        <form id="orderpreditiva" class="form-container" enctype="multipart/form-data" action="/models/geraos.php" method="post">
                            <h2 class="title title-sac">Ordem de Serviço Preditiva</h2>

                            <label class="label-input" for="machine">
                                <i class="fas fa-building icon-modify"></i>
                                <select id="machine" name="machine" required>
                                    <option value="">Selecione a Máquina</option>
                                    <?php foreach ($maquinas as $maquina): ?>
                                        <option value="<?php echo $maquina['id']; ?>">
                                            <?php echo $maquina['nome_maquina']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </label>

                            <label class="label-input" for="sensor">
                                <i class="fas fa-sensor icon-modify"></i>
                                <select id="sensor" name="sensor" required>
                                    <option value="">Selecione o Sensor</option>
                                    <?php echo $sensoresOptions; ?>
                                </select>
                            </label>


                            <label class="label-input" for="orderPriority">
                                <i class="fas fa-exclamation-circle icon-modify"></i>
                                <select id="orderPriority" name="orderPriority" required>
                                    <option value="">Nível de Criticidade</option>
                                    <option value="Baixo">Baixo</option>
                                    <option value="Médio">Médio</option>
                                    <option value="Alto">Alto</option>
                                    <option value="Crítico">Crítico</option>
                                </select>
                            </label>

                            <label class="label-input" for="startDate">
                                <i class="fas fa-calendar-alt icon-modify"></i>
                                <input id="startDate" name="startDate" type="date" required>
                            </label>

                            <label class="label-input" for="timeInterval">
                                <i class="fas fa-hourglass-half icon-modify"></i>
                                <select id="timeInterval" name="timeInterval" required>
                                    <option value="">Intervalo de Tempo</option>
                                    <option value="15d">15 Dia</option>
                                    <option value="30d">30 Dias</option>
                                    <option value="60d">60 Dias</option>
                                    <option value="90d">90 Dias</option>
                                    <option value="120d">120 Dias</option>
                                    <option value="180d">180 Dias</option>
                                    
                                </select>
                            </label>

                            <label class="label-input" for="registrationDate">
                                <i class="fas fa-calendar-check icon-modify"></i>
                                <input id="registrationDate" name="registrationDate" type="date" required>
                            </label>
                            <label class="label-input" for="orderDescription">
                                <i class="fas fa-sticky-note icon-modify"></i>
                                <textarea id="orderDescription" name="orderDescription" placeholder="Descrição da Ordem de Serviço" rows="3" required></textarea>
                            </label>

                            <button type="submit" class="btn btn-second-cadastro" id="signupButton">Cadastrar Preditiva</button>
                        </form>

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
        function showForm(formId) {
            document.querySelectorAll('.form-container').forEach(function(form) {
                form.classList.remove('active');
            });
            document.querySelectorAll('.left-login-image').forEach(function(image) {
                image.classList.add('hide-image');
            });
            document.getElementById(formId).classList.add('active');
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
        document.getElementById("ordemForm").addEventListener("submit", function(e) {
            e.preventDefault(); // Impede o envio padrão do formulário

            var formData = new FormData(this);

            // Envia os dados via AJAX
            fetch('geraosphp', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Exibe a mensagem no div "mensagem"
                document.getElementById("mensagem").innerHTML = data;
            })
            .catch(error => {
                console.error('Erro:', error);
                document.getElementById("mensagem").innerHTML = "Erro ao processar o pedido.";
            });
        });
        
    </script>
</body>
</html>
