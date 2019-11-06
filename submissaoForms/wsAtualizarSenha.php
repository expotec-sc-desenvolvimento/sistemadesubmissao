<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    $p = filter_input_array(INPUT_POST);    

    $senhaAntiga = md5($p['pSenhaAntiga']);
    $senhaNova = md5($p['pSenha']);

    if ($usuario->alterarSenha($usuario->getId(), $senhaAntiga, $senhaNova)) header('Location: ../paginaInicial.php?Item=Atualizado');
    else header('Location: ../atualizarSenha.php?Senha=incorreta');
    

?>