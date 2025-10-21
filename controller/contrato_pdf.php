<?php
use Mpdf\Mpdf;

require_once '../conexao/conexao.php';
require_once '../app/utils/vendor/autoload.php';
require_once '../app/utils/mpdf/vendor/autoload.php';

class ContratoPDF {
    public static function GERAR_CONTRATO_PDF($idcontrato) {
        error_reporting(E_ALL & ~E_DEPRECATED);
        ob_clean();
        $conexao = ligar();

        $sql = "SELECT idcontrato, imovel_id, cliente_id, C.tipo, valor, data_inicio, data_fim, 
                       forma_pagamento, numero_parcelas, valor_parcela, data_assinatura, 
                       C.status, C.observacoes, CL.nome, M.titulo 
                FROM contrato C
                INNER JOIN imovel M ON (C.imovel_id = M.idimovel)
                INNER JOIN cliente CL ON (C.cliente_id = CL.idcliente)
                WHERE idcontrato = :idcontrato";

        $busca = $conexao->prepare($sql);
        $busca->bindParam(':idcontrato', $idcontrato);
        $busca->execute();
        $dados = $busca->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            echo "<script>alert('Contrato não encontrado!'); window.close();</script>";
            exit;
        }

        $valor_formatado = number_format($dados['valor'], 2, ',', '.');
        $valor_parcela_formatado = number_format($dados['valor_parcela'], 2, ',', '.');
        $data_inicio = date('d/m/Y', strtotime($dados['data_inicio']));
        $data_fim = date('d/m/Y', strtotime($dados['data_fim']));
        $data_assinatura = date('d/m/Y', strtotime($dados['data_assinatura']));

        $html = "
        <style>
            body {
                font-family: 'DejaVu Sans', sans-serif;
                margin: 40px;
                color: #333;
                background-color: #fff;
            }

            h1, h2, h3, h4 {
                text-align: center;
                color: #2c3e50;
            }

            h2 {
                text-transform: uppercase;
                font-size: 20px;
                border-bottom: 2px solid #2c3e50;
                display: inline-block;
                padding-bottom: 4px;
            }

            .cabecalho {
                text-align: center;
                margin-bottom: 20px;
            }

            .cabecalho small {
                display: block;
                color: #777;
            }

            .info-box {
                background: #f8f9fa;
                padding: 15px 25px;
                border-radius: 8px;
                margin-bottom: 25px;
                border: 1px solid #ddd;
            }

            .info-box p {
                font-size: 14px;
                margin: 6px 0;
            }

            .tabela-info {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .tabela-info th, .tabela-info td {
                border: 1px solid #ccc;
                padding: 8px;
                font-size: 13px;
            }

            .tabela-info th {
                background-color: #f2f2f2;
                text-align: left;
                font-weight: bold;
            }

            .texto {
                font-size: 14px;
                line-height: 1.6;
                text-align: justify;
                margin-top: 20px;
            }

            .assinaturas {
                margin-top: 60px;
                display: flex;
                justify-content: space-between;
            }

            .assinaturas div {
                width: 45%;
                text-align: center;
                font-size: 14px;
            }

            .linha-assinatura {
                border-top: 1px solid #000;
                margin-top: 50px;
                width: 80%;
                margin-left: auto;
                margin-right: auto;
            }

            footer {
                text-align: center;
                font-size: 11px;
                color: #777;
                margin-top: 40px;
            }
        </style>

        <div class='cabecalho'>
            <h2>Contrato de " . strtoupper($dados['tipo']) . "</h2>
            <small>Código do Contrato: <strong>{$dados['idcontrato']}</strong></small>
            <small>Status: <strong style='color:green'>{$dados['status']}</strong></small>
        </div>

        <div class='info-box'>
            <p><strong>Imóvel:</strong> {$dados['titulo']}</p>
            <p><strong>Cliente:</strong> {$dados['nome']}</p>
            <p><strong>Tipo:</strong> {$dados['tipo']}</p>
            <p><strong>Valor total:</strong> AOA {$valor_formatado}</p>
            <p><strong>Forma de pagamento:</strong> {$dados['forma_pagamento']}</p>
            <p><strong>Número de parcelas/Mensalidade:</strong> " . ($dados['numero_parcelas'] ?: '-') . "</p>
            <p><strong>Valor por parcela:</strong> " . ($dados['valor_parcela'] ? 'AOA ' . $valor_parcela_formatado : '-') . "</p>
            <p><strong>Data de início:</strong> {$data_inicio}</p>
            <p><strong>Data de término:</strong> {$data_fim}</p>
            <p><strong>Data de assinatura:</strong> {$data_assinatura}</p>
        </div>

        <table class='tabela-info'>
            <tr><th>Observações</th></tr>
            <tr><td>{$dados['observacoes']}</td></tr>
        </table>

        <div class='texto'>
            <p>Pelo presente instrumento, as partes acima identificadas têm entre si justo e contratado o presente contrato 
            de <strong>{$dados['tipo']}</strong> do imóvel denominado <strong>{$dados['titulo']}</strong>, conforme as condições aqui descritas e de acordo com a legislação vigente.</p>

            <p>O cliente declara estar ciente de todas as cláusulas e condições, comprometendo-se a cumpri-las fielmente.</p>
        </div>

        <div class='assinaturas'>
            <div>
                <div class='linha-assinatura'></div>
                <strong>{$dados['nome']}</strong><br>
                Cliente
            </div>
            <div>
                <div class='linha-assinatura'></div>
                <strong>Gestor Imobiliário</strong><br>
                Representante
            </div>
        </div>

        <footer>Gerado automaticamente em " . date('d/m/Y H:i') . "</footer>
        ";

        // Caminho de saída
        $diretorio = "../app/assets/contratos/";
        if (!is_dir($diretorio)) mkdir($diretorio, 0777, true);

        $nomeSanitizado = preg_replace('/[^A-Za-z0-9_\-]/', '_', $dados['nome']);
        $nomeArquivo = "contrato_{$nomeSanitizado}_{$dados['idcontrato']}.pdf";
        $caminhoArquivo = $diretorio . $nomeArquivo;

        $mpdf = new Mpdf(['format' => 'A4']);
        $mpdf->WriteHTML($html);
        $mpdf->Output($caminhoArquivo, \Mpdf\Output\Destination::FILE);

        return $caminhoArquivo;
    }
}
