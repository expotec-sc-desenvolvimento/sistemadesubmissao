<?php

include dirname(__DIR__) . '/inc/includes.php';

//session_start();

$metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

date_default_timezone_set('America/Sao_Paulo');

if ($metodoHttp === 'POST') {
    try {
        $p = filter_input_array(INPUT_POST);    

        $cpf = $p['cpf'];
        $nome = $p['nome'];
        $sobrenome = $p['sobrenome'];
        $senha = md5($p['senha']);
        $dataNascimento = $p['dataNascimento'];
        $email = $p['email'];
        $tipoUsuario = $p['tipoUsuario'];
        $perfil = 2;
        
        $caracteresCPF = array(".", "-");
        $foto = str_replace($caracteresCPF,"",$cpf) . ".jpg";

        if (Usuario::adicionarUsuario($perfil,$cpf,$nome,$sobrenome,$senha,$dataNascimento,$email,$tipoUsuario,$foto)) {
            copy('./../' . $pastaFotosPerfil . "semFoto.jpg", './../' . $pastaFotosPerfil . $foto);
            header('Location: ../index.php?Item=Criado');
        }
        else echo "<script>window.alert('CPF ou email já cadastrado(s). Contate o administrador!');window.history.back();</script>";

        
    } catch (Exception $e) {
        $e->getMessage();
    }

} else {
    //$_SESSION['msg'] = "Você deve fazer login no sistema";
    header('Location: ../index.php');
}