<?php
require_once '../model/proprietario.php';

$acao = $_GET['acao'] ?? '';

if ($acao === 'cadastrar') {
    $nome   = $_POST['nome'] ?? '';
    $email  = $_POST['email'] ?? '';
    $documento  = $_POST['documento'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
  

    // Verifica duplicidade
    if (Proprietario::existe($email,$documento)) {
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
                    text: 'Este Proprietário já foi registrado!'
                }).then(() => {
                    window.location.href = '../app/admin/?page=proprietario';
                });
            </script>
        </body>
        </html>";
        exit;
    }

    if (Proprietario::save($nome, $email, $telefone, $documento)) {
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
                    text: 'Proprietário cadastrado com sucesso!'
                }).then(() => {
                    window.location.href = '../app/admin/?page=proprietario';
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
                    text: 'Falha ao cadastrar Proprietário.'
                }).then(() => {
                    window.location.href = '../app/admin/?page=proprietario';
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
    $documento  = $_POST['documento'] ?? '';
    $telefone = $_POST['telefone'] ?? '';

    if (Proprietario::edit($nome, $email, $telefone, $documento, $id )) {
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
                    text: 'Proprietário editado com sucesso!'
                }).then(() => {
                    window.location.href = '../app/admin/?page=proprietario';
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
                    text: 'Falha ao editar Proprietário.'
                }).then(() => {
                    window.location.href = '../app/admin/?page=proprietario';
                });
            </script>
        </body>
        </html>";
    }

     function listar(){

     return Proprietario::listar();
}

}


