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

            
            $idModalidade = $p['pIdModalidade'];
            $tipoCriterio = $p['pTipoCriterio'];
            $descricao = $p['pDescricao'];
            $detalhamento = $p['pDetalhamento'];
            $peso = $p['pPeso'];
            
            
            if (Criterio::adicionarCriterio($idModalidade, $tipoCriterio, $descricao, $detalhamento,$peso)) {
                header('Location: ../gerenciarModalidades.php?Item=Criado');
            }
            else header('Location: ../gerenciarModalidades.php?Item=NaoCriado');
            
            
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>