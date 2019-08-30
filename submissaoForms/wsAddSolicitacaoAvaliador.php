<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $idUsuario = $p['idUsuario'];
            $idEvento = $p['select-Eventos'];
            $idArea = $p['select-Areas'];
            
            
            
            $solicitacoesPendentes = SolicitacaoAvaliador::listaSolicitacaoAvaliadorComFiltro($idUsuario, $idEvento, $idArea, 'Pendente');
            $usuarioJaAvaliador = SolicitacaoAvaliador::listaSolicitacaoAvaliadorComFiltro($idUsuario, $idEvento, $idArea, 'Deferida');
            
            if (count($solicitacoesPendentes)>0) {
                header('Location: ../solicitacaoAvaliador.php?Solicitacao=Pendente');
            }
            else if(count($usuarioJaAvaliador)) 
                header('Location: ../solicitacaoAvaliador.php?Solicitacao=UsuarioAvaliador');
            else {
                if (SolicitacaoAvaliador::adicionarSolicitacaoAvaliador($idUsuario, $idEvento, $idArea)) {
                    header('Location: ../solicitacaoAvaliador.php?Item=Criado');
                }
                else echo "<script>window.alert('Houve um erro na Solicitação. Entre em contato com um Administrador do Sistema');window.history.back();</script>";
            }

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>