<?php
ini_set('max_execution_time', 0);

require_once '../modelo/Usuario.php';

$acao = $_GET['acao'] ?? '';

if ($acao === 'cad_usuario') {
    $nome   = $_POST['nome'] ?? '';
    $email  = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $senha  = password_hash($_POST['senha'] ?? '', PASSWORD_BCRYPT);
    $tipo   = $_POST['tipo'] ?? 'cliente';

    // Verifica duplicidade
    if (Usuario::existe($email)) {
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
                    icon: 'warning',
                    title: 'Aviso',
                    text: 'Este usuário já foi registrado!'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=cadastro-usuario';
                });
            </script>
        </body>
        </html>";
        exit;
    }

    if (Usuario::save($nome, $email, $telefone, $senha, $tipo)) {
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
                    text: 'Usuário cadastrado com sucesso!'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=usuarios';
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
                    text: 'Falha ao cadastrar usuário.'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=cadastro-usuario';
                });
            </script>
        </body>
        </html>";
    }
}

if ($acao === 'editar_usuario') {
    $id     = $_POST['id'] ?? '';
    $nome   = $_POST['nome'] ?? '';
    $email  = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $tipo   = $_POST['tipo'] ?? 'cliente';

    if (Usuario::edit($id, $nome, $email, $telefone, $tipo)) {
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
                    text: 'Usuário editado com sucesso!'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=usuarios';
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
                    text: 'Falha ao editar usuário.'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=usuarios';
                });
            </script>
        </body>
        </html>";
    }
}

if ($acao === 'alterar_senha') {
    $id     = $_POST['id'] ?? '';
    $senha  = password_hash($_POST['senha'] ?? '', PASSWORD_BCRYPT);

    if (Usuario::changePassword($id, $senha)) {
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
                    text: 'Senha alterada com sucesso!'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=usuarios';
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
                    text: 'Falha ao alterar senha.'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=usuarios';
                });
            </script>
        </body>
        </html>";
    }
}
