<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];


?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Atualizar Senha</title>
        
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
        
       
    </head>
    
    <body>
        
        <?php require_once 'inc/menuInicial.php';?>
        
        <fieldset id="principalSenha">
            
            <form  action="<?=htmlspecialchars('submissaoForms/wsAtualizarSenha.php');?>"
                  method="post" enctype="multipart/form-data">
                    
                    <h2 align='center'> Realize a troca Senha: </h2>
                    <table align = 'center' style="margin-left: 300px">
                        <tr>
                            <td class='direita'><label for="inpSenhaAntiga">Senha Antiga: </label></td>
                            <td><input class="input" id="inpSenhaAntiga" name="pSenhaAntiga" autofocus></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class='direita'><label for="inpSenha">Senha: </label></td>
                            <td><input class="input" type="password" id="inpSenha" name="pSenha" onblur="senhaValida(this)"></td>
                            <td><div id="msgsenha" class="msgerr"></div></td>
                        </tr>
                        <tr>
                            <td class='direita'><label for="inpCSenha">Confirme a senha: </label></td>
                            <td><input class="input" type="password" id="inpCSenha" name="pCSenha" onblur="confirmacaoSenhaValida(this)"></td>
                            <td><div id="confirmacao" class="msgerr"></div></td>
                        </tr>
                        <tr>
                            <td colspan="2" align='center'><input class="botaoConfirmar" type="submit" value="Trocar Senha" 
                                                                  onclick="return validarDados(['inpSenha','inpCSenha'])"></td>
                        </tr>
                    </table>
                    
            </form>
        </fieldset>
        
    </body>
</html>
