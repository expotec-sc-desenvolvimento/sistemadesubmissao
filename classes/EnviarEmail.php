<?php

require_once dirname(__FILE__) . './../PHPMailer-5.2.27/PHPMailerAutoload.php';

function EnviarEmail($assunto,$corpo,$nome,$emails) {
        $M = new PHPMailer();

	$M->isSMTP(); # Informamos que é SMTP
	$M->Host = 'smtp.gmail.com'; # Colocamos o host de envio de e-mail.
	$M->SMTPAuth = true; # Informamos que terá autenticação de SMTP.
	$M->SMTPDebug = false;
	$M->Username = 'jsueneylove@gmail.com'; # Usuário do gmail
	$M->Password = 'showmankid240687'; # Senha do gmail
	$M->Port = 465; # Porta de disparo.
	$M->SMTPSecure = 'ssl'; # Caso tenha segurança.
	
	$M->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );
	 
#	$M-> SMTPDebug = 4;
	$M->From = 'jsueneylove@gmail.com'; # Remetente do disparo.
	$M->FromName = 'Sistema de Sumissão'; # Nome do remetente.
        $M->addAddress('jsueneylove@gmail.com', $nome); # Destinatário. A VARIAVEL $nome foi TROCADA PARA TESTE
        
        foreach ($emails as $email) {$M->addCC($email);}
        
	$M->isHTML(); # Informamos que o corpo tem o formato HTML.
        $M->CharSet = 'UTF-8';
        $M->Subject = $assunto;
        $M->Body = $corpo;
        return $M-> send();

    }
    


?>