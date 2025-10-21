<?php
require_once '../conexao/conexao.php';

class Usuario {

    public static function save($nome, $email, $telefone, $senha, $usuario,$tipo = 'cliente') {
        $con = ligar();
        $sql = "INSERT INTO usuario (nome_completo,usuario, email, telefone, senha_hash, tipo) 
                VALUES (:n,:u, :e, :t, :s, :tp)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":n", $nome);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":u", $usuario);
        $stmt->bindValue(":t", $telefone);
        $stmt->bindValue(":s", password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(":tp", $tipo);
        return $stmt->execute();
    }

    public static function edit($id, $nome, $email, $telefone, $usuario ) {
        $con = ligar();
        $sql = "UPDATE usuario SET nome_completo=:n, email=:e, telefone=:t, usuario=:u WHERE idusuario=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":n", $nome);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":t", $telefone);
        $stmt->bindValue(":u", $usuario);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    public static function changePassword($id, $senha) {
        $con = ligar();
        $sql = "UPDATE usuario SET senha_hash=:s WHERE idusuario=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":s", password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    public static function getById($id) {
        $con = ligar();
        $sql = "SELECT * FROM usuario WHERE idusuario=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function existe($email,$usuario) {
        $con = ligar();
        $sql = "SELECT COUNT(*) FROM usuario WHERE email=:e or usuario=:u";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":u", $usuario);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }


  public static function login($usuario) {
    $con = ligar();
    $sql = "SELECT * FROM usuario WHERE LOWER(usuario) = LOWER(:u) LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(":u", $usuario, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

}
