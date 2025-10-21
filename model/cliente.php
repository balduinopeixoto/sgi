<?php
require_once '../conexao/conexao.php';

class Cliente
{
    public static function save($nome, $tipo_pessoa, $nif, $telefone, $email, $endereco, $cidade, $pais)
    {
        try {
            $conexao = ligar();
            $sql = "INSERT INTO cliente (nome, tipo_pessoa, nif, telefone, email, endereco, cidade, pais)
                    VALUES (:nome, :tipo_pessoa, :nif, :telefone, :email, :endereco, :cidade, :pais)";
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':tipo_pessoa', $tipo_pessoa);
            $stmt->bindValue(':nif', $nif);
            $stmt->bindValue(':telefone', $telefone);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':endereco', $endereco);
            $stmt->bindValue(':cidade', $cidade);
            $stmt->bindValue(':pais', $pais);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar cliente: " . $e->getMessage();
            return false;
        }
    }

    public static function edit($idcliente, $nome, $tipo_pessoa, $nif, $telefone, $email, $endereco, $cidade, $pais)
    {
        try {
            $conexao = ligar();
            $sql = "UPDATE cliente SET 
                        nome = :nome,
                        tipo_pessoa = :tipo_pessoa,
                        nif = :nif,
                        telefone = :telefone,
                        email = :email,
                        endereco = :endereco,
                        cidade = :cidade,
                        pais = :pais
                    WHERE idcliente = :id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', $idcliente);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':tipo_pessoa', $tipo_pessoa);
            $stmt->bindValue(':nif', $nif);
            $stmt->bindValue(':telefone', $telefone);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':endereco', $endereco);
            $stmt->bindValue(':cidade', $cidade);
            $stmt->bindValue(':pais', $pais);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao atualizar cliente: " . $e->getMessage();
            return false;
        }
    }

    public static function apagar($idcliente)
    {
        try {
            $conexao = ligar();
            $sql = "DELETE FROM cliente WHERE idcliente = :id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', $idcliente);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao apagar cliente: " . $e->getMessage();
            return false;
        }
    }



        public function existeCliente($nif, $email) {
             $conexao = ligar();
        $query = "SELECT idcliente FROM cliente WHERE nif = :nif OR email = :email";
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':nif', $nif);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
