<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');
    
    if (isset($_GET['id'])) {
        
        
        if (Submissao::finalizarSubmissao($_GET['id'])) {
            $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
            $emails = array();
            foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '') as $userSubmissao) {
                array_push($emails, Usuario::retornaDadosUsuario($userSubmissao->getIdUsuario())->getEmail());
            }
            // REVER
            emailFinalizacaoSubmissao($submissao,$emails); // Envio de email para os usuários saberem que a submissão foi finalizada
            
            if ($submissao->getIdTipoSubmissao()==2 && $submissao->getIdSituacaoSubmissao()==4) { /* Caso seja uma submissão Corrigida e tenha sido considerada Aprovada depois
                                                                                                        das devidas correções, é gerada uma submissão Final automaticamente */
                    $evento = Evento::retornaDadosEvento($submissao->getIdEvento());
                    $modalidade = Modalidade::retornaDadosModalidade($submissao->getIdModalidade());
                    $novoArquivo = $evento->getNome() . "-" . $modalidade->getDescricao() . "-" . substr(md5(time()), 0,15) . "-Final.pdf";
                    $idUsuariosAdd = "";
                    
                    foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '') as $user) {
                        $idUsuariosAdd .= $user->getIdUsuario() . ";";
                    }
                    
                    
                    if (Submissao::adicionarSubmissao($submissao->getIdEvento(), $submissao->getIdArea(), $submissao->getIdModalidade(),3,3,$novoArquivo,$submissao->getTitulo(),
                                                      $submissao->getResumo(),$submissao->getPalavrasChave(),$submissao->getRelacaoCom(),$idUsuariosAdd,$submissao->getId())) {
                        
                        copy(dirname('__DIR__') . '/' . $pastaSubmissoes . $submissao->getArquivo(), dirname('__DIR__') . '/' . $pastaSubmissoes . $novoArquivo);
                        
                        $novosAvaliadores = "";
                        $emails = array();
                        
                        $prazo = Evento::retornaDadosEvento($submissao->getIdEvento())->getPrazoFinalEnvioSubmissaoCorrigida();
                        $avaliadoresAnteriores = Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), '');
                        
                        foreach ($avaliadoresAnteriores as $avaliador) { 
                            $novosAvaliadores .= $avaliador->getIdUsuario() . ";";
                            array_push($emails, Usuario::retornaDadosUsuario($avaliador->getIdUsuario())->getEmail());   
                        }
                        
                        $sub = Submissao::retornaDadosSubmissao(Submissao::retornaIdUltimaSubmissao());
                        
                        
                        
                        if (Avaliacao::adicionarAvaliacoes($sub->getId(), 3, $submissao->getIdModalidade(), $novosAvaliadores, $prazo)) {
                            emailAtribuicaoAvaliacao($sub, $prazo, $emails);
                            header('Location: ../gerenciarSubmissoes.php?Item=Atualizado');
                        }
                        else header('Location: ../gerenciarSubmissoes.php?Item=NaoAtualizado');
                        
                    }
                    else {
                        echo "OCORREU UM ERRO. CONTACTE O ADMINISTRADOR";
                        exit(1);
                    }
                    //GERA UMA NOVA SUBMISSAO

                }
                else if ($submissao->getIdTipoSubmissao()==3 && $submissao->getIdSituacaoSubmissao()==7) { /* Caso seja uma submissão Final e todos os avaliadores tenham terminado
                                                                                                        a avaliação, são gerados certificados de Apresentação para os submissores */
                    
                    foreach(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '') as $user) {
                        $evento = Evento::retornaDadosEvento($submissao->getIdEvento());
                        gerarCertificado($evento, Usuario::retornaDadosUsuario($user->getIdUsuario()),1,$pastaCertificados);
                        

                    }
                }
               // else {echo "PQP"; exit(1);}
                header('Location: ../gerenciarSubmissoes.php?Item=Atualizado');
        }
        else header('Location: ../gerenciarSubmissoes.php?Item=NaoAtualizado');
    }
    else echo "<script>window.alert('Submissão Inválida!');window.history.back();</script>";
?>