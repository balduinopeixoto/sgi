<?php
 session_start();
require_once '../model/usuario.php';

$acao = $_GET['acao'] ?? '';

if ($acao === 'login') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['password'] ?? '';

    $usuarioData = Usuario::login($usuario);

    if (!empty($usuarioData)) {
       
        $senhaHash = $usuarioData['senha_hash'];
        if (password_verify($senha, $senhaHash)) {
           
            $_SESSION['usuario'] = $usuarioData['usuario'];
            $_SESSION['idusuario'] = $usuarioData['idusuario'];
            $_SESSION['nome'] = $usuarioData['nome_completo'];

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
                    text: 'Login realizado com sucesso!'
                }).then(() => {
                    window.location.href = '../app/admin/?page=painel';
                });
            </script>
        </body>
        </html>>";

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
                    text: 'Usuário ou senha incorretos!'
                }).then(() => {
                    window.location.href = '../marketplace/login.php';
                });
            </script>
        </body>
        </html>";
        }
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
                    text: 'Usuário ou senha incorretos!'
                }).then(() => {
                    window.location.href = '../marketplace/login.php';
                });
            </script>
        </body>
        </html>";
    }
}



if($acao === 'logout'){
    session_destroy();
    unset($_SESSION['usuario']);
    unset($_SESSION['idusuario']);
    unset($_SESSION['nome']);
    header('Location: ../marketplace/login.php');
}

