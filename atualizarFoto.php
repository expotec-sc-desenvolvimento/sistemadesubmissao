<?php

    include dirname(__FILE__) . './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
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
        <title>SS - Atualizar Foto</title>

        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>
    </head>
    
    <body>
        
        <?php require_once 'inc/menuInicial.php';?>
        
        <fieldset id="principal">
            
            <br>
            
            <form  action="<?=htmlspecialchars('submissaoForms/wsValidarFoto.php');?>"
                  method="post" enctype="multipart/form-data">
                    
                    <h2 align="center">Realize o upload do Arquivo:</h2> <br>
                    <p align="center"><input type="file" id="inpImagem" name="pImagem"> </p>
                    <br>
                    <p align="center"><input class="botaoConfirmar" type="submit" value="Enviar"></p>
            </form>
        </fieldset>
        
    </body>
</html>

