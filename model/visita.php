<?php
require_once '../conexao/conexao.php';

class Visita {

    public static function agendar($imovel_id, $usuario_id, $data, $hora) {
        $con = ligar();
        $sql = "INSERT INTO visitas (imovel_id, usuario_id, data_visita, hora_visita) 
                VALUES (:iid, :uid, :dv, :hv)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":iid", $imovel_id);
        $stmt->bindValue(":uid", $usuario_id);
        $stmt->bindValue(":dv", $data);
        $stmt->bindValue(":hv", $hora);
        return $stmt->execute();
    }

    public static function atualizarStatus($id, $status) {
        $con = ligar();
        $sql = "UPDATE visitas SET status=:s WHERE id=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":s", $status);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    public static function listarPorUsuario($usuario_id) {
        $con = ligar();
        $sql = "SELECT v.*, i.titulo FROM visitas v 
                JOIN imoveis i ON v.imovel_id = i.id
                WHERE v.usuario_id=:uid";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":uid", $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
