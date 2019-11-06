<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
        
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Página Inicial</title>
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
        <script>
            $(document).on('click', '.img-perfil', function(){
                $('#inpImagem').click();
            });
            $(document).on('change', '#inpImagem', function(){
                $('#botaoConfirmar').click();
            });
        </script>
    </head>
    
    <body>
        <?php include dirname(__FILE__) . '/inc/pInicial.php'; ?>
            
        <?php include dirname(__FILE__) . '/inc/pFinal.php'; ?>
    </body>
</html>

