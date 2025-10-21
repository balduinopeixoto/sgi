<?php

require_once './conexao/conexao.php';
$pdo = ligar();

// =====================
// DICIONÁRIO DE LIMPEZA DOS DADOS
// =====================
$dicionario = [
    // --- Tipo de Unidade ---
    'hospital_materno_infatil' => 'Hospital Materno Infantil',
    'centro_materno_infatil' => 'Centro Materno Infantil',
    'hospital_geral' => 'Hospital Geral',
    'hospital_municipal' => 'Hospital Municipal',
    'maternidade' => 'Maternidade',
    
    // --- Estado da Infraestrutura ---
    'pintura' => 'Pintura',
    'substitui_o_de_l_mpadas_e_toma' => 'Substituição de Lâmpadas e Tomadas',
    'substituicao_de_lampadas_e_tomadas' => 'Substituição de Lâmpadas e Tomadas',
    'reparacao_e/ou_substituicao_de_fechadura' => 'Reparação de Fechadura',
    'repara_o_e_ou_substitui_o_de_f' => 'Reparação de Fechadura',
    'danifica_o_parcial_do_tecto' => 'Danos Parciais no Tecto',
    'danificacao_parcial_do_tecto' => 'Danos Parciais no Tecto',
    'outro' => 'Outro',
    
    // --- Estado Geral da Unidade ---
    'bom' => 'Bom',
    'razoavel' => 'Razoável',
    'mau' => 'Mau',
    
    // --- Estado de Funcionamento ---
    'funcional' => 'Funcional',
    'nao_funcional' => 'Não Funcional',
    
    // --- Tipo de Energia ---
    'rede_publica' => 'Rede Pública',
    'gerador' => 'Gerador',
    'renovavel' => 'Energia Renovável',
    
    // --- Tipo de Água ---
    'rede_publica' => 'Rede Pública',
    'gerador' => 'Gerador',
    'renovavel' => 'Fonte Renovável',
    
    // --- Tipo de Acesso ---
    'terra_batida' => 'Terra Batida',
    'asfalto' => 'Asfalto',
    'picada' => 'Picada',
    
    // --- Meio de Transporte ---
    'a_pe' => 'A Pé',
    'a_pé' => 'A Pé',
    'motorizada_de_2_rodas' => 'Motorizada de 2 Rodas',
    'motorizada_de_3_rodas' => 'Motorizada de 3 Rodas',
    'taxi_azul_ou_branco' => 'Táxi Azul ou Branco',
    'taxi_por_aplicativo' => 'Táxi por Aplicativo',
    'autocarro_publico' => 'Autocarro Público',
    
    // --- Serviços Disponíveis ---
    'equipamento_informatico_e_mobiliario' => 'Equipamento Informático e Mobiliário',
    'equipamento_mobiliario' => 'Equipamento Mobiliário',
    'sistema_de_envio_de_informacoes_offline' => 'Sistema de Envio de Informações Offline',
    'sistema_de_envio_de_informacoes_online' => 'Sistema de Envio de Informações Online',
    'servicos_de_envio_online_e_off' => 'Serviços de Envio Online e Offline',
    'servico_de_internet_na_estrutura_1' => 'Serviço de Internet na Estrutura',
    
    // --- Equipamentos Informáticos ---
    'computadores' => 'Computadores',
    'impressoras' => 'Impressoras',
    'scanners' => 'Scanners',
    'ups' => 'UPS',
    'fotocopiadoras' => 'Fotocopiadoras',
    'maquina_fotografica' => 'Máquina Fotográfica',
    'topas__recolha_de_assinaturas' => 'Topas - Recolha de Assinaturas',
    'crossmatch__recolha_de_impressao_digital' => 'Crossmatch - Recolha de Impressão Digital',
    
    // --- Mobiliário ---
    'cadeiras_para_funcionarios' => 'Cadeiras para Funcionários',
    'cadeiras_para_os_utentes' => 'Cadeiras para Utentes',
    'cadeiras_para_sala_de_espera' => 'Cadeiras para Sala de Espera',
    'secretaria' => 'Secretária',
    'bloco_de_gavetas' => 'Bloco de Gavetas',
    'armario' => 'Armário',
    
    // --- Média de Vacinação ---
    '50___100' => '50 - 100',
    '100___150' => '100 - 150',
    '150___200' => '150 - 200',
    '200___250' => '200 - 250',
    '250___300' => '250 - 300',
    '300___350' => '300 - 350',
    '350___400' => '350 - 400',
    '400___450' => '400 - 450',
    '450___500' => '450 - 500',
    '500___550' => '500 - 550',
    '550_em_diante' => '550 em diante',
    '550' => '550',
];

// =====================
// FUNÇÕES DE PROCESSAMENTO
// =====================

// FUNÇÃO PARA PROCESSAR STRINGS COM MÚLTIPLOS VALORES
function processarMultiplosValores($string, $dicionario) {
    if (empty($string) || $string === 'null') {
        return '';
    }
    
    $valores = explode(' ', $string);
    $resultado = [];
    
    foreach ($valores as $valor) {
        if (isset($dicionario[$valor])) {
            $resultado[] = $dicionario[$valor];
        } else {
            // Se não encontrar no dicionário, mantém o original
            $resultado[] = $valor;
        }
    }
    
    return implode(', ', $resultado);
}

// FUNÇÃO PARA PROCESSAR COLUNAS ESPECÍFICAS
function processarColuna($coluna, $valor, $dicionario) {
    // Colunas que podem conter múltiplos valores separados por espaço
    $colunasMultiplas = [
        'servicos_disponiveis',
        'descricao_servicos', 
        'lista_equipamentos',
        'meios_transporte',
        'sistema_energia',
        'sistema_agua',
        'especifique_estado'
    ];
    
    if (in_array($coluna, $colunasMultiplas) && !empty($valor)) {
        return processarMultiplosValores($valor, $dicionario);
    }
    
    // Para colunas únicas
    if (isset($dicionario[$valor])) {
        return $dicionario[$valor];
    }
    
    return $valor;
}

// =====================
// CONFIGURAÇÃO INICIAL
// =====================
$uid = "aYmXoTRnHxog7eSEYcoRM7";
$token = "b87374405e068f39e53e12f80ad7068df14481ba";
$url = "https://kf.kobotoolbox.org/api/v2/assets/$uid/data.json";

// =====================
// FUNÇÃO PARA OBTER DADOS DO KOBO
// =====================
function getKoboData($url, $token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Token $token",
        "Accept: application/json"
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) die("Erro cURL: " . $curlError);
    if ($httpCode !== 200) die("Erro HTTP $httpCode ao obter dados do KoboToolbox.");

    return json_decode($response, true);
}

$data = getKoboData($url, $token);
$registos = $data['results'] ?? [];

if (empty($registos)) {
    die("Nenhum dado retornado pela API KoboToolbox.");
}

// =====================
// INSERÇÃO NA BASE DE DADOS
// =====================
$inseridos = 0;
$existentes = 0;

foreach ($registos as $r) {
    $kobo_id = $r['_id'] ?? null;

    if (!$kobo_id) continue;

    // Verifica se já existe na base
    $check = $pdo->prepare("SELECT COUNT(*) FROM postos_registo WHERE kobo_id = ?");
    $check->execute([$kobo_id]);
    $exists = $check->fetchColumn();

    if ($exists > 0) {
        $existentes++;
        continue; // já existe, não insere
    }

    // Processar os dados com o dicionário antes de inserir
    $dadosProcessados = [
        ':kobo_id' => $kobo_id,
        ':data_submissao' => $r['today'] ?? null,
        ':usuario' => $r['username'] ?? null,
        ':provincia' => processarColuna('provincia', $r['group_pj6io66/Provincia'] ?? null, $dicionario),
        ':municipio' => processarColuna('municipio', $r['group_pj6io66/Municipio'] ?? null, $dicionario),
        ':comuna' => processarColuna('comuna', $r['group_pj6io66/Comuna'] ?? null, $dicionario),
        ':bairro' => $r['group_pj6io66/Indique_o_nome_do_Bairro_ou_al'] ?? null,
        ':unidade_sanitaria' => $r['group_pj6io66/Indique_o_nome_da_unidade_sani'] ?? null,
        ':tipo_unidade' => processarColuna('tipo_unidade', $r['group_pj6io66/Tipo_de_unidade_sanitaria'] ?? null, $dicionario),
        ':localizacao_geografica' => $r['group_pj6io66/Localizacao_geografica'] ?? null,
        ':localizacao_posto' => $r['group_pj6io66/Localizacao_do_posto_na_unidad'] ?? null,
        ':dimensoes_posto' => $r['group_pj6io66/Dimensoes_do_posto'] ?? null,
        ':estado_unidade' => processarColuna('estado_unidade', $r['group_pm7hy97/Estado_da_unidade_sanitaria'] ?? null, $dicionario),
        ':especifique_estado' => processarColuna('especifique_estado', $r['group_pm7hy97/Especique'] ?? null, $dicionario),
        ':descricao_estado' => $r['group_pm7hy97/Descreva_001'] ?? null,
        ':condicao_posto' => processarColuna('condicao_posto', $r['group_xn4kh50/CONDICAO_DO_POSTO_DE_REGISTO_D'] ?? null, $dicionario),
        ':servicos_disponiveis' => processarColuna('servicos_disponiveis', $r['group_xn4kh50/Servi_os_disponiveis'] ?? null, $dicionario),
        ':descricao_servicos' => processarColuna('descricao_servicos', $r['group_xn4kh50/Descreva'] ?? null, $dicionario),
        ':numero_estado_equipamentos' => $r['group_xn4kh50/Indique_o_numero_e_o_estado'] ?? null,
        ':lista_equipamentos' => processarColuna('lista_equipamentos', $r['group_xn4kh50/Lista_de_equipamentos'] ?? null, $dicionario),
        ':estado_mobiliario' => $r['group_xn4kh50/Estado_do_mobiliario'] ?? null,
        ':descricao_mobiliario' => $r['group_xn4kh50/Descreva_003'] ?? null,
        ':sistema_energia' => processarColuna('sistema_energia', $r['group_xn4kh50/Sistema_de_energia_electrica_existente'] ?? null, $dicionario),
        ':sistema_agua' => processarColuna('sistema_agua', $r['group_xn4kh50/Sistema_de_abastecimento_de_agua'] ?? null, $dicionario),
        ':vias_acesso' => processarColuna('vias_acesso', $r['group_nm67c71/Vias_de_acesso_ao_posto'] ?? null, $dicionario),
        ':meios_transporte' => processarColuna('meios_transporte', $r['group_nm67c71/Meio_de_transporte_de_acesso_a'] ?? null, $dicionario),
        ':distancia_acesso' => $r['group_nm67c71/Descreva_a_distancia_de_acesso_ao_posto'] ?? null,
        ':numero_nascimentos' => $r['group_yg5ri20/Numero_de_nascimentos'] ?? null,
        ':media_vacinacao' => processarColuna('media_vacinacao', $r['group_yg5ri20/Media_de_vacinacao'] ?? null, $dicionario),
        ':assinatura' => $r['Assinatura'] ?? null
    ];

    // Inserir novo registo
    $stmt = $pdo->prepare("
        INSERT INTO postos_registo (
            kobo_id, data_submissao, usuario,
            provincia, municipio, comuna, bairro, unidade_sanitaria, tipo_unidade,
            localizacao_geografica, localizacao_posto, dimensoes_posto,
            estado_unidade, especifique_estado, descricao_estado,
            condicao_posto, servicos_disponiveis, descricao_servicos,
            numero_estado_equipamentos, lista_equipamentos,
            estado_mobiliario, descricao_mobiliario, sistema_energia, sistema_agua,
            vias_acesso, meios_transporte, distancia_acesso,
            numero_nascimentos, media_vacinacao, assinatura
        ) VALUES (
            :kobo_id, :data_submissao, :usuario,
            :provincia, :municipio, :comuna, :bairro, :unidade_sanitaria, :tipo_unidade,
            :localizacao_geografica, :localizacao_posto, :dimensoes_posto,
            :estado_unidade, :especifique_estado, :descricao_estado,
            :condicao_posto, :servicos_disponiveis, :descricao_servicos,
            :numero_estado_equipamentos, :lista_equipamentos,
            :estado_mobiliario, :descricao_mobiliario, :sistema_energia, :sistema_agua,
            :vias_acesso, :meios_transporte, :distancia_acesso,
            :numero_nascimentos, :media_vacinacao, :assinatura
        )
    ");

    $stmt->execute($dadosProcessados);
    $inseridos++;
}

echo "<h3>✅ Sincronização concluída!</h3>";
echo "<p><strong>$inseridos</strong> novos registos inseridos.</p>";
echo "<p><strong>$existentes</strong> já existiam na base de dados.</p>";

?>