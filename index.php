<?php
    
    session_start();
    
    if (isset( $_SESSION['usuario'] )) header('Location: /expotecsc/cpanel');
        else {echo "<h3 align='center'>A sessão foi encerrada. Faça login novamente no sistema para ter acesso a todas as páginas!</h3>"; exit(1);}
    //else {header('Location: /expotecsc/security/logout');};
?>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, Sistema">
        <meta name="description" content="Página inicial do Sistema de Sumissão - IFRN">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema de Submissão - IFRN</title>
        <link rel="icon" href="img/logo250.png">

        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>

    </head>
    
    <body>
        <?php
            include 'inc/mensagensGET.php';
        ?>

        
            <h2>Login</h2>
            <form method="post" action="<?=htmlspecialchars('submissaoForms/wsValidarLogin.php');?>">
                
                    <table>
                        <tr>
                            <td><label for="inpCpf">CPF: </label></td>
                            <td><input class="input" type="text" id="inpCpf" name="pCpf" maxlength="14" 
                                       OnKeyPress="formatar('###.###.###-##', this);return event.charCode >= 48 && event.charCode <= 57" 
                                       placeholder="Ex.: 000.000.000-00" autofocus></td>
                            <td><div id="msgCPF" class="msgerr"></div></td>
                        </tr>
                        <tr>
                            <td><label for="inpSenha">Senha: </label></td>
                            <td><input class="input" type="password" id="inpSenha" name="pSenha"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center"><input class="botaoConfirmar" type="submit" value="Acessar" onclick="return validarDados(['inpCpf'])"></td>
                        </tr>
                    </table>

            </form>
          
                <ol>
                    <li>
                        <a href="cadastrarUsuario.php" title="Cadastre-se">Cadastre-se</a>
                    </li>
                    <li>
                        <a href="recuperarSenha.php" title="Esqueceu a senha?">Esqueceu a senha?</a>
                    </li>
                </ol>                
    </body>
        
</html>
