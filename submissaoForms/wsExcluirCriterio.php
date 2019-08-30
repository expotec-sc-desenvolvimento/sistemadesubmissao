<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    
    if ($metodoHttp === 'GET') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $idCriterio = $_GET['id'];

            $criterio = new Criterio();
            $criterio = Criterio::retornaDadosCriterio($idCriterio);
            
            
            if ($criterio->getId()!="") {
                if (Criterio::excluirCriterio($idCriterio)) {
                    header('Location: ../gerenciarMOdalidades.php?Item=Excluido');
                }
                else {
                    header('Location: ../gerenciarMOdalidades.php?Item=NaoExcluido');
                }
                
            }
            else {
                echo "<script>window.alert('Criterio Inválido!');window.history.back();</script>";
            }
            
            

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }
?>