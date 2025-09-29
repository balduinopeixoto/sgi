<?php
require_once '../conexao/conexao.php';

class Usuario {

    public static function save($nome, $email, $telefone, $senha, $tipo = 'cliente') {
        $con = ligar();
        $sql = "INSERT INTO usuarios (nome_completo, email, telefone, senha_hash, tipo) 
                VALUES (:n, :e, :t, :s, :tp)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":n", $nome);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":t", $telefone);
        $stmt->bindValue(":s", password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(":tp", $tipo);
        return $stmt->execute();
    }

    public static function edit($id, $nome, $email, $telefone, $tipo) {
        $con = ligar();
        $sql = "UPDATE usuarios SET nome_completo=:n, email=:e, telefone=:t, tipo=:tp WHERE id=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":n", $nome);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":t", $telefone);
        $stmt->bindValue(":tp", $tipo);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    public static function changePassword($id, $senha) {
        $con = ligar();
        $sql = "UPDATE usuarios SET senha_hash=:s WHERE id=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":s", password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    public static function getById($id) {
        $con = ligar();
        $sql = "SELECT * FROM usuarios WHERE id=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function existe($email) {
        $con = ligar();
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email=:e";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":e", $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
