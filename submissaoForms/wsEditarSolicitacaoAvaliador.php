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
            
            $idSolicitacao = $p['idSolicitacao'];
            $idUsuario = $p['idUsuario'];
            $idEvento = $p['idEvento'];
            $idArea = $p['idArea'];
            $situacao = $p['select-Situacao'];
            $observacao = $p['observacao'];

            
            
            $solicitacao = SolicitacaoAvaliador::retornaDadosSolicitacoesAvaliador($idSolicitacao);

            
            if ($solicitacao->getId()!="") {
                
                if (SolicitacaoAvaliador::atualizarSolicitacaoAvaliador($idSolicitacao, $idUsuario, $idEvento, $idArea, $situacao, $observacao)) {
                    header("Location: ../gerenciarSolicitacoesAvaliadores.php?Item=Criado");
                }
                else {
                    header("Location: ../gerenciarSolicitacoesAvaliadores.php?Item=NaoCriado");
                }
            }
            else {
                echo "<script>window.alert('Solicitação Inválida!');window.history.back();</script>";
            }
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>