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
                    $listaEmails = array();
                    
                    if ($submissao->getIdTipoSubmissao()==1) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoParcial ();
                    else if ($submissao->getIdTipoSubmissao()==2) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoCorrigida ();
                    else if ($submissao->getIdTipoSubmissao()==3) $prazo = Evento::retornaDadosEvento ($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoFinal ();
                    
                    
                    // Coleta os ID's dos avaliadores da área do evento com menos avaliações
                    $contArea=0;
                    $contOutraArea=0;
                    
                    foreach($listaAvaliadoresArea as $usuarioAvaliador) {
                        if (in_array($usuarioAvaliador->getId(), $listaIdsAvaliadores)) continue;
                        else {
                            $idsAvaliadores = $idsAvaliadores . $usuarioAvaliador->getId() . ";";
                            array_push($listaEmails, $usuarioAvaliador);
                            array_push($listaIdsAvaliadores, $usuarioAvaliador->getId());
                            $contArea++;
                            if ($contArea==2) break;
                        }
                    }
                    foreach($listaAvaliadoresOutraArea as $usuarioAvaliador) { 
                        if (in_array($usuarioAvaliador->getId(), $listaIdsAvaliadores)) continue;
                        else {
                            $idsAvaliadores = $idsAvaliadores . $usuarioAvaliador->getId() . ";";
                            array_push($listaEmails, $usuarioAvaliador);
                            array_push($listaIdsAvaliadores, $usuarioAvaliador->getId());
                            $contOutraArea++;
                            if ($contOutraArea==1) break;
                        }
                    }
                    
                   
                 //   echo $idsAvaliadores; exit(1);
                    if (Avaliacao::adicionarAvaliacoes($submissao->getId(),$submissao->getIdTipoSubmissao(),$submissao->getIdModalidade(),$idsAvaliadores,$prazo)) {
                        
                        foreach ($listaEmails as $userEmail) {
                            $user = Usuario::retornaDadosUsuario($userEmail->getId());
                            $titulo = "Atribuição de Avaliação de Trabalho";
                            $remetente = "Sistema de Submissão";

                            $corpo = "Olá, <strong>".$user->getNome()."</strong><br><br>"
                                . "Foi cadastrada uma nova Avaliação de Trabalho para você.<br><br> ";

                            $corpo .= "<strong>Titulo: </strong>" . $submissao->getTitulo() . "<br>";
                            $corpo .= "<strong>Prazo Final: </strong>" . date('d/m/Y', strtotime($prazo)) . "<br><br>";
                            $corpo .= "Atenciosamente, <br>";
                            $corpo .= "<strong>Equipe do Sistema de Submissao</strong>";

                            $EmailUsuario = EnviarEmail($titulo,$corpo,$remetente,$user->getEmail());
                        }
                        
                        
                        header('Location: ../gerenciarSubmissoes.php?Item=Atualizado');
                    }
                    else header('Location: ../gerenciarSubmissoes.php?Item=NaoAtualizado');
                }
                else header('Location: ../gerenciarSubmissoes.php?Item=NaoAtualizado');
            }
            else header('Location: ../gerenciarSubmissoes.php?Item=NaoAtualizado');
            
            $tipoArquivo = strtolower(pathinfo($_FILES[ 'pImagem' ]["name"], PATHINFO_EXTENSION));
            $tamanho = $_FILES[ 'pImagem' ][ 'size' ];
            
            $resposta = validarFoto($tamanho, $tipoArquivo);
            //$novaSenha = substr(md5(time()), 0,6);
            
            if ($resposta=="") { // Verifica se a imagem está de acordo com as especificações esperadas. Se não retornar nenhuma reposta, o arquivo está OK
    
                Evento::adicionarEvento("-1", $nomeEvento, $descricaoEvento,$inicioSubmissao,$fimSubmissao,$prazoFinalEnvioAvaliacaoParcial,$prazoFinalEnvioSubmissaoCorrigida,
                                        $prazoFinalEnvioAvaliacaoCorrigida,$prazoFinalEnvioAvaliacaoFinal,$distribuicaoAutomaticaAvaliadores);
                
                $idEvento = Evento::retornaIdUltimoEvento();

                $nomeImagem = $idEvento . "." . $tipoArquivo;

                if (move_uploaded_file($_FILES['pImagem']['tmp_name'], './../' . $pastaFotosEventos . $nomeImagem)) { // Tenta Inserir a imagem na pasta
                    if (Evento::atualizarEvento($idEvento, $nomeImagem, $nomeEvento, $descricaoEvento,$inicioSubmissao,$fimSubmissao,$prazoFinalEnvioAvaliacaoParcial,$prazoFinalEnvioSubmissaoCorrigida,
                                                $prazoFinalEnvioAvaliacaoCorrigida,$prazoFinalEnvioAvaliacaoFinal,$distribuicaoAutomaticaAvaliadores))
                        header('Location: ../gerenciarEventos.php?Item=Criado');
                    else echo "<script>window.alert('Houve um erro na Criação do Evento');window.history.back();</script>";
                }
                else echo "<script>window.alert('Houve um erro no Upload da Imagem. Tente fazer o Upload posteriormente');window.history.back();</script>";
               
            }
            else {
                echo "<script>window.alert('$resposta');window.history.back();</script>";
                
            }

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>