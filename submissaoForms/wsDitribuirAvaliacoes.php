<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $idEvento = $p['select-Eventos'];
            $idTipoAvalicao = $p['select-tipoAvaliacao'];
            
            $qtdeAvaliadoresArea = 2;
            $qtdeAvaliadoresOutraArea = 1;

            $submissoes = Submissao::listaSubmissoesComFiltro($idEvento, '', '', 1, $idTipoAvalicao); // Situação 1 = Submetida
            
            $avaliacoesComAvaliadores = 0;
            $avaliacoesSemAvaliadores = 0;
            
            //echo "Quantidade de avaliadores para a área: " . $qtdeAvaliadoresArea . "<br>"
            //        . "Quantidade de avaliadores para outra área: " . $qtdeAvaliadoresOutraArea . "<br><br>";
            
            
            foreach($submissoes as $submissao) {
                $listaAvaliadoresArea = Avaliador::listaAvaliadoresParaCadastro($submissao->getIdEvento(),$submissao->getIdArea(),'mesma-area',$qtdeAvaliadoresArea,$submissao->getId());
                $listaAvaliadoresOutraArea = Avaliador::listaAvaliadoresParaCadastro($submissao->getIdEvento(),$submissao->getIdArea(),'outra-area',$qtdeAvaliadoresOutraArea,$submissao->getId());
                
                
                if (count($listaAvaliadoresArea)>=$qtdeAvaliadoresArea && count($listaAvaliadoresOutraArea)>=$qtdeAvaliadoresOutraArea) {
                    // DISTRIBUIR AVALIADORES
                    $idsAvaliadores="";
                    $emails = array();
                    
                    // Coleta os ID's dos avaliadores da área do evento com menos avaliações
                    foreach($listaAvaliadoresArea as $usuarioAvaliador) {
                        $idsAvaliadores = $idsAvaliadores . $usuarioAvaliador->getIdUsuario() . ";";
                        array_push($emails, Usuario::retornaDadosUsuario($usuarioAvaliador->getIdUsuario())->getEmail());
                        
                    }
                    
                    // Coleta os ID's dos avaliadores de outras áreas do evento com menos avaliações
                    if ($qtdeAvaliadoresOutraArea>0) {
                        foreach($listaAvaliadoresOutraArea as $usuarioAvaliador) {
                            $idsAvaliadores = $idsAvaliadores . $usuarioAvaliador->getIdUsuario() . ";";
                            array_push($emails, UsuarioPedrina::retornaDadosUsuario($usuarioAvaliador->getIdUsuario())->getEmail());
                        }
                    }
                    
                    $prazo="";
                    
                    if ($submissao->getIdTipoSubmissao()==1) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoParcial ();
                    else if ($submissao->getIdTipoSubmissao()==2) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoCorrigida ();
                    else if ($submissao->getIdTipoSubmissao()==3) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoFinal ();
                    
                    if (Avaliacao::adicionarAvaliacoes($submissao->getId(),$submissao->getIdTipoSubmissao(),$submissao->getIdModalidade(),$idsAvaliadores,$prazo)) {
                        emailAtribuicaoAvaliacao($submissao, $prazo, $emails);
                    }
                    else $avaliacoesSemAvaliadores+=1;                
                }
                else $avaliacoesSemAvaliadores+=1;                
            }
           // echo "saiu"; exit(1);
            /*echo "Avaliacoes com avaliadores: " . $avaliacoesComAvaliadores . "<br>"
                    . "Avaliacoes sem avaliadores: " . $avaliacoesSemAvaliadores . "<br>"; */
              
                header('Location: ../gerenciarSubmissoes.php?Item=Atualizado');
            } catch (Exception $e) {
            $e->getMessage();
        }
    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>