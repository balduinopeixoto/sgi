<?php
require_once '../conexao/conexao.php';

class IMAGEM {

    public static function save($imovel_id, $caminho, $principal) {
        $con = ligar();
        $sql = "INSERT INTO fotos_imoveis (imovel_id, caminho, principal) 
                VALUES (:i, :c, :p)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":i", $imovel_id);
        $stmt->bindValue(":c", $caminho);
        $stmt->bindValue(":p", $principal);
        return $stmt->execute();
    }
}