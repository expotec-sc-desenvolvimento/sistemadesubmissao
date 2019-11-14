<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página

    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');


    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $cpf = $p['cpf'];
            $nome = $p['nome'];
            $sobrenome = $p['sobrenome'];
            $email = $p['email'];
            $dataNascimento = $p['dataNascimento'];
            $tipoUsuario = $p['tipoUsuario'];
            $perfil = $p['perfil'];
            $idUsuario = $p['idUsuario'];
            

            if (Usuario::atualizarUsuario($idUsuario, $perfil, $cpf, $nome, $sobrenome, $dataNascimento, $email, $tipoUsuario)) {
                header('Location: ../gerenciarUsuarios.php?Item=Atualizado');
            }
            else {    
                header("Location: ../editarUsuario.php?idUsuario=". $idUsuario . "&dados=existentes");
            }
            

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }