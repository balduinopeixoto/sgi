<?php
ini_set('max_execution_time', 0);

require_once '../modelo/Imovel.php';

$acao = $_GET['acao'] ?? '';

if ($acao === 'cad_imovel') {
    $usuario_id = $_POST['usuario_id'] ?? '';
    $titulo     = $_POST['titulo'] ?? '';
    $descricao  = $_POST['descricao'] ?? '';
    $tipo       = $_POST['tipo'] ?? '';
    $preco      = $_POST['preco'] ?? '';
    $area       = $_POST['area'] ?? '';
    $quartos    = $_POST['quartos'] ?? '';
    $banheiros  = $_POST['banheiros'] ?? '';
    $garagem    = $_POST['garagem'] ?? '';
    $endereco   = $_POST['endereco'] ?? '';
    $lat        = $_POST['lat'] ?? '';
    $lng        = $_POST['lng'] ?? '';

    if (Imovel::save($usuario_id, $titulo, $descricao, $tipo, $preco, $area, $quartos, $banheiros, $garagem, $endereco, $lat, $lng)) {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='../assets/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: 'Imóvel cadastrado com sucesso!'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=imoveis';
                });
            </script>
        </body>
        </html>";
    } else {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='../assets/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Falha ao cadastrar imóvel.'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=cadastro-imovel';
                });
            </script>
        </body>
        </html>";
    }
}

if ($acao === 'editar_status') {
    $id     = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? 'disponivel';

    if (Imovel::updateStatus($id, $status)) {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='../assets/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: 'Status do imóvel atualizado!'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=imoveis';
                });
            </script>
        </body>
        </html>";
    } else {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='../assets/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Falha ao atualizar status do imóvel.'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=imoveis';
                });
            </script>
        </body>
        </html>";
    }
}
