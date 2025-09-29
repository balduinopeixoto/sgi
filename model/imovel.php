<?php
require_once '../conexao/conexao.php';

class Imovel {

    public static function save($usuario_id, $titulo, $descricao, $tipo, $preco, $area, $quartos, $banheiros, $garagem, $endereco, $lat, $lng) {
        $con = ligar();
        $sql = "INSERT INTO imoveis (usuario_id, titulo, descricao, tipo, preco, area, quartos, banheiros, garagem, endereco, latitude, longitude) 
                VALUES (:uid, :t, :d, :tp, :p, :a, :q, :b, :g, :e, :lat, :lng)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":uid", $usuario_id);
        $stmt->bindValue(":t", $titulo);
        $stmt->bindValue(":d", $descricao);
        $stmt->bindValue(":tp", $tipo);
        $stmt->bindValue(":p", $preco);
        $stmt->bindValue(":a", $area);
        $stmt->bindValue(":q", $quartos);
        $stmt->bindValue(":b", $banheiros);
        $stmt->bindValue(":g", $garagem);
        $stmt->bindValue(":e", $endereco);
        $stmt->bindValue(":lat", $lat);
        $stmt->bindValue(":lng", $lng);
        return $stmt->execute();
    }

    public static function updateStatus($id, $status) {
        $con = ligar();
        $sql = "UPDATE imoveis SET status=:s WHERE id=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":s", $status);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    public static function getById($id) {
        $con = ligar();
        $sql = "SELECT * FROM imoveis WHERE id=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function listarDisponiveis() {
        $con = ligar();
        $sql = "SELECT * FROM imoveis WHERE status='disponivel'";
        return $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
