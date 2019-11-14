<?php

require_once dirname(__FILE__) . '/PHPMailer-5.2.27/PHPMailerAutoload.php';


    
        // Tipo: 1 - Email com cópia para o email principal; Tipo: 2 - Email de recuperação de senha, enviado apenas para o usuário
    
        $assunto = "IX EXPOTEC - Carta de Aceite";
        $nome = "Sistema de Submissão";
        $email = "sueney.lima@ifrn.edu.br";
        
        $corpo = "Prezado(a) sr(a). <strong>Dedeudo</strong> <br><br>

                A Comissão de avaliação da 9ª EXPOTEC do Campus Santa Cruz do IFRN tem a honra de informar que o trabalho <strong>«Título do trabalho»</strong> foi <strong>ACEITO</strong> para apresentação na Modalidade <strong>«Modalidade»</strong>. Os trabalhos aprovados serão publicados nos anais do evento com ISNN (2526-6748). <br><br>
                Lembramos ainda que não haverá necessidade de enviar NOVA VERSÃO de seu resumo expandido para a publicação nos anais. Serão publicados os resumos dos autores que tiveram seu texto aprovado e que foram informados por meio desta <strong>Carta de Aceite</strong>. <br><br>
                Informamos que as datas e horários de cada apresentação serão disponibilizados no site do evento <strong><a href='http://eventos.ifrn.edu.br/expotecsc'>(http://eventos.ifrn.edu.br/expotecsc)</a></strong><br><br>
                Em caso de dúvidas, favor responder este e-mail.<br><br>

                Atenciosamente,<br>
                <strong>Comissão de avaliação da 9ªEXPOTEC do Campus Santa Cruz do IFRN.</strong>";
        
        
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
        
        $M->addAddress($email, $nome);

        
	$M->isHTML(); # Informamos que o corpo tem o formato HTML.
        $M->CharSet = 'UTF-8';
        $M->Subject = $assunto;
        $M->Body = $corpo;
        return $M-> send();


    


?>
