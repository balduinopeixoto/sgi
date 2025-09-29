<?php
require_once '../model/Mensagem.php';

if (isset($_POST['acao'])) {
    $acao = $_POST['acao'];

    switch ($acao) {
        case 'enviar':
            $imovel_id = $_POST['imovel_id'];
            $remetente_id = $_POST['remetente_id'];
            $destinatario_id = $_POST['destinatario_id'];
            $conteudo = $_POST['conteudo'];

            if (Mensagem::enviar($imovel_id, $remetente_id, $destinatario_id, $conteudo)) {
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Mensagem enviada!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = '../view/conversa.php?imovel_id={$imovel_id}&remetente_id={$remetente_id}&destinatario_id={$destinatario_id}';
                        });
                      </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao enviar mensagem!',
                            text: 'Tente novamente mais tarde.'
                        }).then(() => {
                            window.history.back();
                        });
                      </script>";
            }
            break;

        case 'listar':
            $imovel_id = $_POST['imovel_id'];
            $remetente_id = $_POST['remetente_id'];
            $destinatario_id = $_POST['destinatario_id'];

            $mensagens = Mensagem::listarConversa($remetente_id, $destinatario_id, $imovel_id);

            header('Content-Type: application/json');
            echo json_encode($mensagens);
            break;

        default:
            echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ação inválida!',
                        text: 'Nenhuma ação correspondente encontrada.'
                    }).then(() => {
                        window.history.back();
                    });
                  </script>";
    }
}
?>
