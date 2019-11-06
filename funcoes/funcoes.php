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
    
    function gerarCertificado ($evento,$user,$tipo,$pasta) {
        
        if ($tipo==1) {
            $html = "
            <html>
            <head>
                <meta charset='UTF-8'>
                    <style type='text/css'>
                        p {
                                text-align: justify;
                                line-height: 2.0;
                                text-indent: 10em;
                                margin-left: 70px;
                                margin-right: 70px;
                                font-size: 20px;
                        }
                    </style>

            <body>
            <fieldset>
            <h1 ALIGN=CENTER>CERTIFICADO DE APRESENTAÇÃO DE TRABALHO</h1>
            <p> Certificamos para os devidos fins que <strong>".$user->getNome()."</strong> apresentou um trabalho aqui! Parabéns!
            </p>
            </div>
            </body>
            </html>
            ";

            $mpdf=new \Mpdf\Mpdf();
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->AddPage('L');
            //$css = file_get_contents("css/estilo.css");
            //$mpdf->WriteHTML($css,1);
            $mpdf->WriteHTML($html);
            
            
            $nomeArquivo = $user->getId() ."-". substr(md5(time()), 0,25) . ".pdf";
            $mpdf->Output('./../'.$pasta.$nomeArquivo,'F');
                    
            Certificado::adicionarCertificado($evento->getId(), $user->getId(), $tipo, $nomeArquivo);
        }
        
    }
?>
