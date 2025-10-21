<?php
// =====================
// CONFIGURAÇÃO INICIAL
// =====================
$uid = "ajm8JonK3LYZuAT5nFLcER"; // UID do teu formulário
$token = "b87374405e068f39e53e12f80ad7068df14481ba"; // <-- substitui pelo teu token real

// Endpoint da API KoboToolbox
$url = "https://kf.kobotoolbox.org/api/v2/assets/ajm8JonK3LYZuAT5nFLcER/data.json";

// =====================
// FUNÇÃO PARA CHAMADA API
// =====================
function getKoboData($url, $token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Token  $token",
        "Accept: application/json"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        die("Erro cURL: " . $curlError);
    }
    if ($httpCode !== 200) {
        die("Erro HTTP $httpCode ao obter dados do KoboToolbox.");
    }

    return json_decode($response, true);
}

// =====================
// EXECUÇÃO
// =====================
$data = getKoboData($url, $token);

if (!isset($data['results']) || count($data['results']) === 0) {
    die("Nenhum dado encontrado no KoboToolbox.");
}


// =====================
// TABELA HTML DINÂMICA ESTILIZADA + GRÁFICOS
// =====================

echo "<h2 style='font-family:Segoe UI, Arial; color:#333; margin-bottom:10px;'>📊 Dashboard - Dados KoboToolbox / Formulário - Mapeamento dos Serviços da Justiça</h2>";

// Verifica se há dados
if (!isset($data['results']) || empty($data['results'])) {
    echo "<p style='color:red; font-family:Arial;'>Nenhum dado encontrado.</p>";
    exit;
}

// Tabela container com rolagem
echo "<div style='max-height:600px; overflow:auto; border:1px solid #ddd; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1);'>";

echo "<table id='dadosTable' style='border-collapse:collapse; width:100%; font-family:Segoe UI, Arial; font-size:14px;'>";
echo "<thead style='position:sticky; top:0; background:#007bff; color:white;'>";
echo "<tr>";

// Coluna de número
echo "<th style='padding:10px; text-align:center;'>#</th>";

// Cabeçalhos dinâmicos
$columns = array_keys($data['results'][0]);
foreach ($columns as $col) {
    echo "<th style='padding:10px; text-align:left;'>" . htmlspecialchars($col) . "</th>";
}
echo "</tr></thead><tbody>";

$linha = 1;
foreach ($data['results'] as $row) {
    echo "<tr style='background:" . ($linha % 2 == 0 ? "#f9f9f9" : "white") . ";'>";
    echo "<td style='text-align:center; font-weight:bold; padding:8px;'>$linha</td>";
    foreach ($columns as $col) {
        $value = isset($row[$col]) ? $row[$col] : '';
        if (is_array($value)) $value = json_encode($value);
        echo "<td style='padding:8px; border-bottom:1px solid #eee;'>" . htmlspecialchars($value) . "</td>";
    }
    echo "</tr>";
    $linha++;
}

echo "</tbody></table>";
echo "</div>";




// DASHBOARDS MULTIPLOS
// =====================

// Função auxiliar para gerar contagem por campo
function contarPorCampo($data, $campo) {
    $contagem = [];
    foreach ($data['results'] as $row) {
        $valor = isset($row[$campo]) && $row[$campo] !== '' ? trim($row[$campo]) : 'Não informado';
        $contagem[$valor] = ($contagem[$valor] ?? 0) + 1;
    }
    return $contagem;
}

// 1️⃣ Distribuição por Província
$campoProvincia = "group_zz5ac16/Provincia";
$provContagem = contarPorCampo($data, $campoProvincia);

// 2️⃣ Tipo de Instituição
$campoTipo = "group_zz5ac16/Infraestrutura"; // ajusta conforme o nome real do campo no teu Excel
$tipoContagem = contarPorCampo($data, $campoTipo);

// 3️⃣ Estado de Funcionamento
$campoStatus = "group_zz5ac16/Tipologia_de_Servi_os"; // exemplo: Ativo, Inativo, Em reforma
$statusContagem = contarPorCampo($data, $campoStatus);

// 4️⃣ Acesso à Internet (Sim/Não)
$campoInternet = "group_bh3sd93/Tem_internet"; // campo binário
$internetContagem = contarPorCampo($data, $campoInternet);

// Converter para JSON para usar no JavaScript
$labelsProv = json_encode(array_keys($provContagem), JSON_UNESCAPED_UNICODE);
$valProv = json_encode(array_values($provContagem), JSON_UNESCAPED_UNICODE);

$labelsTipo = json_encode(array_keys($tipoContagem), JSON_UNESCAPED_UNICODE);
$valTipo = json_encode(array_values($tipoContagem), JSON_UNESCAPED_UNICODE);

$labelsStatus = json_encode(array_keys($statusContagem), JSON_UNESCAPED_UNICODE);
$valStatus = json_encode(array_values($statusContagem), JSON_UNESCAPED_UNICODE);

$labelsInternet = json_encode(array_keys($internetContagem), JSON_UNESCAPED_UNICODE);
$valInternet = json_encode(array_values($internetContagem), JSON_UNESCAPED_UNICODE);

?>

<!-- ===================== -->
<!-- DASHBOARD VISUAL -->
<!-- ===================== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h2 style="font-family:Arial; text-align:center; margin-top:40px;">📊 Painel de Indicadores - Serviços da Justiça</h2>

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(400px,1fr)); gap:40px; padding:30px;">

    <!-- Distribuição por Província -->
    <div style="background:#fff; border-radius:10px; padding:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <h4 style="text-align:center; color:#007bff;">Distribuição por Província</h4>
        <canvas id="graficoProvincia"></canvas>
    </div>

    <!-- Tipo de Instituição -->
    <div style="background:#fff; border-radius:10px; padding:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <h4 style="text-align:center; color:#007bff;">Tipos de Instituição</h4>
        <canvas id="graficoTipo"></canvas>
    </div>

    <!-- Estado do Serviço -->
    <div style="background:#fff; border-radius:10px; padding:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <h4 style="text-align:center; color:#007bff;">Estado de Funcionamento</h4>
        <canvas id="graficoStatus"></canvas>
    </div>

    <!-- Acesso à Internet -->
    <div style="background:#fff; border-radius:10px; padding:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <h4 style="text-align:center; color:#007bff;">Acesso à Internet</h4>
        <canvas id="graficoInternet"></canvas>
    </div>
</div>

<script>
function criarGrafico(id, tipo, labels, valores, titulo, cor='rgba(54,162,235,0.7)') {
    new Chart(document.getElementById(id), {
        type: tipo,
        data: {
            labels: labels,
            datasets: [{
                label: titulo,
                data: valores,
                backgroundColor: cor,
                borderColor: cor.replace('0.7', '1'),
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: titulo }
            },
            scales: tipo === 'bar' ? { y: { beginAtZero: true } } : {}
        }
    });
}

// Renderizar gráficos
criarGrafico('graficoProvincia', 'bar', <?= $labelsProv ?>, <?= $valProv ?>, 'Distribuição por Província');
criarGrafico('graficoTipo', 'pie', <?= $labelsTipo ?>, <?= $valTipo ?>, 'Tipos de Instituição');
criarGrafico('graficoStatus', 'doughnut', <?= $labelsStatus ?>, <?= $valStatus ?>, 'Estado do Serviço');
criarGrafico('graficoInternet', 'bar', <?= $labelsInternet ?>, <?= $valInternet ?>, 'Acesso à Internet');
</script>


