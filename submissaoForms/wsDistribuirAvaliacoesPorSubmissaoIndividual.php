<?php

    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    
    
    if ($metodoHttp === 'GET') {
        try {

            $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
            
            if ($submissao->getId()=="") echo "<script>window.alert('Submissao Inválida');window.history.back();</script>";

            if ($submissao->getIdSituacaoSubmissao()==1 && count(Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), ''))==0) { // Se a submissão estiver no estado 'SUBMETIDA' e não possui avaliadores...
                
                $listaAvaliadoresArea = Usuario::listaAvaliadoresParaCadastro($submissao->getIdEvento(),$submissao->getIdArea(),'mesma-area',30,$submissao->getId());
                $listaAvaliadoresOutraArea = Usuario::listaAvaliadoresParaCadastro($submissao->getIdEvento(),$submissao->getIdArea(),'outra-area',30,$submissao->getId());
                    
                if (count($listaAvaliadoresArea)>=2 && count($listaAvaliadoresOutraArea)>=1) {
                    // DISTRIBUIR AVALIADORES
                    $idsAvaliadores="";
                    $prazo="";
                    $listaIdsAvaliadores = array();
                    
                    if ($submissao->getIdTipoSubmissao()==1) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoParcial ();
                    else if ($submissao->getIdTipoSubmissao()==2) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoCorrigida ();
                    else if ($submissao->getIdTipoSubmissao()==3) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoFinal ();
                    
                    
                    // Coleta os ID's dos avaliadores da área do evento com menos avaliações
                    $contArea=0;
                    $contOutraArea=0;
                    $emails = array();
                    
                    
                    foreach($listaAvaliadoresArea as $usuarioAvaliador) {
                        if (in_array($usuarioAvaliador->getId(), $listaIdsAvaliadores)) continue;
                        else {
                            $idsAvaliadores = $idsAvaliadores . $usuarioAvaliador->getId() . ";";
                            array_push($listaIdsAvaliadores, $usuarioAvaliador->getId());
                            array_push($emails, Usuario::retornaDadosUsuario($usuarioAvaliador->getId())->getEmail());
                            $contArea++;
                            if ($contArea==2) break;
                        }
                    }
                    foreach($listaAvaliadoresOutraArea as $usuarioAvaliador) { 
                        if (in_array($usuarioAvaliador->getId(), $listaIdsAvaliadores)) continue;
                        else {
                            $idsAvaliadores = $idsAvaliadores . $usuarioAvaliador->getId() . ";";
                            array_push($listaIdsAvaliadores, $usuarioAvaliador->getId());
                            array_push($emails, Usuario::retornaDadosUsuario($usuarioAvaliador->getId())->getEmail());
                            $contOutraArea++;
                            if ($contOutraArea==1) break;
                        }
                    }
                    
                   
                 //   echo $idsAvaliadores; exit(1);
                    if (Avaliacao::adicionarAvaliacoes($submissao->getId(),$submissao->getIdTipoSubmissao(),$submissao->getIdModalidade(),$idsAvaliadores,$prazo)) {
                        
                        emailAtribuicaoAvaliacao($submissao, $prazo, $emails);
                        header('Location: ../gerenciarSubmissoes.php?Item=Atualizado');

                    }
                    else header('Location: ../gerenciarSubmissoes.php?Item=NaoAtualizado');
                }
                else header('Location: ../gerenciarSubmissoes.php?Item=NaoAtualizado');
            }
            else header('Location: ../gerenciarSubmissoes.php?Item=NaoAtualizado');
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>