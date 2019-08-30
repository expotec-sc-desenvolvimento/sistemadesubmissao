<?php


    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
        
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    
    
    
    
    if ($metodoHttp === 'POST') {
        try {
            
            $p = filter_input_array(INPUT_POST);    

            $avaliacao = new Avaliacao();
            $avaliacao = Avaliacao::retornaDadosAvaliacao($p['idAvaliacao']);
            
            if ($avaliacao->getId()=="" || ($avaliacao->getIdUsuario() != $usuario->getId())) header('Location: ./paginaInicial.php');
            
            $tipoAvaliacao = TipoSubmissao::retornaDadosTipoSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdTipoSubmissao())->getId();
            // 1 = Parcial , 2 = Corrigida , 3 - Final
            
            $idAvaliacao = $p['idAvaliacao'];
            $observacao = $p['observacao'];
            
            $situacaoAvaliacao = '';
            $notas = "";
            $somaNotas = 0;
            $somaPesos = 0;
                
            if ($tipoAvaliacao==1 || $tipoAvaliacao==2) $situacaoAvaliacao = $p['resultadoAvaliacao']; // Avaliação Aprovado(a), Aprovado(a) com Ressalvas ou Reprovado(a)
            else $situacaoAvaliacao = 2; // Avaliação Finalizada
            
            $avaliacaoCriterios = AvaliacaoCriterio::retornaCriteriosParaAvaliacao($avaliacao->getId());
            
            //echo $tipoAvaliacao . " - " . $idAvaliacao . " - " . $observacao . " - " . $situacaoAvaliacao; exit(1);

                
            foreach ($avaliacaoCriterios as $avaliacaoCriterio) {

                $notas = $notas . $avaliacaoCriterio->getId() ."=". $p[$avaliacaoCriterio->getId()] . ";";

                if ($tipoAvaliacao==3) { // Caso seja avaliação final, terá nota ponderada
                    $somaNotas += ($p[$avaliacaoCriterio->getId()] * Criterio::retornaDadosCriterio($avaliacaoCriterio->getIdCriterio())->getPeso());
                    $somaPesos += Criterio::retornaDadosCriterio($avaliacaoCriterio->getIdCriterio())->getPeso();
                }
            }

            if ($tipoAvaliacao==1 || $tipoAvaliacao==2) $notaFinalAvaliacao = ''; // Caso seja uma avaliação Parcial/Corrigida, não necessita de Nota
            else $notaFinalAvaliacao = round($somaNotas / $somaPesos);
            
            
            
            if (Avaliacao::realizarAvaliacao($avaliacao->getId(),$situacaoAvaliacao,$notas,$notaFinalAvaliacao,$observacao)) {
                // Tipo de Submissao: 1-Parcial, 2-Corrigida, 3-Final
                // Situação das Submissões: 4-Aprovado, 6-Reprovado

                $submissao = Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao());
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
                        
                        copy('./../' . $pastaSubmissoes . $submissao->getArquivo(), './../' . $pastaSubmissoes . $novoArquivo);
                        
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
                            header('Location: ../minhasAvaliacoes.php?Item=Atualizado');
                        }
                        else header('Location: ../minhasAvaliacoes.php?Item=NaoAtualizado');
                        
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
                header('Location: ../minhasAvaliacoes.php?Item=Atualizado');
            }
            else header('Location: ../minhasAvaliacoes.php?Item=NaoAtualizado');
            
            /* Caso a avaliação não exista ou o usuário que tenta acessar essa avaliação não é o usuário para qual a avaliação está vinculada,
               o usuário é redirecionado para a página inicial*/ 
            
            
            
            
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }
    
?>