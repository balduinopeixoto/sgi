<?php
require_once '../conexao/conexao.php';

class Sincronizacao {

    public static function registrar($usuario_id, $tabela, $registro_id, $acao) {
        $con = ligar();
        $sql = "INSERT INTO sincronizacoes (usuario_id, tabela_afetada, registro_id, acao) 
                VALUES (:uid, :t, :rid, :a)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":uid", $usuario_id);
        $stmt->bindValue(":t", $tabela);
        $stmt->bindValue(":rid", $registro_id);
        $stmt->bindValue(":a", $acao);
        return $stmt->execute();
    }

    public static function listarPendentes($usuario_id) {
        $con = ligar();
        $sql = "SELECT * FROM sincronizacoes WHERE usuario_id=:uid AND status='pendente'";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":uid", $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function marcarSincronizado($id) {
        $con = ligar();
        $sql = "UPDATE sincronizacoes SET status='sincronizado' WHERE id=:id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }
}
