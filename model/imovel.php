<?php
require_once '../conexao/conexao.php';

class Imovel {

 public static function save($usuario_id, $titulo, $descricao, $tipo, $preco, $area, $quartos, $banheiros, $garagem, $endereco, $lat, $lng,$proprietario) {
        try {
            $con = ligar();
            $sql = "INSERT INTO imovel (
                        usuario_id, titulo, descricao, tipo, preco, area, quartos, banheiros, garagem, endereco, latitude, longitude,proprietario_id
                    ) VALUES (
                        :uid, :t, :d, :tp, :p, :a, :q, :b, :g, :e, :lat, :lng,:p
                    )";
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
            $stmt->bindValue(":p", $proprietario);

            if ($stmt->execute()) {
                // retorna o ID do imóvel inserido
                return $con->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo("Erro ao salvar imóvel: " . $e->getMessage());
            return false;
        }
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



    public static function jaExiste($titulo, $tipo, $endereco) {
        try {
            $con = ligar();
            $sql = "SELECT COUNT(*) FROM imovel 
                    WHERE LOWER(TRIM(titulo)) = LOWER(TRIM(:titulo))
                      AND LOWER(TRIM(tipo)) = LOWER(TRIM(:tipo))
                      AND LOWER(TRIM(endereco)) = LOWER(TRIM(:endereco))";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':titulo', $titulo);
            $stmt->bindValue(':tipo', $tipo);
            $stmt->bindValue(':endereco', $endereco);
            $stmt->execute();

            return $stmt->fetchColumn() > 0; // retorna true se já existe
        } catch (PDOException $e) {
            error_log("Erro ao verificar duplicidade de imóvel: " . $e->getMessage());
            return false;
        }
    }



    public static function update($id, $usuario_id, $titulo, $descricao, $tipo, $preco, $area, $quartos, $banheiros, $garagem, $endereco, $lat, $lng, $proprietario) {
    try {
        $con = ligar();
        $sql = "UPDATE imovel SET 
                    usuario_id = :uid,
                    titulo = :t,
                    descricao = :d,
                    tipo = :tp,
                    preco = :p,
                    area = :a,
                    quartos = :q,
                    banheiros = :b,
                    garagem = :g,
                    endereco = :e,
                    latitude = :lat,
                    longitude = :lng,
                    proprietario_id = :prop
                WHERE idimovel = :id";
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
        $stmt->bindValue(":prop", $proprietario);
        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao atualizar imóvel: " . $e->getMessage();
        return false;
    }
}





public static function estatisticasMensais() {


try {
    $con = ligar();

    // 🔹 Consulta: conta imóveis por mês e estado (vendido, alugado, disponível)
    $sql = "
       SELECT 
            MONTH(data_cadastro) AS mes,
            status,
            COUNT(*)    AS total
        FROM imovel
        WHERE YEAR(data_cadastro) = YEAR(CURDATE())
        GROUP BY MONTH(data_cadastro), status
        ORDER BY mes ASC
    ";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 🔹 Inicializa arrays com 12 meses (Janeiro a Dezembro)
    $dados = [
        'vendido'    => array_fill(0, 12, 0),
        'disponivel' => array_fill(0, 12, 0),
        'alugado'    => array_fill(0, 12, 0),
    ];

    // 🔹 Preenche apenas os meses encontrados no banco
    foreach ($resultados as $row) {
        $mes = intval($row['mes']) - 1; // índice 0–11
        $estado = strtolower(trim($row['status']));

        if (isset($dados[$estado])) {
            $dados[$estado][$mes] = intval($row['total']);
        }
    }

    // 🔹 Retorna JSON com 0 nos meses sem dados
    echo json_encode([
        'status' => 'success',
        'dados' => $dados
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao buscar dados: ' . $e->getMessage()
    ]);
}



}

}
