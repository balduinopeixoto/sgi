<?php
require_once '../conexao/conexao.php';

class Mensagem {

    public static function enviar($imovel_id, $remetente_id, $destinatario_id, $conteudo) {
        $con = ligar();
        $sql = "INSERT INTO mensagens (imovel_id, remetente_id, destinatario_id, conteudo) 
                VALUES (:iid, :rid, :did, :c)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":iid", $imovel_id);
        $stmt->bindValue(":rid", $remetente_id);
        $stmt->bindValue(":did", $destinatario_id);
        $stmt->bindValue(":c", $conteudo);
        return $stmt->execute();
    }

    public static function listarConversa($remetente_id, $destinatario_id, $imovel_id) {
        $con = ligar();
        $sql = "SELECT * FROM mensagens 
                WHERE ((remetente_id=:r AND destinatario_id=:d) 
                OR (remetente_id=:d AND destinatario_id=:r))
                AND imovel_id=:iid
                ORDER BY data_envio ASC";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":r", $remetente_id);
        $stmt->bindValue(":d", $destinatario_id);
        $stmt->bindValue(":iid", $imovel_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
