<?php
    include dirname(__DIR__) . '/inc/includes.php';
    

//    date_default_timezone_set('America/Sao_Paulo');
    
    
    session_start();

    
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    $p = filter_input_array(INPUT_POST);    

    $cpf = $p['pCpf'];
    $senha = md5($p['pSenha']);

    $user = Usuario::login($cpf, $senha);
    
    if ($user != null) {

        $_SESSION['usuario'] = $user;
        header('Location: ../paginaInicial.php');
    }
    
    else {
        header('Location: ../index.php?User=loginInvalido');
    }
    
?>