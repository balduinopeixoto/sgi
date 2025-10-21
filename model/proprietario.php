<?php
require_once '../conexao/conexao.php';

class Proprietario {

    public static function save($nome, $email, $telefone, $documento) {
        $con = ligar();
        $sql = "INSERT INTO proprietario (nome, email, telefone, documento) 
                VALUES (:n, :e, :t, :d)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":n", $nome);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":t", $telefone);
        $stmt->bindValue(":d", $documento);
        
        return $stmt->execute();
    }

    public static function edit($nome, $email, $telefone, $documento, $id ) {
        $con = ligar();
        $sql = "UPDATE proprietario SET nome=:n, email=:e, telefone=:t, documento=:d WHERE idproprietario=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":n", $nome);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":t", $telefone);
        $stmt->bindValue(":d", $documento);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

   
    public static function getById($id) {
        $con = ligar();
        $sql = "SELECT * FROM proprietario WHERE idproprietario=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function existe($email,$documento) {
        $con = ligar();
        $sql = "SELECT COUNT(*) FROM proprietario WHERE email=:e or documento=:u";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":u", $documento);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }




  // Listar todos os proprietários (retorna array)
    public static function listar() {
        try {
            $con = ligar();
            $sql = "SELECT idproprietario, nome, email, telefone, documento FROM proprietario ORDER BY nome ASC";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // opcional: log do erro
            return [];
        }
    }

}