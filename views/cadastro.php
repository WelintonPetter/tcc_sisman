<?php
include('../models/protect.php');
include('../models/conexao.php');
// Configuração de credenciais

// Consulta SQL para obter setores
$sql = "SELECT codsetor, nome FROM setor";
$result = $conn->query($sql);

$setores = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $setores[] = $row;
    }
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

$conn->close();

?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/new_cadastro.css">
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
                            <button onclick="showForm('machineForm')">
                                <span class="icon"><i class="bi bi-train-front-fill"></i></span>
                                <span class="txt-link">Máquina</span>
                            </button>  
                        </li>
                        <li class="item-menu">
                            <button onclick="showForm('sectorForm')">
                                <span class="icon"><i class="bi bi-sign-intersection-fill"></i>
                                </span>
                                <span class="txt-link">Setor</span>
                            </button> 
                        </li>               
                        <li class="item-menu">
                            <button onclick="showForm('maintainerForm')">
                                <span class="icon"><i class="bi bi-person-fill-add"></i>
                                </span>
                                <span class="txt-link">Manutentor</span>
                            </button> 
                           
                        </li>
                        <li class="item-menu">
                            <button onclick="showForm('sensorForm')">
                                <span class="icon"><i class="bi bi-disc"></i>
                                </span>
                                <span class="txt-link">Sensores</span>
                            </button> 
                           
                        </li>
                         
                    </ul>
                </div>
            </div>
            <div class="container">  
            <div class="first-column">        
                
       
                <div class="second-sac">
                <h2 class="title title-sac">Cadastros</h2>   
                <img src="/icon/cadastro.svg" class ="left-login-image" alt="Animação Fabrica">
                    <form id="machineForm" class="form-container" enctype="multipart/form-data" action="../models/cadastromachine.php" method="post">  
                        <h2 class="title title-sac"> Nova Máquina</h2>
                        <label class="label-input" for="machineName">
                            <i class="fas fa-cogs icon-modify"></i>
                            <input id="machineName" name="machineName" type="text" placeholder="Nome da Máquina" required>
                        </label>
                        <label class="label-input" for="machineType">
                            <i class="fas fa-wrench icon-modify"></i>
                            <input id="machineType" name="machineType" type="text" placeholder="Tipo de Máquina" required>
                        </label>
                        <label class="label-input" for="manufacturer">
                            <i class="fas fa-industry icon-modify"></i>
                            <input id="manufacturer" name="manufacturer" type="text" placeholder="Fabricante" required>
                        </label>
                        <label class="label-input" for="serialNumber">
                            <i class="fas fa-barcode icon-modify"></i>
                            <input id="serialNumber" name="serialNumber" type="text" placeholder="Número de Série" required>
                        </label>
                        <label class="label-input" for="acquisitionDate">
                            <i class="fas fa-calendar-alt icon-modify"></i>
                            <input id="acquisitionDate" name="acquisitionDate" type="date" required>
                        </label>
                        <label class="label-input" for="operationStatus">
                            <i class="fas fa-toggle-on icon-modify"></i>
                            <select id="operationStatus" name="operationStatus" required>
                                <option value="">Estado de Operação</option>
                                <option value="operacional">Operacional</option>
                                <option value="manutencao">Em Manutenção</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </label>
                        <label class="label-input" for="criticalityLevel">
                            <i class="fas fa-exclamation-circle icon-modify"></i>
                            <select id="criticalityLevel" name="criticalityLevel" required>
                                <option value="">Nível de Criticidade</option>
                                <option value="baixo">Baixo</option>
                                <option value="medio">Médio</option>
                                <option value="alto">Alto</option>
                            </select>
                        </label>
                        <label class="label-input" for="sector">
                            <i class="fas fa-building icon-modify"></i>
                            <select id="sector" name="sector" required>
                                <option value="">Selecione o Setor</option>
                                <?php foreach ($setores as $setor): ?>
                                    <option value="<?php echo $setor['codsetor']; ?>">
                                        <?php echo $setor['nome']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label class="label-input" for="observations">
                            <i class="fas fa-sticky-note icon-modify"></i>
                            <textarea id="observations" name="observations" placeholder="Observações" rows="3"></textarea>
                        </label>
                        <label class="label-input" for="machinePhoto">
                            <i class="fas fa-camera icon-modify"></i>
                            <input id="machinePhoto" name="machinePhoto" type="file" accept="image/*" onchange="previewImage(event)">
                        </label>
                        <img id="imagePreview" class="image-preview" alt="Pré-visualização da Imagem">
                        <button type="submit" class="btn btn-second-cadastro" id="signupButton">Cadastrar Máquina</button>
                    </form>

                    <form id="sectorForm" class="form-container" enctype="multipart/form-data" action="../models/cadastrosetor.php" method="post">
                        <h2 class="title title-sac">Novo Setor</h2>
                        <label class="label-input" for="sectorName">
                            <i class="fas fa-cogs icon-modify"></i>
                            <input id="sectorName" name="sectorName" type="text" placeholder="Nome do Setor" required>
                        </label>
                        <label class="label-input" for="codSector">
                            <i class="fas fa-cogs icon-modify"></i>
                            <input id="codSector" name="codSector" type="text" placeholder="Cod. Setor" required>
                        </label>
                        <button type="submit" class="btn btn-second-cadastro" id="signupButton">Cadastrar Setor</button>
                    </form>

                    <form id="sensorForm" class="form-container" enctype="multipart/form-data" action="../models/cadastrosensor.php" method="post">
                        <h2 class="title title-sac">Cadastro de Sensor para Análise Preditiva</h2>

                        <label class="label-input" for="machine">
                            <i class="fas fa-building icon-modify"></i>
                            <select id="machine" name="machine" required>
                                <option value="">Selecione Máquina</option>
                                <?php foreach ($maquinas as $maquina): ?>
                                    <option value="<?php echo $maquina['id']; ?>">
                                        <?php echo $maquina['nome_maquina']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>

                        <label class="label-input" for="sensorName">
                            <i class="fas fa-sensor icon-modify"></i>
                            <input id="sensorName" name="sensorName" type="text" placeholder="Tag do Sensor" required>
                        </label>

                        <label class="label-input" for="sensorType">
                            <i class="fas fa-exclamation-circle icon-modify"></i>
                            <select id="sensorType" name="sensorType" required>
                                <option value="">Selecione o Tipo de Sensor</option>
                                <option value="vibration">Sensor de Vibração</option>
                                <option value="temperature">Sensor de Temperatura</option>
                                <option value="humidity">Sensor de Umidade</option>
                                <option value="pressure">Sensor de Pressão</option>
                                <option value="proximity">Sensor de Proximidade</option>
                                <option value="flow">Sensor de Fluxo</option>
                                <option value="level">Sensor de Nível</option>
                                <option value="acceleration">Sensor de Aceleração</option>
                                <option value="infrared">Sensor Infravermelho</option>
                                <option value="ultrasonic">Sensor Ultrassônico</option>
                            </select>
                        </label>

                        <label class="label-input" for="sensorBrand">
                            <i class="fas fa-tag icon-modify"></i>
                            <input id="sensorBrand" name="sensorBrand" type="text" placeholder="Marca" required>
                        </label>

                        <label class="label-input" for="sensorSerialNumber">
                            <i class="fas fa-barcode icon-modify"></i>
                            <input id="sensorSerialNumber" name="sensorSerialNumber" type="text" placeholder="Número de Série" required>
                        </label>
                                                <!-- Novo campo para código de estoque -->
                                                <label class="label-input" for="stockCode">
                            <i class="fas fa-box icon-modify"></i>
                            <input id="stockCode" name="stockCode" type="text" placeholder="Código de Estoque" required>
                        </label>
                        <label class="label-input" for="sensorWarranty">
                            <i class="fas fa-calendar-check icon-modify"></i>
                            <input id="sensorWarranty" name="sensorWarranty" type="text" placeholder="Garantia (Meses)" required>
                        </label>

                        <label class="label-input" for="sensorVoltage">
                            <i class="fas fa-bolt icon-modify"></i>
                            <input id="sensorVoltage" name="sensorVoltage" type="text" placeholder="Tensão de Trabalho (V)" required>
                        </label>

                        <label class="label-input" for="sensorLocation">
                            <i class="fas fa-map-marker-alt icon-modify"></i>
                            <input id="sensorLocation" name="sensorLocation" type="text" placeholder="Localização do Sensor" required>
                        </label>

                        <label class="label-input" for="sensorDescription">
                            <i class="fas fa-align-left icon-modify"></i>
                            <textarea id="sensorDescription" name="sensorDescription" placeholder="Descrição do Sensor" rows="4" required></textarea>
                        </label>

                        <!-- Novo campo para foto do sensor -->
                        <label class="label-input" for="sensorPhoto">
                            <i class="fas fa-camera icon-modify"></i>
                            <input id="sensorPhoto" name="sensorPhoto" type="file" accept="image/*">
                        </label>



                        <button type="submit" class="btn btn-second-cadastro" id="registerButton">Cadastrar Sensor</button>
                    </form>


                    <form id="maintainerForm" class="form-container" enctype="multipart/form-data" action="../models/cadastromanu.php" method="post">
                        <h2 class="title title-sac">Novo Manutentor</h2>
                        <label class="label-input" for="maintainerName">
                            <i class="fas fa-cogs icon-modify"></i>
                            <input id="maintainerName" name="maintainerName" type="text" placeholder="Nome do Manutentor" required>
                        </label>
                        <label class="label-input" for="profisionName">
                            <i class="fas fa-cogs icon-modify"></i>
                            <input id="profisionName" name="profisionName" type="text" placeholder="Profissão" required>
                        </label>
                        <label class="label-input" for="sectorJob">
                            <i class="fas fa-building icon-modify"></i>
                            <select id="sectorJob" name="sectorJob" required>
                                <option value="001">Setor</option>
                                <option value="001">Mecânica</option>
                                <option value="002">Elétrica</option>
                                <option value="003">Eletromecânico</option>
                            </select>
                        </label>
                        <button type="submit" class="btn btn-second-cadastro" id="signupButton">Cadastrar Manutentor</button>
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
    </script>
</body>
</html>
