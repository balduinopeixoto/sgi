<?php

require_once'app/utils/phpmailer/PHPMailerAutoload.php';

class EMAIL {

    public static function enviar($ail, $corpo, $assunto) {
        $email = new PHPMailer();
        $email->isSMTP();
        $email->SMTPDebug = 2; // ou 3 para mais detalhes
        $email->Debugoutput = 'error_log'; // para gravar no log de erros do PHP

        $email->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Configuração SMTP do Gmail
        $email->Host = "smtp.gmail.com";
        $email->SMTPSecure = "tls"; // Alterado de SSL para TLS
        $email->CharSet = 'UTF-8';
        $email->Port = 587; // Porta recomendada para Gmail
        $email->SMTPAuth = true;

        // Credenciais do e-mail (use variáveis de ambiente para segurança)
        $email->Username = "srcmat2021@gmail.com";
        $email->Password = "oaubejtesxsymiwk"; // Troque por uma variável de ambiente

        // Configuração do e-mail
        $email->setFrom('srcmat2021@gmail.com', 'Comissão de Moradores');
        $email->addAddress("$ail", "Você");
        $email->addReplyTo('srcmat2021@gmail.com', 'Comissão de Moradores');
        //$email->addCustomHeader("Return-Path: srcmat2021@gmail.com");
        $email->Sender = 'srcmat2021@gmail.com';

        // Configuração do conteúdo do e-mail
        $email->isHTML(true);
        $email->Subject = $assunto;
        $email->Body = $corpo;
        $email->AltBody = strip_tags($corpo); // Adiciona uma versão de texto puro

        // Envio e retorno da resposta
        return $email->send() ? 1 :0;
    }
}

 //https://myaccount.google.com/lesssecureapps