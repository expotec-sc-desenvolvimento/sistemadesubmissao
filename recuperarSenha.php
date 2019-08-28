<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, Sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Recuperar Senha</title>
        
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
    </head>
    
    <body>
        <?php
            include 'inc/mensagensGET.php';
        ?>

       
            <h2>Recuperação de Senha</h2>
            
            <form method="post" action="<?=htmlspecialchars('submissaoForms/wsRecuperarSenha.php');?>">
                <br>
                <table>
                    <tr>
                        <td class='direita'><label for="inpCpf">CPF: </label></td>
                        <td><input class="input" type="text" id="inpCpf" name="pCpf" maxlength="14" 
                                       OnKeyPress="formatar('###.###.###-##', this);return event.charCode >= 48 && event.charCode <= 57" 
                                       placeholder="Ex.: 000.000.000-00" autofocus onblur="cpfValido(this)"> </td>
                        <td><div id="msgCPF" class="msgerr"></div></td>
                    </tr>
                    <tr>
                        <td class='direita'><label for="inpEmail">E-mail:</label></td>
                        <td><input class="input" type="email" id="inpEmail" name="pEmail" onblur="emailValido(this)"></td>
                        <td><div id="msgemail" class="msgerr"></div></td>
                    </tr>
                </table>
                
                    
                    <input class="botaoConfirmar" type="submit" value="Recuperar Senha" onclick="return validarDados(['inpCpf','inpEmail'])">
                
            </form>
            
            <ol>
                <li>
                    <a href="index.php" title="Login">Fazer Login</a>
                </li>
                <li>
                    <a href="cadastrarUsuario.php" title="Cadastre-se">Cadastre-se</a>
                </li>
            </ol>                
     
        <?php
        require_once './inc/footer.php';
        ?>
    </body>
        
</html>