<?php

namespace core\classes;
//eu que coloquei estes namespaces aqui
// namespace vendor\PHPMailer\src\PHPMailer;
// namespace vendor\PHPMailer\src\SMTP;
// namespace vendor\PHPMailer\src\Exception;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// use vendor\phpmailer\src\Exception;

class EnviarEmail{

    public function enviar_email_confirmacao_novo_cliente($email_cliente, $purl){
    //envia um email de confirmção para um novo cliente

    //constroi o purl (link para validação do email)
    $link = BASE_URL.'?a=confirmar_email&purl='.$purl;
    
    $mail = new PHPMailer(true);

    try {
        //Opções do SERVIDOR
        //SMTP::DEBUG_SERVER, apresentar msg de dos erros, pode ser = 2, ou 0, para não exibir msg = DEBUG_OFF
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = MAIL_HOST; //Set the SMTP server to send through
        $mail->SMTPAuth = true;  //Enable SMTP authentication
        $mail->Username   = MAIL_FROM; //SMTP username
        $mail->Password   = MAIL_PASS; //SMTP password
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        // $mail->Port = 465; //TCP port to onnect 
        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
        $mail->Port = MAIL_PORT;  

        //Emissor e receptor
        $mail->setFrom(MAIL_FROM, APP_NAME);
        $mail->addAddress($email_cliente);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Conteudo da menssagem
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = APP_NAME.' - Confirmação de Email.';
        $html = '<h3>Seja bem-vindo(a) à nossa loja '.APP_NAME.'.</h3>';
        $html .= '<p>Para concluir o cadastro em nosso loja é necessário confirmar o Email.</p>';
        $html .= '<p>Para confirmar o seu Email, clique no link abaixo:</p>';
        $html .= '<p><a href="'.$link.'">Confirmar Email</a></p>';
        $html .= '<p><i><small>'.APP_NAME.'</small></i></p>';
        $mail->Body = $html;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
    }
}