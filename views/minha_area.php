<?php
include('../models/conexao.php');
include('../models/protect.php');

// Consulta SQL para obter máquinas
$sql = "SELECT id, nome_maquina FROM maquina";
$result = $conn->query($sql);

$maquinas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $maquinas[] = $row;
    }
}



?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>ACOMPANHAR ANDAMENTO</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <div class="container-top">
                
                <li class="drop-hover">
                    <img src="../icon/avatar.png" alt="Foto de Perfil" class="avatar">

                    <a href="../models/logout.php">
                        <img src="../icon/log-out.svg" alt="Out" class="out">
                    </a> 
                    <a href="../views/home.php">
                        <img src="../icon/back.svg" alt="back" class="back">
                    </a>                           
                </li> 
                                       
        </header>
        <main>
             
            <div class="homeOrdem">
                <div class="button-container">
                    <button id="addOrderButton">Adicionar Ordem</button>
                    <button id="graphicButton">Gráficos</button>
                </div>

                <div id="chartModal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <div class="modal-controls">
                            <select id="chartTypeSelector" class="chart-selector">
                                <option value="bar">Barra</option>
                                <option value="pie">Pizza</option>
                                <option value="line">Linha</option>
                                <option value="doughnut">Rosca</option>
                            </select>
                            <select id="dataTypeSelector" class="chart-selector">
                                <option value="orderType">Tipos de Ordem</option>
                                <option value="orderPriority">Criticidade da Ordem</option>
                                <option value="orderManutentor">Manutentor</option>
                                <option value="orderStage">Estágio das Ordens</option>
                            </select>
                        </div>
                        <canvas id="orderTypeChart"></canvas>
                    </div>
                </div>




                <div class="formulariOrdem">
                    <form id="orderForm" class="hidden">
                        <label for="orderTipo">Tipo De Ordem</label>
                        <select id="orderTipo" name="orderTipo" required>
                            <option value="Corretiva">Corretiva planejada</option>
                            <option value="corretiva nao planejada">Corretiva não planejada</option>
                            <option value="corretiva paliativa">Corretiva paliativa</option>
                            <option value="corretiva curativa">Corretiva curativa</option>
                        </select>
                        <label for="orderDescription">Descrição da Ordem</label>
                        <textarea id="orderDescription" name="orderDescription" required></textarea>
                        
  

                        <label class="label-input" for="orderMaquina">
                            <i class="fas fa-cogs icon-modify"></i> <!-- Ícone pode ser modificado conforme necessário -->
                            <select id="orderMaquina" name="orderMaquina" required>
                                <option value="">Selecione a Máquina</option>
                                <?php foreach ($maquinas as $maquina): ?>
                                    <option value="<?php echo $maquina['nome_maquina']; ?>"> <!-- Aqui você define o nome como o valor -->
                                        <?php echo $maquina['nome_maquina']; ?> <!-- E aqui você exibe o nome da máquina -->
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>



                        
                        <label for="orderPriority">Criticidade</label>
                        <select id="orderPriority" name="orderPriority" required>
                            <option value="Baixo">Baixo</option>
                            <option value="Médio">Médio</option>
                            <option value="Alto">Alto</option>
                            <option value="Crítico">Crítico</option>
                        </select>


                        
                        
                        <label class="label-input" for="orderManutentor">
                            <i class="fas fa-user icon-modify"></i>
                            <!-- Exibe o nome do manutentor no formulário -->
                            <input type="text" id="orderManutentor" name="orderManutentor" value="<?php echo $_SESSION['nome']; ?>" readonly>
                            <!-- Campo oculto para enviar o valor do nome no formulário -->
                            <input type="hidden" name="orderManutentorId" value="<?php echo $_SESSION['id']; ?>">
                        </label>




                        <button type="submit">Criar Ordem</button>
                    </form>
                    <div id="searchFilter">
                        <input type="text" id="searchInput" placeholder="Pesquisar...">
                        <button id="searchButton">Buscar</button>
                    </div>
                    <div id="filterButtons">
                        <button id="filterLow">Baixo</button>
                        <button id="filterMedium">Médio</button>
                        <button id="filterHigh">Alto</button>
                        <button id="filterCritical">Crítico</button>
                        <button id="clearFilter">Limpar Filtro</button>
                    </div>
                </div>
                </div>
 

            <section class="colunas">
                <section class="coluna">
                    <h2 class="column__title" data-title="PARA FAZER">PARA FAZER (0)</h2>
                    <section class="column__cards" id="todoColumn"></section>
                </section>
                <section class="coluna">
                    <h2 class="column__title" data-title="EM ANDAMENTO">EM ANDAMENTO (0)</h2>
                    <section class="column__cards" id="inProgressColumn"></section>
                </section>
                <section class="coluna">
                    <h2 class="column__title" data-title="PARA REVER">PARA REVER (0)</h2>
                    <section class="column__cards" id="reviewColumn"></section>
                </section>
                <section class="coluna">
                    <h2 class="column__title" data-title="FINALIZADO">FINALIZADO (0)</h2>
                    <section class="column__cards" id="doneColumn"></section>
                </section>
            </section>
                
        </main>
    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.js"></script>
<script src="../js/script.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        url: '/site/views/minha_area.php', // Substitua pelo nome do seu arquivo PHP
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(order) {
                const card = createCard(order); // Cria o card com os dados da ordem
                // Adiciona o cartão à coluna correta com base no campo status
                switch (order.status) { 
                    case 'Para Fazer':
                        $('#todoColumn').append(card);
                        break;
                    case 'Em Andamento':
                        $('#inProgressColumn').append(card);
                        break;
                    case 'Para Rever':
                        $('#reviewColumn').append(card);
                        break;
                    case 'Finalizado':
                        $('#doneColumn').append(card);
                        break;
                    default:
                        console.warn('Status desconhecido para o cartão:', order.status);
                }
            });
            updateOrderCount(); // Atualiza a contagem de cartões por coluna
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Erro ao carregar os dados: ', textStatus, errorThrown);
        }
    });
});


const getCircleColor = (priority) => {
    switch (priority) {
        case 'Baixo':
            return '#34d399';
        case 'Médio':
            return '#60a5fa';
        case 'Alto':
            return '#fbbf24';
        case 'Crítico':
            return '#d946ef';
        default:
            return '#ced4da';
    }
};

// Outras funções como `updateOrderCount`, `dragStart`, `dragEnd`, etc., permanecem as mesmas.

</script>


</body>
</html>
