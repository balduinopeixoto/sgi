<?php
require_once '../model/usuario.php';

$acao = $_GET['acao'] ?? '';

if ($acao === 'cadastrar') {
    $nome   = $_POST['nome'] ?? '';
    $email  = $_POST['email'] ?? '';
    $usuario  = $_POST['usuario'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $senha  = password_hash($_POST['senha'] ?? '', PASSWORD_BCRYPT);
    $tipo   = $_POST['tipo'] ?? 'ADMIN';

    // Verifica duplicidade
    if (Usuario::existe($email,$usuario)) {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
             <script src='../app/admin/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Aviso',
                    text: 'Este usuário já foi registrado!'
                }).then(() => {
                    window.location.href = '../app/admin/?page=usuarios';
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
            <script src='../app/admin/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: 'Usuário cadastrado com sucesso!'
                }).then(() => {
                    window.location.href = '../app/admin/?page=usuarios';
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
           <script src='../app/admin/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Falha ao cadastrar usuário.'
                }).then(() => {
                    window.location.href = '../app/admin/?page=usuarios';
                });
            </script>
        </body>
        </html>";
    }
}




if ($acao === 'editar') {
    $id     = $_POST['id'] ?? '';
    $nome   = $_POST['nome'] ?? '';
    $email  = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $usuario   = $_POST['usuario'] ?? '';

    if (Usuario::edit($id, $nome, $email, $telefone, $usuario)) {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
          <script src='../app/admin/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: 'Usuário editado com sucesso!'
                }).then(() => {
                    window.location.href = '../app/admin/?page=usuarios';
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
             <script src='../app/admin/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Falha ao editar usuário.'
                }).then(() => {
                    window.location.href = '../app/admin/?page=usuarios';
                });
            </script>
        </body>
        </html>";
    }
}


if ($acao === 'alterarsenha') {
    $id           = $_POST['id'] ?? '';
    $senhaAntiga  = $_POST['senhaantiga'] ?? '';
    $novaSenha    = $_POST['novasenha'] ?? '';
    $confirmar    = $_POST['confirmar-senha'] ?? '';

    // 1. Verifica se nova senha e confirmar senha batem
    if ($novaSenha !== $confirmar) {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Atenção',
                text: 'Nova senha e confirmação não coincidem.'
            }).then(() => {
                window.location.href = '../app/admin/?page=usuarios';
            });
        </script>";
        exit;
    }

    // 2. Puxa do banco a senha atual do usuário
    $usuario = Usuario::getById($id); // precisa ter esse método na tua classe Usuario
    if (!$usuario) {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Usuário não encontrado.'
            }).then(() => {
                window.location.href = '../app/admin/?page=usuarios';
            });
        </script>";
        exit;
    }

    // 3. Valida se senha antiga bate
    if (!password_verify($senhaAntiga, $usuario['senha'])) {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Senha incorreta',
                text: 'A senha antiga não confere.'
            }).then(() => {
                window.location.href = '../app/admin/?page=usuarios';
            });
        </script>";
        exit;
    }

    // 4. Atualiza senha
    $senhaHash = password_hash($novaSenha, PASSWORD_BCRYPT);

    if (Usuario::changePassword($id, $senhaHash)) {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: 'Senha alterada com sucesso!'
            }).then(() => {
                window.location.href = '../app/admin/?page=usuarios';
            });
        </script>";
    } else {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Falha ao alterar senha.'
            }).then(() => {
                window.location.href = '../app/admin/?page=usuarios';
            });
        </script>";
    }
}

