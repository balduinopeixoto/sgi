<?php
session_start();
ini_set('max_execution_time', 0);

require_once '../modelo/Visita.php';

$acao = $_GET['acao'] ?? '';

if ($acao === 'agendar_visita') {
    $imovel_id  = $_POST['imovel_id'] ?? '';
    $usuario_id      = $_SESSION['idusuario'] ?? '';
    $data       = $_POST['data_visita'] ?? '';
    $hora       = $_POST['hora_visita'] ?? '';

    if (Visita::agendar($imovel_id, $usuario_id, $data, $hora)) {
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
                    text: 'Visita agendada com sucesso!'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=visitas';
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
                    text: 'Falha ao agendar visita.'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=cadastro-visita';
                });
            </script>
        </body>
        </html>";
    }
}

if ($acao === 'atualizar_status_visita') {
    $id     = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? 'pendente';

    if (Visita::atualizarStatus($id, $status)) {
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
                    text: 'Status da visita atualizado!'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=visitas';
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
                    text: 'Falha ao atualizar status da visita.'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=visitas';
                });
            </script>
        </body>
        </html>";
    }
}
