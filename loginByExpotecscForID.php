<?php
    include dirname(__FILE__) . '/inc/includes.php';
    

//    date_default_timezone_set('America/Sao_Paulo');
  
    
    
    
    session_start();

    if (isset($_GET['id'])) {
//	   echo $_GET['id']; exit(1);
//	   echo "<script>alert('Calma lennedy');<script>";
 //     echo "dsdsds"; exit(1);
	    $_SESSION['usuario'] = UsuarioPedrina::retornaDadosUsuario($_GET['id']);
	   
        header('Location: paginaInicial.php');
    }
    else echo "erro";
    
    
?>
