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
            
            $idUsuario = $_GET['id'];

            $usuario = Usuario::retornaDadosUsuario($idUsuario);

            if ($usuario->getId()!="") {
                if (Usuario::excluirUsuario($idUsuario)) 
                    header('Location: ../gerenciarUsuarios.php?Item=Excluido');
                
                else {
                    header('Location: ../gerenciarUsuarios.php?Item=NaoExcluido');
                }
            }
            else {
                echo "<script>window.alert('Usuário Inválido!');window.history.back();</script>";
            }
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>