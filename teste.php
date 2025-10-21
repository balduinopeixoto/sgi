<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Postos de Registo</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        /* Manter o mesmo CSS anterior */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .kpi-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .kpi-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            border-left: 4px solid #2a5298;
        }

        .kpi-card h3 {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .kpi-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 5px;
        }

        .kpi-change {
            font-size: 0.9rem;
            color: #28a745;
        }

        .kpi-change.negative {
            color: #dc3545;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .chart-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #1e3c72;
            text-align: center;
        }

        .chart {
            width: 100%;
            height: 300px;
        }

        .filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .filter-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: white;
            min-width: 150px;
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .data-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #1e3c72;
        }

        .data-table tr:hover {
            background-color: #f5f5f5;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-funcional {
            background-color: #d4edda;
            color: #155724;
        }

        .status-nao-funcional {
            background-color: #f8d7da;
            color: #721c24;
        }

        .export-buttons {
            text-align: right;
            margin-bottom: 20px;
        }

        .export-btn {
            background: #1e3c72;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .export-btn:hover {
            background: #2a5298;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        @media (max-width: 768px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
            
            .chart-container {
                padding: 15px;
            }
            
            .kpi-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Cabeçalho -->
        <div class="header">
            <h1>📊 Dashboard - Postos de Registo</h1>
            <p>Monitoramento e análise dos postos de registo em tempo real</p>
        </div>

        <!-- Filtros -->
        <div class="filters">
            <div class="filter-group">
                <select class="filter-select" id="provinciaFilter">
                    <option value="">Todas as Províncias</option>
                </select>
                <select class="filter-select" id="municipioFilter">
                    <option value="">Todos os Municípios</option>
                </select>
                <select class="filter-select" id="tipoUnidadeFilter">
                    <option value="">Todos os Tipos</option>
                </select>
                <select class="filter-select" id="estadoFilter">
                    <option value="">Todos os Estados</option>
                </select>
                <button class="export-btn" onclick="applyFilters()">Aplicar Filtros</button>
                <button class="export-btn" onclick="resetFilters()">Limpar Filtros</button>
            </div>
        </div>

        <!-- Botões de Exportação -->
        <div class="export-buttons">
            <button class="export-btn" onclick="exportToPDF()">📄 Exportar PDF</button>
            <button class="export-btn" onclick="exportToExcel()">📊 Exportar Excel</button>
            <button class="export-btn" onclick="refreshData()">🔄 Atualizar Dados</button>
        </div>

        <!-- KPIs -->
        <div class="kpi-cards">
            <div class="kpi-card">
                <h3>Total de Postos</h3>
                <div class="kpi-value" id="totalPostos">0</div>
                <div class="kpi-change" id="variacaoPostos">Carregando...</div>
            </div>
            <div class="kpi-card">
                <h3>Postos Funcionais</h3>
                <div class="kpi-value" id="postosFuncionais">0</div>
                <div class="kpi-change" id="taxaFuncionais">0% do total</div>
            </div>
            <div class="kpi-card">
                <h3>Média de Vacinação</h3>
                <div class="kpi-value" id="mediaVacinacao">0</div>
                <div class="kpi-change">por posto</div>
            </div>
            <div class="kpi-card">
                <h3>Total de Nascimentos</h3>
                <div class="kpi-value" id="totalNascimentos">0</div>
                <div class="kpi-change">registados</div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="charts-grid">
            <div class="chart-container">
                <div class="chart-title">📈 Distribuição por Estado de Funcionamento</div>
                <div id="chartEstado" class="chart">
                    <div class="loading">Carregando gráfico...</div>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-title">🏥 Postos por Tipo de Unidade</div>
                <div id="chartTipoUnidade" class="chart">
                    <div class="loading">Carregando gráfico...</div>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-title">🗺️ Distribuição por Província</div>
                <div id="chartProvincia" class="chart">
                    <div class="loading">Carregando gráfico...</div>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-title">📊 Média de Vacinação por Tipo</div>
                <div id="chartVacinacao" class="chart">
                    <div class="loading">Carregando gráfico...</div>
                </div>
            </div>
        </div>

        <!-- Tabela de Dados -->
        <div class="table-container">
            <div class="chart-title">📋 Lista de Postos de Registo</div>
            <table class="data-table" id="postosTable">
                <thead>
                    <tr>
                        <th>Unidade Sanitária</th>
                        <th>Província</th>
                        <th>Município</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Nascimentos</th>
                        <th>Vacinação</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <tr>
                        <td colspan="7" class="loading">Carregando dados...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Carregar Google Charts
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(loadDashboard);

        let dadosDashboard = {};
        let filtrosAtuais = {};

        async function loadDashboard() {
            try {
                await carregarDadosDashboard();
                await carregarFiltros();
                await carregarListaPostos();
                
                atualizarKPIs();
                atualizarGraficos();
                
            } catch (error) {
                console.error('Erro ao carregar dashboard:', error);
                mostrarErro('Erro ao carregar dados do dashboard');
            }
        }

        async function carregarDadosDashboard() {
            const response = await fetch('api.php?action=dashboard');
            if (!response.ok) throw new Error('Erro na API');
            dadosDashboard = await response.json();
        }

        async function carregarFiltros() {
            const response = await fetch('api.php?action=filtros');
            const filtros = await response.json();
            
            popularSelect('provinciaFilter', filtros.provincias);
            popularSelect('municipioFilter', filtros.municipios);
            popularSelect('tipoUnidadeFilter', filtros.tipos_unidade);
            popularSelect('estadoFilter', filtros.estados);
        }

        async function carregarListaPostos(filtros = {}) {
            const params = new URLSearchParams(filtros).toString();
            const response = await fetch(`api.php?action=lista_postos&${params}`);
            const postos = await response.json();
            atualizarTabela(postos);
        }

        function popularSelect(selectId, opcoes) {
            const select = document.getElementById(selectId);
            // Manter a opção padrão e adicionar novas
            const defaultOption = select.options[0];
            select.innerHTML = '';
            select.appendChild(defaultOption);
            
            opcoes.forEach(opcao => {
                const option = document.createElement('option');
                option.value = opcao;
                option.textContent = opcao;
                select.appendChild(option);
            });
        }

        function atualizarKPIs() {
            const kpis = dadosDashboard.kpis;
            
            document.getElementById('totalPostos').textContent = kpis.total_postos;
            document.getElementById('postosFuncionais').textContent = kpis.postos_funcionais;
            document.getElementById('taxaFuncionais').textContent = `${kpis.taxa_funcionais}% do total`;
            document.getElementById('mediaVacinacao').textContent = kpis.media_vacinacao;
            document.getElementById('totalNascimentos').textContent = kpis.total_nascimentos.toLocaleString();
        }

        function atualizarGraficos() {
            // Gráfico de Estado de Funcionamento
            const estadoData = google.visualization.arrayToDataTable([
                ['Estado', 'Quantidade'],
                ...dadosDashboard.distribuicao_estado.map(item => [item.estado, parseInt(item.quantidade)])
            ]);

            const estadoChart = new google.visualization.PieChart(document.getElementById('chartEstado'));
            estadoChart.draw(estadoData, {
                title: '',
                pieHole: 0.4,
                colors: ['#28a745', '#dc3545', '#ffc107'],
                chartArea: {width: '90%', height: '80%'},
                legend: {position: 'labeled'}
            });

            // Gráfico por Tipo de Unidade
            const tipoData = google.visualization.arrayToDataTable([
                ['Tipo', 'Quantidade'],
                ...dadosDashboard.distribuicao_tipo.map(item => [item.tipo, parseInt(item.quantidade)])
            ]);

            const tipoChart = new google.visualization.BarChart(document.getElementById('chartTipoUnidade'));
            tipoChart.draw(tipoData, {
                title: '',
                bars: 'horizontal',
                colors: ['#1e3c72'],
                chartArea: {width: '80%', height: '80%'},
                legend: {position: 'none'}
            });

            // Gráfico por Província
            const provinciaData = google.visualization.arrayToDataTable([
                ['Província', 'Quantidade'],
                ...dadosDashboard.distribuicao_provincia.map(item => [item.provincia, parseInt(item.quantidade)])
            ]);

            const provinciaChart = new google.visualization.ColumnChart(document.getElementById('chartProvincia'));
            provinciaChart.draw(provinciaData, {
                title: '',
                colors: ['#2a5298'],
                chartArea: {width: '80%', height: '80%'},
                legend: {position: 'none'}
            });

            // Gráfico de Vacinação por Tipo
            const vacinacaoData = google.visualization.arrayToDataTable([
                ['Tipo', 'Média de Vacinação'],
                ...dadosDashboard.vacinacao_tipo.map(item => [item.tipo, parseInt(item.media_vacinacao)])
            ]);

            const vacinacaoChart = new google.visualization.BarChart(document.getElementById('chartVacinacao'));
            vacinacaoChart.draw(vacinacaoData, {
                title: '',
                bars: 'horizontal',
                colors: ['#17a2b8'],
                chartArea: {width: '80%', height: '80%'},
                legend: {position: 'none'}
            });
        }

        function atualizarTabela(postos) {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';

            if (postos.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="loading">Nenhum posto encontrado com os filtros aplicados</td></tr>';
                return;
            }

            postos.forEach(posto => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${posto.unidade_sanitaria || 'N/A'}</td>
                    <td>${posto.provincia || 'N/A'}</td>
                    <td>${posto.municipio || 'N/A'}</td>
                    <td>${posto.tipo_unidade || 'N/A'}</td>
                    <td>
                        <span class="status-badge ${posto.condicao_posto === 'Funcional' ? 'status-funcional' : 'status-nao-funcional'}">
                            ${posto.condicao_posto || 'N/A'}
                        </span>
                    </td>
                    <td>${(posto.numero_nascimentos || 0).toLocaleString()}</td>
                    <td>${posto.media_vacinacao || 'N/A'}</td>
                `;
                tbody.appendChild(row);
            });
        }

        function applyFilters() {
            const filtros = {
                provincia: document.getElementById('provinciaFilter').value,
                municipio: document.getElementById('municipioFilter').value,
                tipo_unidade: document.getElementById('tipoUnidadeFilter').value,
                condicao_posto: document.getElementById('estadoFilter').value
            };
            
            filtrosAtuais = filtros;
            carregarListaPostos(filtros);
        }

        function resetFilters() {
            document.getElementById('provinciaFilter').value = '';
            document.getElementById('municipioFilter').value = '';
            document.getElementById('tipoUnidadeFilter').value = '';
            document.getElementById('estadoFilter').value = '';
            
            filtrosAtuais = {};
            carregarListaPostos();
        }

        function refreshData() {
            loadDashboard();
        }

        function exportToPDF() {
            alert('Funcionalidade de exportação PDF em desenvolvimento');
        }

        function exportToExcel() {
            alert('Funcionalidade de exportação Excel em desenvolvimento');
        }

        function mostrarErro(mensagem) {
            alert('Erro: ' + mensagem);
        }

        // Atualizar dados a cada 5 minutos
        setInterval(refreshData, 300000);
    </script>
</body>
</html>