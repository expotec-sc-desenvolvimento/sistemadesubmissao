<?php

require_once dirname(__DIR__) . '/PHPMailer-5.2.27/PHPMailerAutoload.php';

function EnviarEmail($assunto,$corpo,$nome,$emails,$tipo) {
    
        // Tipo: 1 - Email com cópia para o email principal; Tipo: 2 - Email de recuperação de senha, enviado apenas para o usuário
    
        $M = new PHPMailer();

	$M->isSMTP(); # Informamos que é SMTP
	$M->Host = 'smtp.gmail.com'; # Colocamos o host de envio de e-mail.
	$M->SMTPAuth = true; # Informamos que terá autenticação de SMTP.
	$M->SMTPDebug = false;
	$M->Username = 'expotecsc2019@gmail.com'; # Usuário do gmail
	$M->Password = '!Q@W#E$R%T'; # Senha do gmail
	$M->Port = 465; # Porta de disparo.
	$M->SMTPSecure = 'ssl'; # Caso tenha segurança.
	
	$M->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );
	 
#	$M-> SMTPDebug = 4;
	$M->From = 'expotecsc2019@gmail.com'; # Remetente do disparo.
	$M->FromName = 'Sistema de Submissão'; # Nome do remetente.
        
        if ($tipo==1) { // Array de emails
            $M->addAddress('expotecsc2019@gmail.com', $nome);
            foreach ($emails as $email) {$M->addCC($email);}
        }
        if ($tipo==2) { // Email único
            $M->addAddress($emails, $nome);
        }
        
        
	$M->isHTML(); # Informamos que o corpo tem o formato HTML.
        $M->CharSet = 'UTF-8';
        $M->Subject = $assunto;
        $M->Body = $corpo;
        return $M-> send();

}
    


?>
