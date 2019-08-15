<?php

    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $idSubmissao = $p['idSubmissao'];
            $idUsuariosAdd = $p['idUsuariosAdd'];
            $idEvento = $p['select-Eventos'];
            $idModalidade = $p['select-Modalidades'];
            $idArea = $p['select-Areas'];
            
            $titulo = $p['titulo'];
            $resumo = $p['resumo'];
            $palavrasChave = $p['palavrasChave'];
            $relacaoCom = Submissao::retornaDadosSubmissao($idSubmissao)->getRelacaoCom();
            
            $tipoArquivo = "/(.pdf)/";  
            $tipo = strtolower(pathinfo($_FILES[ 'arquivo' ]["name"], PATHINFO_EXTENSION));
            
    
            if (!strpos($tipoArquivo, $tipo)) { // Verifica o tipo de arquivo enviado
                echo "<script>window.alert('Tipo de Arquivo não permitido');window.history.back();</script>";
            }
            else {
                $evento = Evento::retornaDadosEvento($idEvento);
                $modalidade = Modalidade::retornaDadosModalidade($idModalidade);
                $novoArquivo = $evento->getNome() . "-" . $modalidade->getDescricao() . "-" . substr(md5(time()), 0,15) . "-Corrigida.pdf";
                
                
                // Tipo Submissao: 1-Parcial / 2-Corrigda / 3-Final
                // Situacao Submissao: 1-Submetida / 3-Em Avaliacao
                if (Submissao::adicionarSubmissao($idEvento, $idArea, $idModalidade,2,3,$novoArquivo,$titulo,$resumo,$palavrasChave,$relacaoCom,$idUsuariosAdd,$idSubmissao)) {
                    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], './../' . $pastaSubmissoes . $novoArquivo)) { // Tenta Inserir a imagem na pasta
                        
                        $novaSubmissao = Submissao::retornaSubmissaoCorrigidaPelaParcial($idSubmissao);
                        // CODIGO PARA GERAR AS AVALIACOES PARA OS AVALIADORES;
                        // Situação Avaliacao: 4-Aprovado, 5-Aprovado com Ressalvas, 6 - Reprovado
                        foreach (Avaliacao::listaAvaliacoesComFiltro('', $idSubmissao, '') as $av) {
                            if ($av->getIdSituacaoAvaliacao()==5) {
                                if (!Avaliacao::adicionarAvaliacoes($novaSubmissao->getId(), 2, $idModalidade, $av->getIdUsuario().";", $evento->getPrazoFinalEnvioAvaliacaoCorrigida())) {
                                    echo "erro"; exit(1);
                                }
                            }
                            else {
                                if (!Avaliacao::adicionarAvaliacoesAutomaticas($novaSubmissao->getId(),$av->getIdUsuario(),$av->getIdSituacaoAvaliacao(),'AVALIAÇÃO GERADA AUTOMATICAMENTE PELO SISTEMA')) {
                                    echo "erro 1"; exit(1);
                                }
                            }
                        }
                        
                        header('Location: ../minhasSubmissoes.php?Item=Criado');
                    }
                    else echo "<script>window.alert('2-Houve um erro na Submissao. Entre em contato com um Administrador do Sistema');window.history.back();";
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