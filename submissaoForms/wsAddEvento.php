<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            
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
            //$novaSenha = substr(md5(time()), 0,6);
            
            if ($resposta=="") { // Verifica se a imagem está de acordo com as especificações esperadas. Se não retornar nenhuma reposta, o arquivo está OK
    
                Evento::adicionarEvento("-1", $nomeEvento, $descricaoEvento,$inicioSubmissao,$fimSubmissao,$prazoFinalEnvioAvaliacaoParcial,$prazoFinalEnvioSubmissaoCorrigida,
                                        $prazoFinalEnvioAvaliacaoCorrigida,$prazoFinalEnvioAvaliacaoFinal,$prazoInscricaoAvaliadores,$distribuicaoAutomaticaAvaliadores);
                
                $idEvento = Evento::retornaIdUltimoEvento();

                $nomeImagem = $idEvento . "." . $tipoArquivo;

                if (move_uploaded_file($_FILES['pImagem']['tmp_name'], dirname(__DIR__) . "/" . $pastaFotosEventos . $nomeImagem)) { // Tenta Inserir a imagem na pasta
                    if (Evento::atualizarEvento($idEvento, $nomeImagem, $nomeEvento, $descricaoEvento,$inicioSubmissao,$fimSubmissao,$prazoFinalEnvioAvaliacaoParcial,$prazoFinalEnvioSubmissaoCorrigida,
                                                $prazoFinalEnvioAvaliacaoCorrigida,$prazoFinalEnvioAvaliacaoFinal, $prazoInscricaoAvaliadores,$distribuicaoAutomaticaAvaliadores))
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