<?php
require_once '../conexao/conexao.php';

class Favorito {

    public static function add($usuario_id, $imovel_id) {
        $con = ligar();
        $sql = "INSERT INTO favoritos (usuario_id, imovel_id) VALUES (:uid, :iid)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":uid", $usuario_id);
        $stmt->bindValue(":iid", $imovel_id);
        return $stmt->execute();
    }

    public static function remove($usuario_id, $imovel_id) {
        $con = ligar();
        $sql = "DELETE FROM favoritos WHERE usuario_id=:uid AND imovel_id=:iid";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":uid", $usuario_id);
        $stmt->bindValue(":iid", $imovel_id);
        return $stmt->execute();
    }

    public static function listar($usuario_id) {
        $con = ligar();
        $sql = "SELECT f.id, i.* FROM favoritos f 
                JOIN imoveis i ON f.imovel_id = i.id
                WHERE f.usuario_id=:uid";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":uid", $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
