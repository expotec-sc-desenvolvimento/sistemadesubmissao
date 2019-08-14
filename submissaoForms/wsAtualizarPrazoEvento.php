<?php

    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
    
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');


    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $idPrazo = $p['idPrazo'];
            $idEvento = $p['idEvento'];
            $idTipoPrazo = $p['idTipoPrazo'];
            $dias = $p['dias'];

            
            
            if (PrazosEvento::atualizarPrazosEvento($idPrazo,$idEvento,$idTipoPrazo,$dias)) {
                header('Location: ../gerenciarEventos.php?Item=Atualizado');
            }
            else {
                echo "<script>window.alert('Erro na atualização!');window.history.back();</script>";
            }
            
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>