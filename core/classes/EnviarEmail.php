<?php
namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EnviarEmail{
    //=================================================================================
    public function enviar_email_confirmacao_novo_cliente($email_cliente, $purl)
    {
    //constroi o purl (link para validação do email)
    $link = BASE_URL.'?a=confirmar_email&purl='.$purl;
    //envia um email de confirmção para um novo cliente
    $mail = new PHPMailer(true);
    try {
        //Opções do SERVIDOR
        //SMTP::DEBUG_SERVER, apresentar msg de dos erros, pode ser = 2, ou 0, para não exibir msg = DEBUG_OFF
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->CharSet = 'UTF-8';
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
        $html .= '<p>Para concluir o cadastro em nossa loja é necessário confirmar o Email.</p>';
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
    //=================================================================================
    public function enviar_email_confirmacao_encomenda($email_cliente, $dados_encomenda)
    {
    //envia um email de confirmção de encomenda realizada com sucesso
    $mail = new PHPMailer(true);
    try {
        //Opções do SERVIDOR
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = MAIL_HOST; //Set the SMTP server to send through
        $mail->SMTPAuth = true;  //Enable SMTP authentication
        $mail->Username   = MAIL_FROM; //SMTP username
        $mail->Password   = MAIL_PASS; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
        $mail->Port = MAIL_PORT;  

        //Emissor e receptor
        $mail->setFrom(MAIL_FROM, APP_NAME);
        $mail->addAddress($email_cliente);  

        //Conteudo da menssagem
        $mail->isHTML(true);
        $mail->Subject = APP_NAME.' - Confirmação da Encomenda - '.$dados_encomenda['dados_pagamento']['codigo_encomenda'];
        $html = '<h3>Este email serve para confirmar a sua encomenda.</h3>';
        $html .= '<hr>';
        $html .= '<p>Dados da encomenda</p>';
        //lista de produtos
        $html .= '<ul>';
        foreach($dados_encomenda['lista_produtos'] as $produto){
            $html .= "<li>$produto</li>";
        }
        $html .= '</ul>';
        //valor total
        $html .= '<p>Valor total:<strong> '.$dados_encomenda['total'].'</strong></p>';
        
        //dados do pagamento
        $html .= '<hr>';
        $html .= '<h4>Dados do Pagamento </h4>';
        $html .= '<p>Número da conta: <strong>'.$dados_encomenda['dados_pagamento']['numero_conta'].'</strong></p>';
        $html .= '<p>Código da encomenda: <strong>'.$dados_encomenda['dados_pagamento']['codigo_encomenda'].'</strong></p>';
        $html .= '<p>Valor à Pagar: <strong>'.$dados_encomenda['dados_pagamento']['total'].'</strong></p>';
        //nota importante
        $html .= '<p><i><small>'.APP_NAME. ': A sua encomenda só será processada após o pagamento.</small></i></p>';
        $html .= '<hr>';
        $mail->Body = $html;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
    }
}