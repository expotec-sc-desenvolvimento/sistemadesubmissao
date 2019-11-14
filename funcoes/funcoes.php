<?php

    include dirname(__FILE__) . '/../inc/includes.php';
    include dirname(__FILE__) . '/../vendor/autoload.php';
    
    
    function loginObrigatorio () {
        if ( !isset( $_SESSION['usuario'] )) 
            header('Location: index.php?User=NaoLogado');
    }
    
    function verificarPermissaoAcesso($perfilUsuario,$perfisPermitidos,$direcionar) {
        
        foreach ($perfisPermitidos as $perfil) 
            if ($perfil == $perfilUsuario) return;

        header('Location:'.$direcionar.'?User=permissaoNegada');
    }
    

    function validarFoto($tamanho,$tipo) {
        $mensagem="";
        
        $tamanhoMaximoEmBytes = 2 * 1024 * 1024;
        $tiposArquivosPermitidos = "/(.jpg)(.jpeg)(.gif)(.png)/";
        
        
        if (!$tamanho>0) $mensagem = 'Selecione um arquivo válido';
        else if ($tamanho>$tamanhoMaximoEmBytes) $mensagem = 'O Tamanho Máximo da Imagem é de 2MB!';
        else if (!strpos($tiposArquivosPermitidos, $tipo)) $mensagem = 'Tipo de Arquivo não permitido';
        
        return $mensagem;
    }
    
    
    // As funções abaixo estão relacionadas com as classes. As mesmas teriam a mesma estrutura, então foram colocadas como uma função geral
    function retornaRespostaUnica($dado) {
        
        $resposta = -1;
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) {
                    return $value;
                }
            }

        } catch (Exception $e){
            echo  $e->getMessage();
        }

        return $resposta;
    }
    
    function emailAtribuicaoAvaliacao ($submissao,$prazoEnvio,$emails) {
        
        $titulo = "Atribuição de Avaliação de Trabalho";
        $remetente = "Sistema de Submissão";

        $corpo = "Foi cadastrada uma nova Avaliação de Trabalho para você.<br><br> ";
        $corpo .= "<strong>Titulo: </strong>" . $submissao->getTitulo() . "<br>";
        $corpo .= "<strong>Área: </strong>" . Area::retornaDadosArea($submissao->getIdArea())->getDescricao() . "<br>";
	$corpo .= "<strong>Prazo Final: </strong>" . date('d/m/Y', strtotime($prazoEnvio)) . "<br><br>";
	$corpo .= "<strong>Link de acesso ao sistema: </strong> http://lausana.ifrn.edu.br/expotecsc/login <br>";	
	$corpo .= "<strong>Link de acesso ao trabalho: </strong><a href='".$pastaSubmissoes .  $submissao->getArquivo()."' target='blank'>CLIQUE AQUI</a><br><br>";
;
        $corpo .= "<br>Atenciosamente, <br>";
        $corpo .= "<strong>Equipe do Sistema de Submissão - IFRN</strong>";
        
        //echo count($listaAvaliadores); exit(1);
     //   echo $corpo; exit(1);
        
        if (EnviarEmail($titulo,$corpo,$remetente, $emails,1)) { /*echo "Email enviado para " . $user->getNome(); */}
        
        return;
    }
    
    function emailAtualizacaoAvaliacao ($submissao,$prazoEnvio,$email) {
        
        
        
        $titulo = "Atualização de Avaliação de Trabalho";
        $remetente = "Sistema de Submissão";

        $corpo = "Foi atualizada uma nova Avaliação de Trabalho para você.<br><br> ";
        $corpo .= "<strong>Titulo: </strong>" . $submissao->getTitulo() . "<br>";
        $corpo .= "<strong>Área: </strong>" . Area::retornaDadosArea($submissao->getIdArea())->getDescricao() . "<br>";
	$corpo .= "<strong>Prazo Final: </strong>" . date('d/m/Y', strtotime($prazoEnvio)) . "<br><br>";
	$corpo .= "<strong>Link de acesso ao sistema: </strong> http://lausana.ifrn.edu.br/expotecsc/login <br>";	
	$corpo .= "<strong>Link de acesso ao trabalho: </strong><a href='".$pastaSubmissoes .  $submissao->getArquivo()."' target='blank'>CLIQUE AQUI</a><br><br>";

	$corpo .= "<br>Atenciosamente, <br>";
        $corpo .= "<strong>Equipe do Sistema de Submissão - IFRN</strong>";
        
        
        if (EnviarEmail($titulo,$corpo,$remetente, array($email),1)) {};
        
        return;
    }
    
    function emailFinalizacaoSubmissao ($submissao,$emails) {

        $titulo = "Finalização de Submissão";
        $remetente = "Sistema de Submissão";

        
        
        $corpo = "A seguinte submissão foi finalizada:<br><br> ";
        $corpo .= "<strong>Titulo: </strong>" . $submissao->getTitulo() . "<br>";
        $corpo .= "<strong>Área: </strong>" . Area::retornaDadosArea($submissao->getIdArea())->getDescricao() . "<br>";
        $corpo .= "<strong>Situação: </strong>" . SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao() . "<br>";
        
        if ($submissao->getIdSituacaoSubmissao()==5) { // Aprovada com Ressalvas
            $corpo .= "<strong>Prazo Final para envio das correções solicitadas no sistema: </strong>" . date('d/m/Y', strtotime(Evento::retornaDadosEvento($submissao->getIdEvento())->getPrazoFinalEnvioSubmissaoCorrigida())) . "<br><br>";
            $corpo .= "Observe no sistema as correções solicitadas pelos avaliadores e atente-se à data Final para o envio da Ressubmissão!<br>";
        }
        
        if ($submissao->getIdSituacaoSubmissao()==4) { // Se foi uma submissão corrigida
            $corpo .= "Este trabalho foi aprovado e está apto a ser apresentado no evento <strong>".Evento::retornaDadosEvento($submissao->getIdEvento())->getNome()."</strong><br><br>";
        }

	$corpo .= "<strong>Link de acesso ao sistema: </strong> http://lausana.ifrn.edu.br/expotecsc/login <br><br>";	
        $corpo .= "<br>Atenciosamente, <br>";
        $corpo .= "<strong>Equipe do Sistema de Submissão - IFRN</strong>";
        
        
        if (EnviarEmail($titulo,$corpo,$remetente, $emails,1)) {};
        
        return;
    }
    
    function gerarCertificado ($tipo,$idUsuario,$idSubmissao) {
        setlocale(LC_CTYPE, 'pt_BR'); // Defines para pt-br
        date_default_timezone_set('America/Sao_Paulo');
        
        $mes_extenso = array(
            'Jan' => 'Janeiro',
            'Feb' => 'Fevereiro',
            'Mar' => 'Março',
            'Apr' => 'Abril',
            'May' => 'Maio',
            'Jun' => 'Junho',
            'Jul' => 'Julho',
            'Aug' => 'Agosto',
            'Nov' => 'Novembro',
            'Sep' => 'Setembro',
            'Oct' => 'Outubro',
            'Dec' => 'Dezembro'
        );
        
        $mpdfConfig = array(
                'mode' => 'utf-8', 
                'format' => 'A4',    // format - A4, for example, default ''
                'default_font_size' => 0,     // font size - default 0
                'default_font' => '',    // default font family
                'margin_top' => 0,    	// 15 margin_left
                'margin_bottom' => 0,    	// 15 margin_left
                'margin_left' => 0,    	// 15 margin_left
                'margin_right' => 0,    	// 15 margin right
                // 'mgt' => $headerTopMargin,     // 16 margin top
                // 'mgb' => $footerTopMargin,    	// margin bottom
                'margin_header' => 0,     // 9 margin header
                'margin_footer' => 0,     // 9 margin footer
                'orientation' => 'L'  	// L - landscape, P - portrait
        );
        $mpdf=new \Mpdf\Mpdf($mpdfConfig);
        
        $html = "<html>
                    <head>
                        <style>
                            .moldura {
                                background-image: url('".dirname(__DIR__) . '/downloads/certificados/'."modelo.jpg');
                                background-repeat: no-repeat;
                                background-size: 100%;
                                height: 100%;
                                width: 100%;
                                border: solid;
                            }

                            p {
                                text-align: justify;
                                line-height: 1.5;
                                text-indent: 5em;
                                margin-left: 90px;
                                margin-right: 90px;
                                margin-top: 315px;
                                font-size: 20px;
                            }
                            p.data {
                                margin-top: 0;
                                text-align: right;
                                font-size: 20px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='moldura'><p>";
        
        if ($tipo == "Monitoria") {
            $user = UsuarioPedrina::retornaDadosUsuario($idUsuario);
            $nome = strtoupper(iconv('UTF-8', 'ASCII//TRANSLIT', $user->getNome()));
            $html .= "Certificamos que, <strong>". str_replace('\'', '', $nome)."</strong>, CPF: <strong>".$user->getCpf()."</strong>, foi monitor da <strong>IX EXPOTEC – Exposição de Tecnologia, "
                    . "Ciência e Cultura</strong>, ISSN: <strong>2526-6748</strong>, promovida pelo Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Norte – IFRN campus Santa Cruz, "
                    . "realizada no período de 25 a 28 de novembro de 2019, com carga horária de 30 horas.</p>";
           
            $html .= "<p class='data'>Santa Cruz-RN, ".date('d')." de ".$mes_extenso[date('M')]." de ".date('Y').".</p>";
            
            $html .= "</div></body></html>";
            
            $mpdf->WriteHTML($html);
	    //$mpdf->Output();
            
            $nomeArquivo = "Monitor-".$user->getId()."-".substr(md5(time()), 0,10).".pdf";
            
            $mpdf->Output(dirname(__DIR__) . '/downloads/certificados/' . $nomeArquivo,'F');
            if (!Certificado::adicionarCertificado('Monitoria', $idUsuario, $nomeArquivo)) {
                echo "Erro na geração do certificado de " . $user->getNome();
                exit(1);
            }
        }
        else if ($tipo == "Apresentacao") {
            $user = UsuarioPedrina::retornaDadosUsuario($idUsuario);
            $submissao = Submissao::retornaDadosSubmissao($idSubmissao);
            $modalidade = Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao();
            
            $nome = strtoupper(iconv('UTF-8', 'ASCII//TRANSLIT', $user->getNome()));
            $html .= "Certificamos que, <strong>". str_replace('\'', '', $nome)."</strong>, CPF: <strong>".$user->getCpf()."</strong>, apresentou o trabalho intitulado <strong>" . $submissao->getTitulo() . "</strong>"
                    . " na modalidade <strong>".$modalidade."</strong> da <strong>IX EXPOTEC – Exposição de Tecnologia, Ciência e Cultura</strong> ISSN: <strong>2526-6748</strong>, "
                    . "promovida pelo Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Norte – IFRN campus Santa Cruz, "
                    . "realizada no período de 25 a 28 de novembro de 2019.</p>";
           
            $html .= "<p class='data'>Santa Cruz-RN, ".date('d')." de ".$mes_extenso[date('M')]." de ".date('Y').".</p>";
            
            $html .= "</div></body></html>";
            
            $mpdf->WriteHTML($html);
	    //$mpdf->Output();
            
            $nomeArquivo = "Apresentacao-".$idSubmissao."-".substr(md5(time()), 0,10).".pdf";
            
            $mpdf->Output(dirname(__DIR__) . '/downloads/certificados/' . $nomeArquivo,'F');
            if (!Certificado::adicionarCertificado('Apresentacao', $idUsuario, $nomeArquivo)) {
                echo "Erro na geração do certificado de " . $user->getNome();
                exit(1);
            }
        } 
    }
    
    function existeCertificadoApresentacao ($idSubmissao,$idUsuario) {
        foreach (Certificado::listaCertificadosComFiltro('Apresentacao', $idUsuario) as $certificado) {
            $pos = strpos($certificado->getArquivo(), "-".$idSubmissao."-");
            if ($pos === false) continue;
            else return true;
        }
        return false;
    }
    
    function enviarCartaAceite ($submissao,$userSubmissao) {
        
        $user = UsuarioPedrina::retornaDadosUsuario($userSubmissao->getIdUsuario());
        
        $titulo = "IX EXPOTEC - Carta de Aceite";
        $remetente = "Sistema de Submissão";

        $corpo = "Prezado(a) sr(a). <strong>".$user->getNome()."</strong> <br><br>

                A Comissão de avaliação da 9ª EXPOTEC do Campus Santa Cruz do IFRN tem a honra de informar que o trabalho <strong>".$submissao->getTitulo()."</strong> foi 
                <strong>ACEITO</strong> para apresentação na Modalidade <strong>".Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao()."</strong>. 
                Os trabalhos aprovados serão publicados nos anais do evento com ISNN (2526-6748). <br><br>
                Lembramos ainda que não haverá necessidade de enviar NOVA VERSÃO de seu resumo expandido para a publicação nos anais. Serão publicados os resumos dos autores que 
                tiveram seu texto aprovado e que foram informados por meio desta <strong>Carta de Aceite</strong>. <br><br>
                Informamos que as datas e horários de cada apresentação serão disponibilizados no site do evento <strong><a href='http://eventos.ifrn.edu.br/expotecsc'>(http://eventos.ifrn.edu.br/expotecsc)</a></strong><br><br>
                Em caso de dúvidas, favor responder este e-mail.<br><br>

                Atenciosamente,<br>
                <strong>Comissão de avaliação da 9ª EXPOTEC do Campus Santa Cruz do IFRN.</strong>";        
        
        if (EnviarEmail($titulo,$corpo,$remetente, $user->getEmail(),2)) {
            UsuariosDaSubmissao::atualizarUsuariosDaSubmissao($userSubmissao->getId(), $userSubmissao->getIdSubmissao(), 
                                                              $userSubmissao->getIdUsuario(), $userSubmissao->getIsSubmissor(), 
                                                                $userSubmissao->getApresentouTrabalho(), 1);
        }
        return;
    }
?>
