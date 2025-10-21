<?php
require_once '../model/cliente.php';

$acao = $_GET['acao'] ?? '';

// ======================================================
// Cadastrar novo cliente
// ======================================================
if ($acao === 'cadastrar') {
    $nome         = $_POST['nome'] ?? '';
    $tipo_pessoa  = $_POST['tipo_pessoa'] ?? 'fisica';
    $nif          = $_POST['nif'] ?? '';
    $telefone     = $_POST['telefone'] ?? '';
    $email        = $_POST['email'] ?? '';
    $endereco     = $_POST['endereco'] ?? '';
  

    if (Cliente::save($nome, $tipo_pessoa, $nif, $telefone, $email, $endereco, $cidade, $pais)) {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: 'Cliente cadastrado com sucesso!'
            }).then(() => {
                window.location.href = '../app/admin/?page=cliente';
            });
        </script>";
    } else {

        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Falha ao cadastrar cliente.'
            }).then(() => {
                window.location.href = '../app/admin/?page=cliente';
            });
        </script>";
    }
}

// ======================================================
// Editar cliente
// ======================================================
if ($acao === 'editar') {
    $idcliente    = $_POST['id'] ?? '';
    $nome         = $_POST['nome'] ?? '';
    $tipo_pessoa  = $_POST['tipo_pessoa'] ?? 'fisica';
    $nif          = $_POST['nif'] ?? '';
    $telefone     = $_POST['telefone'] ?? '';
    $email        = $_POST['email'] ?? '';
    $endereco     = $_POST['endereco'] ?? '';
    $cidade       = $_POST['cidade'] ?? '';
    $pais         = $_POST['pais'] ?? 'Angola';
    
    if (Cliente::edit($idcliente, $nome, $tipo_pessoa, $nif, $telefone, $email, $endereco, $cidade, $pais)) {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso',
                text: 'Cliente atualizado com sucesso!'
            }).then(() => {
                window.location.href = '../app/admin/?page=cliente';
            });
        </script>";
    } else {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Falha ao atualizar cliente.'
            }).then(() => {
                window.location.href = '../app/admin/?page=cliente';
            });
        </script>";
    }
}

// ======================================================
// Apagar cliente
// ======================================================
if ($acao === 'eliminar') {

  $idcliente = $_GET['idcliente'] ?? '';

    if (Cliente::apagar($idcliente)) {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Cliente eliminado',
                text: 'O cliente foi removido com sucesso.'
            }).then(() => {
                window.location.href = '../app/admin/?page=cliente';
            });
        </script>";
    } else {
        echo "
        <script src='../app/admin/sweetalert2.js'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Não foi possível eliminar o cliente.'
            }).then(() => {
                window.location.href = '../app/admin/?page=cliente';
            });
        </script>";
    }
}
