<?php
require_once '../conexao/conexao.php';

class FotoImovel {

    public static function save($imovel_id, $caminho, $principal = false) {
        $con = ligar();
        $sql = "INSERT INTO fotos_imoveis (imovel_id, caminho, principal) VALUES (:iid, :c, :p)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":iid", $imovel_id);
        $stmt->bindValue(":c", $caminho);
        $stmt->bindValue(":p", $principal);
        return $stmt->execute();
    }

    public static function getByImovel($imovel_id) {
        $con = ligar();
        $sql = "SELECT * FROM fotos_imoveis WHERE imovel_id=:iid";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":iid", $imovel_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
