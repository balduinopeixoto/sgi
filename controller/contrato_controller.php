<?php
session_start();
require_once '../model/contrato.php';
require_once 'contrato_pdf.php';
require_once '../conexao/conexao.php';

$acao = $_GET['acao'] ?? '';

// ======================================================
// Cadastrar novo contrato
// ======================================================
if ($acao === 'cadastrar') {
    $imovel_id       = $_POST['imovel_id'] ?? '';
    $usuario_id      = $_SESSION['idusuario'] ?? '';
    $cliente_id      = $_POST['cliente_id'] ?? '';
    $tipo            = $_POST['tipo'] ?? '';
    $valor           = $_POST['valor'] ?? '';
    $data_inicio     = $_POST['data_inicio'] ?? '';
    $data_fim        = $_POST['data_fim'] ?? '';
    $forma_pagamento = $_POST['forma_pagamento'] ?? 'avista';
    $numero_parcelas = $_POST['numero_parcelas'] ?? null;
    $valor_parcela   = $_POST['valor_parcela'] ?? null;
    $data_assinatura = $_POST['data_assinatura'] ?? '';
    $observacoes     = $_POST['observacoes'] ?? '';

    if (empty($imovel_id) || empty($cliente_id)) {
    echo "<script>alert('Por favor, selecione o imóvel e o cliente.'); history.back();</script>";
    exit;
}

    // Verifica duplicidade de contrato
    if (Contrato::existeAtivo($imovel_id, $cliente_id, $tipo)) {
        
           echo "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='utf-8'>
                <script src='../app/admin/sweetalert2.js'></script>
            </head>
            <body>
            <script>
            Swal.fire({
                icon: 'warning',
                title: 'Contrato duplicado',
                text: 'Este cliente já possui um contrato ativo para este imóvel.'
            }).then(() => {
                        window.location.href = '../app/admin/?page=contrato';
                    });
            </script>
            </body>
            </html>";
            exit;

            exit;

    }

        $nomeArquivo = '';
       if (!empty($_FILES['file']['name'])) {

            $diretorioDestino = "../app/assets/anexo/";

            // Cria diretório se não existir
            if (!is_dir($diretorioDestino)) {
                mkdir($diretorioDestino, 0777, true);
            }

            // Gera nome único
            $extensao = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $nomeArquivo = uniqid("anexo_") . "." . $extensao;

            $destino = $diretorioDestino . $nomeArquivo;

            move_uploaded_file($_FILES['file']['tmp_name'], $destino);
        }


    $idcontrato=Contrato::save($imovel_id, $usuario_id, $cliente_id, $tipo, $valor, $data_inicio, $data_fim, $forma_pagamento, $numero_parcelas, $valor_parcela, $data_assinatura, $observacoes, $nomeArquivo);
   
    if ($idcontrato>0) {

       

           $pdfPath = ContratoPDF::GERAR_CONTRATO_PDF($idcontrato);
           
           $pdfUrl = str_replace("../", "", $pdfPath); // torna o caminho acessível via navegador

              // Atualiza o estado do imóvel para 'Alugado' ou 'Vendido', conforme o tipo do contrato
              $estado = 'disponível';
           if ($tipo === 'aluguel') {
                $estado = 'alugado';
              } elseif ($tipo === 'venda') {
                $estado = 'vendido';
           }

            $updateSql = "UPDATE imovel SET estado = :estado WHERE idimovel = :id";
            $conexao = ligar();
            $stmt = $conexao->prepare($updateSql);
            $stmt->bindValue(':estado', $estado);
            $stmt->bindValue(':id', $imovel_id);
            $stmt->execute();

    echo "
    <!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <script src='../app/admin/sweetalert2.js'></script>
</head>
<body>
  
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Contrato cadastrado com sucesso!',
            html: `
                <p>O contrato foi gerado com sucesso.</p>
                <a href='../$pdfUrl' target='_blank' class='swal2-confirm swal2-styled' style='background-color:#3085d6;'>📄 Visualizar PDF</a>
                <a href='../$pdfUrl' download class='swal2-confirm swal2-styled' style='background-color:#28a745;'>⬇️ Baixar PDF</a>
            `,
            showCancelButton: true,
            cancelButtonText: 'Voltar',
            confirmButtonText: 'OK',
        }).then(() => {
            window.location.href = '../app/admin/?page=contrato';
        });
    </script>
    
    </body>
</html>";
    } else {
        echo "
            <!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <script src='../app/admin/sweetalert2.js'></script>
</head>
<body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Falha ao cadastrar contrato.'
            }).then(() => {
                window.location.href = '../app/admin/?page=contrato';
            });
        </script>
        </body>
</html>";
    }
}

// ======================================================
// Editar contrato
// ======================================================
if ($acao === 'editar') {
    $idcontrato      = $_POST['idcontrato'] ?? '';
    $valor           = $_POST['valor'] ?? '';
    $data_fim        = $_POST['data_fim'] ?? '';
    $forma_pagamento = $_POST['forma_pagamento'] ?? '';
    $numero_parcelas = $_POST['numero_parcelas'] ?? null;
    $valor_parcela   = $_POST['valor_parcela'] ?? null;
    $status          = $_POST['status'] ?? 'ativo';
    $observacoes     = $_POST['observacoes'] ?? '';


      $nomeArquivo = '';
        if (!empty($_FILES['file']['name'])) {

            $diretorioDestino = "../app/assets/anexo/";

            // Cria diretório se não existir
            if (!is_dir($diretorioDestino)) {
                mkdir($diretorioDestino, 0777, true);
            }

            // Gera nome único
            $extensao = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $nomeArquivo = uniqid("anexo_") . "." . $extensao;

            $destino = $diretorioDestino . $nomeArquivo;

            move_uploaded_file($_FILES['file']['tmp_name'], $destino);
        }


    if (Contrato::edit($idcontrato, $valor, $data_fim, $forma_pagamento, $numero_parcelas, $valor_parcela, $status, $observacoes,$nomeArquivo)) {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: 'Contrato atualizado com sucesso!'
            }).then(() => {
                window.location.href = '../app/admin/?page=contrato';
            });
        </script>";
    } else {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Falha ao atualizar contrato.'
            }).then(() => {
                window.location.href = '../app/admin/?page=contrato';
            });
        </script>";
    }
}

// ======================================================
// Encerrar contrato
// ======================================================
if ($acao === 'encerrar') {
    $idcontrato = $_GET['idcontrato'] ?? '';

    if (Contrato::encerrar($idcontrato)) {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Contrato Encerrado',
                text: 'O contrato foi encerrado com sucesso.'
            }).then(() => {
                window.location.href = '../app/admin/?page=contrato';
            });
        </script>";
    } else {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Não foi possível encerrar o contrato.'
            }).then(() => {
                window.location.href = '../app/admin/?page=contrato';
            });
        </script>";
    }
}



