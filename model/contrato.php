<?php
require_once '../conexao/conexao.php';

class Contrato {

    public static function save($imovel_id, $usuario_id, $cliente_id, $tipo, $valor, $data_inicio, $data_fim, $forma_pagamento, $numero_parcelas, $valor_parcela, $data_assinatura, $observacoes,$anexo) {
        try {
            $conexao = ligar();
            $sql = "INSERT INTO contrato (
                        imovel_id, usuario_id, cliente_id, tipo, valor, data_inicio, data_fim,
                        forma_pagamento, numero_parcelas, valor_parcela, data_assinatura,
                        observacoes,anexo
                    ) VALUES (
                        :imovel_id, :usuario_id, :cliente_id, :tipo, :valor, :data_inicio, :data_fim,
                        :forma_pagamento, :numero_parcelas, :valor_parcela, :data_assinatura,
                         :observacoes,:anexo
                    )";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':imovel_id', $imovel_id);
            $stmt->bindValue(':usuario_id', $usuario_id);
            $stmt->bindValue(':cliente_id', $cliente_id);
            $stmt->bindValue(':tipo', $tipo);
            $stmt->bindValue(':valor', $valor);
            $stmt->bindValue(':data_inicio', $data_inicio);
            $stmt->bindValue(':data_fim', $data_fim);
            $stmt->bindValue(':forma_pagamento', $forma_pagamento);
            $stmt->bindValue(':numero_parcelas', $numero_parcelas);
            $stmt->bindValue(':valor_parcela', $valor_parcela);
            $stmt->bindValue(':data_assinatura', $data_assinatura);
            $stmt->bindValue(':observacoes', $observacoes);
            $stmt->bindValue(':anexo', $anexo);

            if ($stmt->execute()) {
                return $conexao->lastInsertId();
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo "Erro ao salvar contrato: " . $e->getMessage();
            return false;
        }
    }

    public static function edit($idcontrato, $valor, $data_fim, $forma_pagamento, $numero_parcelas, $valor_parcela, $status, $observacoes,$anexo) {
    try {
        $conexao = ligar();
        $sql = "UPDATE contrato SET
                    valor = :valor,
                    data_fim = :data_fim,
                    forma_pagamento = :forma_pagamento,
                    numero_parcelas = :numero_parcelas,
                    valor_parcela = :valor_parcela,
                    status = :status,
                    observacoes = :observacoes,anexo=:anexo
                WHERE idcontrato = :id";

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':id', $idcontrato);
        $stmt->bindValue(':valor', $valor);
        $stmt->bindValue(':data_fim', $data_fim);
        $stmt->bindValue(':forma_pagamento', $forma_pagamento);
        $stmt->bindValue(':numero_parcelas', $numero_parcelas);
        $stmt->bindValue(':valor_parcela', $valor_parcela);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':observacoes', $observacoes);
        $stmt->bindValue(':anexo', $anexo);

        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao atualizar contrato: " . $e->getMessage();
        return false;
    }
}


    public static function delete($id) {
        try {
            $conexao = ligar();
            $stmt = $conexao->prepare("DELETE FROM contrato WHERE idcontrato = :id");
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao eliminar contrato: " . $e->getMessage();
            return false;
        }
    }

    public static function listar() {
        try {
            $conexao = ligar();
            $sql = "SELECT c.*, 
                           i.titulo AS imovel, 
                           cl.nome AS cliente, 
                           u.nome AS usuario
                    FROM contrato c
                    INNER JOIN imovel i ON i.idimovel = c.imovel_id
                    INNER JOIN cliente cl ON cl.idcliente = c.cliente_id
                    INNER JOIN usuario u ON u.idusuario = c.usuario_id
                    ORDER BY c.idcontrato DESC";
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar contratos: " . $e->getMessage();
            return [];
        }
    }

    public static function buscarPorId($id) {
        try {
            $conexao = ligar();
            $sql = "SELECT * FROM contrato WHERE idcontrato = :id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao buscar contrato: " . $e->getMessage();
            return false;
        }
    }



       public static function existeAtivo($imovel_id, $cliente_id, $tipo) {
         $conexao=ligar();
        $sql = "SELECT COUNT(*) as total 
                FROM contrato 
                WHERE imovel_id = :imovel_id 
                AND cliente_id = :cliente_id 
                AND tipo = :tipo 
                AND status = 'ativo'";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':imovel_id', $imovel_id);
        $stmt->bindValue(':cliente_id', $cliente_id);
        $stmt->bindValue(':tipo', $tipo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }



      public static function encerrar($idcontrato) {
         $conexao=ligar();
        $sql = "UPDATE contrato SET status = 'encerrado' WHERE idcontrato = :idcontrato";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':idcontrato', $idcontrato);
        return $stmt->execute();
    }
}
