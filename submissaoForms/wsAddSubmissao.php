<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $idUsuariosAdd = $p['idUsuariosAdd'];
            $idEvento = $p['select-Eventos'];
            $idModalidade = $p['select-Modalidades'];
            $idArea = $p['select-Areas'];
            
            $titulo = $p['titulo'];
            $resumo = $p['resumo'];
            $palavrasChave = $p['palavrasChave'];
            $relacaoCom = $p['relacaoCom'];
            
            $tipoArquivo = "/(.pdf)/";  
            $tipo = strtolower(pathinfo($_FILES[ 'arquivo' ]["name"], PATHINFO_EXTENSION));
            
    
            if (!strpos($tipoArquivo, $tipo)) { // Verifica o tipo de arquivo enviado
                echo "<script>window.alert('Tipo de Arquivo não permitido');window.history.back();</script>";
            }
            else if ($_FILES[ 'arquivo' ][ 'size' ]==0 || $_FILES[ 'arquivo' ][ 'size' ]>(5 * 1024 * 1024)) {
                echo "<script>window.alert('Tamanho de arquivo inválido. O arquivo deve ter, no máximo, 5MB!');window.history.back();</script>";
            }
            else {
                $evento = Evento::retornaDadosEvento($idEvento);
                $modalidade = Modalidade::retornaDadosModalidade($idModalidade);
                $idTipoSubmissao = TipoSubmissao::retornaIdTipoSubmissao("Parcial");
                
                
                
                
                $novoArquivo = $evento->getNome() . "-" . $modalidade->getDescricao() . "-" . substr(md5(time()), 0,15) . "-Parcial.pdf";

                //echo $novoArquivo; exit(1);
                // CONTINUAR DAQUI
                
                if (Submissao::adicionarSubmissao($idEvento, $idArea, $idModalidade,$idTipoSubmissao,1,$novoArquivo,$titulo,$resumo,$palavrasChave,$relacaoCom,$idUsuariosAdd,'')) {
                    
                    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], dirname(__DIR__) . "/" . $pastaSubmissoes . $novoArquivo)) { // Tenta Inserir a imagem na pasta
                        
                        if ($evento->getDistribuicaoAutomaticaAvaliadores()==1) {
                            $id = Submissao::retornaIdUltimaSubmissao();
                            $submissao = Submissao::retornaDadosSubmissao($id);
                            
                            
                            $avaliadoresArea = Avaliador::listaAvaliadoresParaCadastro($idEvento,$idArea,'mesma-area',2,$id);
                            $avaliadorOutraArea = Avaliador::listaAvaliadoresParaCadastro($idEvento,$idArea,'outra-area',1,$id);
                            
                            if (count($avaliadoresArea)>=2 && count($avaliadorOutraArea)>=1) {
                                $idsAvaliadores="";
                                $emails = array();
                                // Coleta os ID's dos avaliadores da área do evento com menos avaliações
                                foreach($avaliadoresArea as $usuarioAvaliador)    {
                                    $idsAvaliadores = $idsAvaliadores . $usuarioAvaliador->getIdUsuario() . ";";
                                    array_push($emails, UsuarioPedrina::retornaDadosUsuario($usuarioAvaliador->getIdUsuario())->getEmail());
                                }
                                foreach($avaliadorOutraArea as $usuarioAvaliador) {
                                    $idsAvaliadores = $idsAvaliadores . $usuarioAvaliador->getIdUsuario() . ";";
                                    array_push($emails, UsuarioPedrina::retornaDadosUsuario($usuarioAvaliador->getIdUsuario())->getEmail());
                                }

                                $prazo="";
                    
                                if ($submissao->getIdTipoSubmissao()==1) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoParcial ();
                                else if ($submissao->getIdTipoSubmissao()==2) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoCorrigida ();
                                else if ($submissao->getIdTipoSubmissao()==3) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoFinal ();
                                
                                if (Avaliacao::adicionarAvaliacoes($id,1,$idModalidade,$idsAvaliadores,$prazo)) {
                                    emailAtribuicaoAvaliacao(Submissao::retornaDadosSubmissao($id), $prazo, $emails);
                                    header('Location: ../minhasSubmissoes.php?Item=Criado');
                                }
                            }
                            else header('Location: ../minhasSubmissoes.php?Item=Criado');
                        }
                        header('Location: ../minhasSubmissoes.php?Item=Criado');
                        
                    }
                    else {echo "<script>window.alert('2-Houve um erro na Submissao. Entre em contato com um Administrador do Sistema');window.history.back();";}
                }

                else echo "<script>window.alert('1-Houve um erro na Submissao. Entre em contato com um Administrador do Sistema');window.history.back();</script>";
                
            }
            

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>