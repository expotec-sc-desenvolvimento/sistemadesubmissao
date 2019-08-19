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