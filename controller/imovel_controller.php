<?php
session_start();
ini_set('max_execution_time', 0);

require_once '../model/imovel.php';
require_once '../model/imagem.php';

$acao = $_GET['acao'] ?? '';

if ($acao === 'cadastrar') {

    // 🔹 Coleta dos dados do formulário
    $usuario_id      = $_SESSION['idusuario'] ?? '';
    $titulo     = trim($_POST['titulo'] ?? '');
    $descricao  = trim($_POST['descricao'] ?? '');
    $tipo       = trim($_POST['tipo'] ?? '');
    $preco      = trim($_POST['preco'] ?? '');
    $area       = trim($_POST['area'] ?? '');
    $quartos    = trim($_POST['quartos'] ?? '');
    $banheiros  = trim($_POST['banheiros'] ?? '');
    $garagem    = trim($_POST['garagem'] ?? '');
    $endereco   = trim($_POST['endereco'] ?? '');
    $lat        = trim($_POST['latitude'] ?? '');
    $lng        = trim($_POST['longitude'] ?? '');
    $proprietario = trim($_POST['proprietario_id'] ?? '');
    $preco = $_POST['preco']; // troca vírgula por ponto
   // $valor = number_format((float)$valor, 2, '.', ''); 
    // 🔹 Verifica duplicidade
    if (Imovel::jaExiste($titulo, $tipo, $endereco)) {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
           <script src='../app/admin/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Aviso',
                    text: 'Já existe um imóvel cadastrado com esse título, tipo e endereço.'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=imoveis';
                });
            </script>
        </body>
        </html>";
        exit;
    }

    // 🔹 Salva o imóvel e obtém o ID
    $idImovel = Imovel::save($usuario_id, $titulo, $descricao, $tipo, $preco, $area, $quartos, $banheiros, $garagem, $endereco, $lat, $lng,$proprietario);

    $retorno = false;

    if ($idImovel>0) {

       
        // 🔹 Se houver imagens enviadas
        if (!empty($_FILES['files']['name'][0])) {

            $diretorioDestino = "../app/assets/img/";

            // Cria diretório se não existir
            if (!is_dir($diretorioDestino)) {
                mkdir($diretorioDestino, 0777, true);
            }

            foreach ($_FILES['files']['tmp_name'] as $i => $tmpName) {

                // Gera nome único
                $nomeArquivo = uniqid("img_") . "_" . basename($_FILES['files']['name'][$i]);
                $destino = $diretorioDestino . $nomeArquivo;

                // Move o arquivo
                if (move_uploaded_file($tmpName, $destino)) {

                    // Define a primeira imagem como principal
                    $principal = ($i === 0) ? 1 : 0;

                    // Salva no banco
                    $retorno = IMAGEM::save($idImovel, $nomeArquivo, $principal);
                }
            }
        }
    }

    // 🔹 Exibe feedback ao usuário
    if ($retorno) {
        $msg = [
            'icon' => 'success',
            'title' => 'Sucesso',
            'text' => 'Imóvel cadastrado com sucesso!',
            'redirect' => '../app/admin/?rota=imoveis'
        ];
    } else {
        $msg = [
            'icon' => 'error',
            'title' => 'Erro',
            'text' => 'Falha ao cadastrar imóvel.',
            'redirect' => '../app/admin/?rota=imoveis'
        ];
    }

   echo "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <script src='../app/admin/sweetalert2.js'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: '{$msg['icon']}',
                title: '{$msg['title']}',
                text: '{$msg['text']}'
            }).then(() => {
                window.location.href = '{$msg['redirect']}';
            });
        </script>
    </body>
    </html>";
}



if ($acao === 'editar_status') {
    $id     = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? 'disponivel';

    if (Imovel::updateStatus($id, $status)) {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='../assets/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: 'Status do imóvel atualizado!'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=imoveis';
                });
            </script>
        </body>
        </html>";
    } else {
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='../assets/sweetalert2.js'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Falha ao atualizar status do imóvel.'
                }).then(() => {
                    window.location.href = '../app/admin/?rota=imoveis';
                });
            </script>
        </body>
        </html>";
    }
}





if (isset($_GET['acao']) && $_GET['acao'] === 'apagar_foto') {
    header('Content-Type: application/json');
    $idfoto = $_POST['idfoto'] ?? null;

    if (!$idfoto) {
        echo json_encode(['status' => 'error', 'message' => 'ID da foto inválido.']);
        exit;
    }

    $con = ligar();

    $stmt = $con->prepare("SELECT caminho FROM fotos_imoveis WHERE id = :id");
    $stmt->bindParam(':id', $idfoto, PDO::PARAM_INT);
    $stmt->execute();
    $foto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($foto) {
        $caminho = "../app/assets/img/" . $foto['caminho'];
        if (file_exists($caminho)) unlink($caminho);

        $del = $con->prepare("DELETE FROM fotos_imoveis WHERE id = :id");
        $del->bindParam(':id', $idfoto, PDO::PARAM_INT);
        $del->execute();

        echo json_encode(['status' => 'success', 'message' => 'Imagem eliminada com sucesso.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Imagem não encontrada.']);
    }
    exit;
}

//ESTATISTICAS DO GRAFICO

if (isset($_GET['acao']) && $_GET['acao'] === 'relatorioMensal') {
    header('Content-Type: application/json');
    Imovel::estatisticasMensais();
    exit;
}





if ($acao === 'editar') {

    $idImovel = intval($_POST['id'] ?? 0);
    $usuario_id = 1; // futuramente virá da sessão

    $titulo     = trim($_POST['titulo'] ?? '');
    $descricao  = trim($_POST['descricao'] ?? '');
    $tipo       = trim($_POST['tipo'] ?? '');
    $preco      = trim($_POST['preco'] ?? '');
    $area       = trim($_POST['area'] ?? '');
    $quartos    = trim($_POST['quartos'] ?? '');
    $banheiros  = trim($_POST['banheiros'] ?? '');
    $garagem    = trim($_POST['garagem'] ?? '');
    $endereco   = trim($_POST['endereco'] ?? '');
    $lat        = trim($_POST['latitude'] ?? '');
    $lng        = trim($_POST['longitude'] ?? '');
    $proprietario = trim($_POST['proprietario_id'] ?? '');

    // Atualiza os dados do imóvel
    $retorno = Imovel::update(
        $idImovel,
        $usuario_id,
        $titulo,
        $descricao,
        $tipo,
        $preco,
        $area,
        $quartos,
        $banheiros,
        $garagem,
        $endereco,
        $lat,
        $lng,
        $proprietario
    );

    // Se houver novas imagens enviadas
    if (!empty($_FILES['files']['name'][0])) {
       

            $diretorioDestino = "../app/assets/img/";

            // Cria diretório se não existir
            if (!is_dir($diretorioDestino)) {
                mkdir($diretorioDestino, 0777, true);
            }

            foreach ($_FILES['files']['tmp_name'] as $i => $tmpName) {

                // Gera nome único
                $nomeArquivo = uniqid("img_") . "_" . basename($_FILES['files']['name'][$i]);
                $destino = $diretorioDestino . $nomeArquivo;

                // Move o arquivo
                if (move_uploaded_file($tmpName, $destino)) {

                    // Define a primeira imagem como principal
                    $principal = ($i === 0) ? 1 : 0;

                    // Salva no banco
                    $retorno = IMAGEM::save($idImovel, $nomeArquivo, $principal);
                }
            }
        
    }

    // Feedback ao usuário
    if ($retorno) {
        $msg = [
            'icon' => 'success',
            'title' => 'Sucesso',
            'text' => 'Imóvel atualizado com sucesso!',
            'redirect' => '../app/admin/?page=imovel'
        ];
    } else {
        $msg = [
            'icon' => 'error',
            'title' => 'Erro',
            'text' => 'Falha ao atualizar imóvel.',
            'redirect' => '../app/admin/?page=imovel'
        ];
    }

   echo "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <script src='../app/admin/sweetalert2.js'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: '{$msg['icon']}',
                title: '{$msg['title']}',
                text: '{$msg['text']}'
            }).then(() => {
                window.location.href = '{$msg['redirect']}';
            });
        </script>
    </body>
    </html>";
}





if (isset($_GET['acao']) && $_GET['acao'] === 'buscar_valor') {

    $conexao = ligar();

    $id = intval($_GET['id']);
    $sql = "SELECT preco as valor FROM imovel WHERE idimovel = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dados) {
        echo json_encode($dados);
    } else {
        echo json_encode(['erro' => 'Imóvel não encontrado']);
    }
} else {
   // echo json_encode(['erro' => 'ID não informado']);
}
