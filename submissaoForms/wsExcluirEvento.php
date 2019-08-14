<?php

    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    if ($metodoHttp === 'GET') {
        try {
            
            $idEvento = $_GET['id'];

            $evento = Evento::retornaDadosEvento($idEvento);
            
            
            if ($evento->getId()!="") {
                
                if (Evento::excluirEvento($idEvento)) {
                    unlink('./../' . $pastaFotosEventos . $evento->getLogo());    
                    header('Location: ../gerenciarEventos.php?Item=Excluido');
                }
                else {
                    header('Location: ../gerenciarEventos.php?Item=NaoExcluido');
                }
                
            }
            else {
                echo "<script>window.alert('Evento Inválido!');window.history.back();</script>";
            }
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>