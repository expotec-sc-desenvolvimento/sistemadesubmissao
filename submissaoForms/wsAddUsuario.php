<?php

    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $cpf = $p['cpf'];
            $nome = $p['nome'];
            $sobrenome = $p['sobrenome'];
            $senha = md5("12345");
            $dataNascimento = $p['dataNascimento'];
            $email = $p['email'];
            $tipoUsuario = $p['tipoUsuario'];
            $perfil = $p['perfil'];

            
            $caracteresCPF = array(".", "-");
            $foto = str_replace($caracteresCPF,"",$cpf) . ".jpg";
            
            if (Usuario::adicionarUsuario($perfil,$cpf, $nome, $sobrenome, $senha,$dataNascimento, $email, $tipoUsuario,$foto)) {
                copy('./../' . $pastaFotosPerfil . "semFoto.jpg", './../' . $pastaFotosPerfil . $foto);
                header('Location: ../gerenciarUsuarios.php?Item=Criado');
            }
            else echo "<script>window.alert('CPF ou email já cadastrado(s). Contate o administrador!');window.history.back();</script>";

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>