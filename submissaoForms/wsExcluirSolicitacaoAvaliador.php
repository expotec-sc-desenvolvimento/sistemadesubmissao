<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    if ($metodoHttp === 'GET') {
        try {
            
            $solicitacaoAvaliador = SolicitacaoAvaliador::retornaDadosSolicitacoesAvaliador($_GET['id']);

            if ($solicitacaoAvaliador->getId()=="" || $solicitacaoAvaliador->getIdUsuario()!=$usuario->getId() || $solicitacaoAvaliador->getSituacao()!="Pendente") header("Location: ../paginaInicial.php");
            else if (SolicitacaoAvaliador::excluirSolicitacaoAvaliador($solicitacaoAvaliador->getId())) header("Location: ../solicitacaoAvaliador.php?Item=Excluido");
            else header("Location: ../solicitacaoAvaliador.php?Item=NaoExcluido");
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>