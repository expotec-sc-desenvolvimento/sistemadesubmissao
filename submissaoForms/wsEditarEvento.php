<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    
    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $idEvento = $p['pIdEvento'];
            $nomeEvento = $p['pNomeEvento'];
            $descricaoEvento = $p['pDescricaoEvento'];
            $inicioSubmissao = $p['pInicioSubmissao'];
            $fimSubmissao = $p['pFimSubmissao'];
            $prazoFinalEnvioAvaliacaoParcial = $p['prazoFinalEnvioAvaliacaoParcial'];
            $prazoFinalEnvioSubmissaoCorrigida = $p['prazoFinalEnvioSubmissaoCorrigida'];
            $prazoFinalEnvioAvaliacaoCorrigida = $p['prazoFinalEnvioAvaliacaoCorrigida'];
            $prazoFinalEnvioAvaliacaoFinal = $p['prazoFinalEnvioAvaliacaoFinal'];
            $prazoInscricaoAvaliadores = $p['prazoInscricaoAvaliadores'];
            $distribuicaoAutomaticaAvaliadores = $p['distribuicaoAutomaticaAvaliadores'];
                   
                        
            $tipoArquivo = strtolower(pathinfo($_FILES[ 'pImagem' ]["name"], PATHINFO_EXTENSION));
            $tamanho = $_FILES[ 'pImagem' ][ 'size' ];
            
            $resposta = validarFoto($tamanho, $tipoArquivo);
            
          
            if ($resposta=="") { // Verifica se o usuário fez o upload de algum arquivo
                

                $nomeImagem = $idEvento . "." . $tipoArquivo;

                if (move_uploaded_file($_FILES['pImagem']['tmp_name'], dirname(__DIR__) . "/" . $pastaFotosEventos . $nomeImagem)) { // Tenta Inserir a imagem na pasta
                    if (Evento::atualizarEvento($idEvento, $nomeImagem, $nomeEvento, $descricaoEvento,$inicioSubmissao,$fimSubmissao,$prazoFinalEnvioAvaliacaoParcial,$prazoFinalEnvioSubmissaoCorrigida,
                                                $prazoFinalEnvioAvaliacaoCorrigida,$prazoFinalEnvioAvaliacaoFinal, $prazoInscricaoAvaliadores, $distribuicaoAutomaticaAvaliadores))
                        header('Location: ../gerenciarEventos.php?Item=Atualizado');
                    else echo "<script>window.alert('Houve um erro na Atualização do Evento');window.history.back();</script>";
                }
                else echo "<script>window.alert('Houve um erro no Upload da Imagem. Tente fazer o Upload posteriormente');window.history.back();</script>";
                
            }
            else {
                
                if (!$tamanho>0) {
                    Evento::atualizarEvento($idEvento, -1, $nomeEvento, $descricaoEvento,$inicioSubmissao,$fimSubmissao,$prazoFinalEnvioAvaliacaoParcial,$prazoFinalEnvioSubmissaoCorrigida,
                                                $prazoFinalEnvioAvaliacaoCorrigida,$prazoFinalEnvioAvaliacaoFinal,$prazoInscricaoAvaliadores,$distribuicaoAutomaticaAvaliadores);
                    header('Location: ../gerenciarEventos.php?Item=Atualizado');
                }
                else echo "<script>window.alert('$resposta');window.history.back();</script>";
            }
            
            

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }
?>