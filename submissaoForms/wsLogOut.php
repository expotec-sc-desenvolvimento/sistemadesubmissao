<?php

    require_once dirname(__FILE__). '/../inc/includes.php';
    
    session_start();
    $user = new Usuario;
    $user = $_SESSION['usuario'];
    
    
    unset($_SESSION['usuario']);
    unset($_SESSION['fotosUsuarios']);
    session_destroy();
    
    header('Location: ../index.php?logOut=Sucesso');

?>
