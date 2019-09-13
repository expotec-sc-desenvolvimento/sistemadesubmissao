<?php
    include dirname(__FILE__) . '/inc/includes.php';
    

//    date_default_timezone_set('America/Sao_Paulo');
  
    
    
    
    session_start();

    if (isset($_GET['id'])) {
        
        $_SESSION['usuario'] = UsuarioPedrina::retornaDadosUsuario($_GET['id']);
        header('Location: paginaInicial.php');
    }
    else echo "erro";
    
    
?>