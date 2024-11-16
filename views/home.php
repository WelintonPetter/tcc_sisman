<?php
include('../models/conexao.php'); 
include('../models/protect.php');

if ($conn) {
    // Consulta para obter os dados para o gráfico
    $query = "SELECT DATE(data) as dia, tipo_os, COUNT(*) as total 
              FROM ordem_os 
              WHERE DATE(data) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
              GROUP BY DATE(data), tipo_os";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erro na consulta: " . mysqli_error($conn));
    }

    // Consulta para obter as últimas 5 ordens de serviço abertas
    $query_notificacoes = "SELECT id,tipo_os, numero_os, descricao_os, data, hora 
    FROM notificacao 
    WHERE status = 'N' 
    ORDER BY data DESC 
    LIMIT 5";
    $result_notificacoes = mysqli_query($conn, $query_notificacoes);

        if (!$result_notificacoes) {
            die("Erro na consulta de notificações: " . mysqli_error($conn));
        }
    } else {
        die("Erro na conexão com o banco de dados.");
    }

$dados = [];
$tipos_os = []; // Para armazenar todos os tipos de OS existentes
$notificacoes = [];

while ($row = mysqli_fetch_assoc($result)) {
    $dados[] = $row;
    if (!in_array($row['tipo_os'], $tipos_os)) {
        $tipos_os[] = $row['tipo_os']; // Captura dinamicamente todos os tipos de OS
    }
}

while ($row = mysqli_fetch_assoc($result_notificacoes)) {
    $notificacoes[] = $row;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/sisman.site/css/home.css">
    <style>     
          .carousel-container {
            display: flex; /* Flexbox para organizar a imagem e o gráfico */
            flex-direction: column; /* Arruma a imagem e o gráfico em colunas */
            margin-bottom: 20px; /* Espaço entre o carrossel e o gráfico */
        }
        #chart_div {
            width: 100%; /* Largura do gráfico para ocupar toda a largura disponível */
            height: 450px; /* Altura do gráfico com unidade */
            margin: 0 auto; /* Centraliza o gráfico */
        }
        .carousel-inner > .carousel-item > img {
            width: 110%; /* Garante que as imagens do carrossel ocupem toda a largura do carrossel */
            height: auto; /* Mantém a proporção da imagem */
        }
    </style>

<body>
    <header>
        <div class="container-back">
            <div class="container-top">
                <li class="drop-hover">
                    <img src="/sisman.site/icon/notify.svg" alt="notify" class="notify">
                    
                    <div class="drop">
                        <?php foreach ($notificacoes as $notificacao): ?>
                            <div id="notification-<?php echo $notificacao['id']; ?>">
                                <a href="#">
                                    Numero: <?php echo htmlspecialchars($notificacao['numero_os']); ?><br>
                                    Ordem: <?php echo htmlspecialchars($notificacao['tipo_os']); ?><br>
                                    Descrição: <?php echo htmlspecialchars($notificacao['descricao_os']); ?><br>
                                    Data / Hora: <?php echo date('d/m/Y H:i', strtotime($notificacao['data'] . ' ' . $notificacao['hora'])); ?>
                                </a>
                                <button onclick="deleteNotification(<?php echo $notificacao['id']; ?>)" class="btn btn-link">Excluir</button>
                                <hr>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <img src="/sisman.site/icon/avatar.png" alt="Foto de Perfil" class="avatar">
                    <div class="drop">
                        <a href="#">Conta - <?php echo $_SESSION['nome']; ?></a>
                        <a href="/sisman.site/views/lembrete.php">Lembrete</a>
                        <a href="#">Empresa</a>
                        <a href="#">Minha Equipe</a>
                        <a href="/sisman.site/views/sac.html">Sac</a>
                    </div>
                    
                    <a href="/sisman.site/models/logout.php">
                        <img src="/sisman.site/icon/log-out.svg" alt="Out" class="out">
                    </a>
                </li>                   
            </div>  

            <div class="main-content">
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
                                <a href="preventiva.php">
                                    <span class="icon"><i class="bi bi-hammer"></i></span>
                                    <span class="txt-link">Preventiva</span>
                                </a>
                            </li>
                            <li class="item-menu">
                                <a href="cadastro.php">
                                    <span class="icon"><i class="bi bi-building-add"></i></span>
                                    <span class="txt-link">Nova Cadastro</span>
                                </a>
                            </li>     
                        </ul>
                    </div>
                </div>
                
                <!-- Carousel -->
                <div class="carousel-container">
                    <div id="carouselExampleControls1" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/sisman.site/arquivos/avisos/preventiva.png" class="d-block w-100" alt="Imagem 1">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Treinamento sobre bombas.</h5>
                                    <p> Interessados, favor entrar em contato com o setor de PCM</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/sisman.site/arquivos/avisos/setembro.png" class="d-block w-100" alt="setembro amarelo">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Setembro Amarelo</h5>
                                    <p>Em Setembro Amarelo, vamos valorizar a vida e fortalecer a rede de apoio para quem precisa. Falar é a melhor solução.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/sisman.site/arquivos/avisos/uni.png" class="d-block w-100" alt="uni">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Unicesusmar</h5>
                                    <p>Vídeo Apresentação</p>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls1" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls1" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

                <div class="carousel-container">
                    <div id="carouselExampleControls2" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div id="chart_div"></div>
                            </div>
                            <div class="carousel-item">
                                <img src="/sisman.site/images/image2.jpg" class="d-block w-100" alt="Imagem 2">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Texto para Imagem 2</h5>
                                    <p>Descrição da segunda imagem.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="/sisman.site/site/images/image3.jpg" class="d-block w-100" alt="Imagem 3">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Texto para Imagem 3</h5>
                                    <p>Descrição da terceira imagem.</p>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>


                <!-- gráfico aqui -->
                
                
            </div>
        </div>    
    </header>
    <main>
        <!-- Additional main content -->
    </main>
    <footer>
        <!-- Your footer content here -->
    </footer>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/sisman.site/js/home.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            var data = google.visualization.arrayToDataTable([
                ['Dia', <?php echo "'" . implode("','", $tipos_os) . "', 'Média'"; ?>], // Adiciona 'Média' como cabeçalho

                <?php
                $dados_formatados = [];
                $dias = array_reverse(array_map(function($i) {
                    return date('Y-m-d', strtotime("-$i days"));
                }, range(0, 3)));

                foreach ($dias as $dia) {
                    $dados_formatados[$dia] = array_fill_keys($tipos_os, 0);
                }

                foreach ($dados as $dado) {
                    $dia = $dado['dia'];
                    $tipo_os = $dado['tipo_os'];
                    $total = $dado['total'];
                    $dados_formatados[$dia][$tipo_os] = $total;
                }

                foreach ($dados_formatados as $dia => $tipos) {
                    $media = array_sum($tipos) / count($tipos); // Calcula a média
                    echo "['$dia', " . implode(", ", $tipos) . ", $media],"; // Adiciona a média aos dados
                }
                ?>
            ]);

            var options = {
                title: 'Quantidade de Ordens Criadas nos últimos Dias',
                vAxis: {title: 'Quantidade'},
                hAxis: {title: 'Dias'},
                seriesType: 'bars',
                series: {<?php echo count($tipos_os); ?>: {type: 'line'}} // A última série é a linha da média
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
        function deleteNotification(id) {
            $.ajax({
                url: '/site/models/delete_notification.php',
                type: 'POST',
                data: {id: id},
                success: function(response) {
                    console.log(response); // Log response for debugging
                    if (response.trim() === 'success') {
                        $('#notification-' + id).remove();
                    } else {
                        alert('Erro ao excluir notificação: ' + response);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('AJAX error: ' + textStatus + ': ' + errorThrown);
                }
            });
        }
    </script>

</body>
</html>
