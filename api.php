<?php
require_once './conexao/conexao.php';
header('Content-Type: application/json');

$pdo = ligar();

// Função para obter dados gerais do dashboard
function getDashboardData($pdo) {
    $data = [];
    
    // Total de postos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM postos_registo");
    $data['total_postos'] = $stmt->fetchColumn();
    
    // Postos funcionais
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM postos_registo WHERE condicao_posto = 'Funcional'");
    $data['postos_funcionais'] = $stmt->fetchColumn();
    
    // Taxa de postos funcionais
    $data['taxa_funcionais'] = $data['total_postos'] > 0 ? 
        round(($data['postos_funcionais'] / $data['total_postos']) * 100, 1) : 0;
    
    // Total de nascimentos
    $stmt = $pdo->query("SELECT SUM(CAST(numero_nascimentos AS UNSIGNED)) as total FROM postos_registo WHERE numero_nascimentos != ''");
    $data['total_nascimentos'] = $stmt->fetchColumn() ?: 0;
    
    // Média de vacinação
    $stmt = $pdo->query("SELECT media_vacinacao FROM postos_registo WHERE media_vacinacao != ''");
    $medias = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $data['media_vacinacao'] = calcularMediaVacinacao($medias);
    
    return $data;
}

// Função para calcular média de vacinação
function calcularMediaVacinacao($medias) {
    $valores = [];
    
    foreach ($medias as $media) {
        if (strpos($media, '-') !== false) {
            $partes = explode('-', $media);
            $min = intval(trim($partes[0]));
            $max = intval(trim($partes[1] ?? $partes[0]));
            $valores[] = ($min + $max) / 2;
        } else {
            $valores[] = intval($media);
        }
    }
    
    return count($valores) > 0 ? round(array_sum($valores) / count($valores)) : 0;
}

// Função para obter distribuição por estado
function getDistribuicaoEstado($pdo) {
    $stmt = $pdo->query("
        SELECT 
            condicao_posto as estado,
            COUNT(*) as quantidade
        FROM postos_registo 
        GROUP BY condicao_posto
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para obter distribuição por tipo de unidade
function getDistribuicaoTipoUnidade($pdo) {
    $stmt = $pdo->query("
        SELECT 
            tipo_unidade as tipo,
            COUNT(*) as quantidade
        FROM postos_registo 
        WHERE tipo_unidade != ''
        GROUP BY tipo_unidade
        ORDER BY quantidade DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para obter distribuição por província
function getDistribuicaoProvincia($pdo) {
    $stmt = $pdo->query("
        SELECT 
            provincia,
            COUNT(*) as quantidade
        FROM postos_registo 
        WHERE provincia != ''
        GROUP BY provincia
        ORDER BY quantidade DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para obter dados de vacinação por tipo
function getVacinacaoPorTipo($pdo) {
    $stmt = $pdo->query("
        SELECT 
            tipo_unidade,
            media_vacinacao
        FROM postos_registo 
        WHERE tipo_unidade != '' AND media_vacinacao != ''
    ");
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $agrupado = [];
    foreach ($dados as $linha) {
        $tipo = $linha['tipo_unidade'];
        $media = $linha['media_vacinacao'];
        
        if (!isset($agrupado[$tipo])) {
            $agrupado[$tipo] = [];
        }
        
        if (strpos($media, '-') !== false) {
            $partes = explode('-', $media);
            $min = intval(trim($partes[0]));
            $max = intval(trim($partes[1] ?? $partes[0]));
            $agrupado[$tipo][] = ($min + $max) / 2;
        } else {
            $agrupado[$tipo][] = intval($media);
        }
    }
    
    $resultado = [];
    foreach ($agrupado as $tipo => $valores) {
        $resultado[] = [
            'tipo' => $tipo,
            'media_vacinacao' => round(array_sum($valores) / count($valores))
        ];
    }
    
    return $resultado;
}

// Função para obter lista de postos (para tabela)
function getListaPostos($pdo, $filtros = []) {
    $where = [];
    $params = [];
    
    if (!empty($filtros['provincia'])) {
        $where[] = "provincia = ?";
        $params[] = $filtros['provincia'];
    }
    
    if (!empty($filtros['municipio'])) {
        $where[] = "municipio = ?";
        $params[] = $filtros['municipio'];
    }
    
    if (!empty($filtros['tipo_unidade'])) {
        $where[] = "tipo_unidade = ?";
        $params[] = $filtros['tipo_unidade'];
    }
    
    if (!empty($filtros['condicao_posto'])) {
        $where[] = "condicao_posto = ?";
        $params[] = $filtros['condicao_posto'];
    }
    
    $whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";
    
    $sql = "
        SELECT 
            unidade_sanitaria,
            provincia,
            municipio,
            comuna,
            bairro,
            tipo_unidade,
            condicao_posto,
            numero_nascimentos,
            media_vacinacao,
            data_submissao
        FROM postos_registo 
        $whereClause
        ORDER BY data_submissao DESC
        LIMIT 100
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para obter opções de filtro
function getFiltros($pdo) {
    $filtros = [];
    
    // Províncias
    $stmt = $pdo->query("SELECT DISTINCT provincia FROM postos_registo WHERE provincia != '' ORDER BY provincia");
    $filtros['provincias'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Municípios
    $stmt = $pdo->query("SELECT DISTINCT municipio FROM postos_registo WHERE municipio != '' ORDER BY municipio");
    $filtros['municipios'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Tipos de unidade
    $stmt = $pdo->query("SELECT DISTINCT tipo_unidade FROM postos_registo WHERE tipo_unidade != '' ORDER BY tipo_unidade");
    $filtros['tipos_unidade'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Estados
    $stmt = $pdo->query("SELECT DISTINCT condicao_posto FROM postos_registo WHERE condicao_posto != '' ORDER BY condicao_posto");
    $filtros['estados'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    return $filtros;
}

// Processar requisição
$action = $_GET['action'] ?? 'dashboard';

try {
    switch ($action) {
        case 'dashboard':
            $response = [
                'kpis' => getDashboardData($pdo),
                'distribuicao_estado' => getDistribuicaoEstado($pdo),
                'distribuicao_tipo' => getDistribuicaoTipoUnidade($pdo),
                'distribuicao_provincia' => getDistribuicaoProvincia($pdo),
                'vacinacao_tipo' => getVacinacaoPorTipo($pdo)
            ];
            break;
            
        case 'lista_postos':
            $filtros = [
                'provincia' => $_GET['provincia'] ?? '',
                'municipio' => $_GET['municipio'] ?? '',
                'tipo_unidade' => $_GET['tipo_unidade'] ?? '',
                'condicao_posto' => $_GET['condicao_posto'] ?? ''
            ];
            $response = getListaPostos($pdo, $filtros);
            break;
            
        case 'filtros':
            $response = getFiltros($pdo);
            break;
            
        default:
            $response = ['error' => 'Ação não reconhecida'];
    }
    
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>