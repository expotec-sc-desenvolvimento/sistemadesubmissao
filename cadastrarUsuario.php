<?php
    include dirname(__FILE__) . './inc/includes.php';
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, Sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema de Submissão - IFRN</title>
        
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>
        
    </head>
     
    <body>
            <h2>Tela de Cadastro</h2>
            
            <form method="post" action="<?=htmlspecialchars('submissaoForms/wsCadastrarUsuario.php');?>">
                
                <table class="tabCadastro">
                    <tr>
                        <td><label for="cpf">CPF*: </label></td>
                        <td><input class="input" id="cpf" name="cpf" minlength="14" maxlength="14" OnKeyPress="formatar('###.###.###-##', this);return event.charCode >= 48 && event.charCode <= 57" placeholder="Ex.: 000.000.000-00" autofocus required="true"></td>
                    </tr>
                    <tr>
                        <td><label for="nome">Nome*: </label></td>
                        <td><input class="input" type="text" id="nome" name="nome"  required="true"></td>
                    </tr>
                    <tr>
                        <td><label for="sobrenome">Sobrenome*: </label></td>
                        <td><input class="input" type="text" id="sobrenome" name="sobrenome" required="true"></td>
                    </tr>
                    <tr>
                        <td><label for="dataNascimento">Data de Nascimento*: </label></td>
                        <td><input class="input" type="date" id="dataNascimento" name="dataNascimento" required="true"></td>
                    </tr>
                    <tr>
                        <td><label for="email">E-mail*: </label></td>
                        <td><input class="input" type="email" id="email" name="email" required="true"></td>
                    </tr>
                    <tr>
                        <td><label for="tipoUsuario">Tipo de Usuário: </label></td>
                        <td>
                            <select id="tipoUsuario" name="tipoUsuario" required>
                            <?php
                                foreach (TipoUsuario::listaTipoUsuarios() as $tipoUsuario) {
                                    echo "<option value='".$tipoUsuario->getId()."'";
                                    if ($tipoUsuario->getDescricao()=="Visitante/Externo") echo " selected";
                                    echo ">".$tipoUsuario->getDescricao()."</option>";
                            }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="senha">Senha*: </label></td>
                        <td><input class="input" type="password" id="senha" name="senha" minlength="5" required="true"></td>
                    </tr>
                    <tr>
                        <td><label for="CSenha">Confirme a senha*: </label></td>
                        <td><input class="input" type="password" id="CSenha" name="CSenha"></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <input class="botaoConfirmar" type="submit" value="Criar Usuário" 
                                   onclick="if (document.getElementById('senha').value != document.getElementById('CSenha').value) {alert('Senhas não coincidem'); return false;}"> 
                        </td>
                    </tr>
                </table>
                <br>    
            </form>
            <ol>
                <li>
                    <a href="index.php" title="Cadastre-se">Entrar no Sistema</a>
                </li>
                <li>
                    <a href="recuperarSenha.php" title="Esqueceu a senha?">Esqueceu a senha?</a>
                </li>
            </ol> 
            
                    
    </body>
        
</html>