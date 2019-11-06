<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    $user = new UsuarioPedrina();
    $user = $_SESSION['usuario'];
    
   
    unset($_SESSION['usuario']);
    session_destroy();
    
    header('Location: /expotecsc/logout');

?>
