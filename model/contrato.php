<?php
require_once '../conexao/conexao.php';

class Contrato {

    public static function save($imovel_id, $usuario_id, $tipo, $valor, $data_inicio, $data_fim) {
        $con = ligar();
        $sql = "INSERT INTO contratos (imovel_id, usuario_id, tipo, valor, data_inicio, data_fim) 
                VALUES (:iid, :uid, :tp, :v, :di, :df)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":iid", $imovel_id);
        $stmt->bindValue(":uid", $usuario_id);
        $stmt->bindValue(":tp", $tipo);
        $stmt->bindValue(":v", $valor);
        $stmt->bindValue(":di", $data_inicio);
        $stmt->bindValue(":df", $data_fim);
        return $stmt->execute();
    }

    public static function updateStatus($id, $status) {
        $con = ligar();
        $sql = "UPDATE contratos SET status=:s WHERE id=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":s", $status);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    public static function getByUsuario($usuario_id) {
        $con = ligar();
        $sql = "SELECT * FROM contratos WHERE usuario_id=:uid";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":uid", $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
