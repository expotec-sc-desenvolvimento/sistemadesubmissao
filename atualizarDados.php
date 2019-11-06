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
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, Sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Atualizar Dados</title>

        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
        
    </head>
    
    <body>
        <?php require_once 'inc/menuInicial.php';?>
        
     <fieldset>
            
            
            <h3 align='center'>Atualização de Dados</h3>
            
            <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAtualizarDados.php');?>">
                
                <table class="cadastroItens">
                    <tr>
                        <td class='direita'><label for="cpf">CPF*: </label></td>
                        <td><input class="readOnly" id="cpf" name="cpf" readonly="true" value="<?php echo $usuario->getCpf() ?>"></td>
                    </tr>
                    <tr>
                        <td class='direita'><label for="nome">Nome*: </label></td>
                        <td><input type="text" id="nome" name="nome" value= "<?php echo $usuario->getNome() ?>" required="true"></td>
                    </tr>
                    <tr>
                        <td class='direita'><label for="sobrenome">Sobrenome*: </label></td>
                        <td><input type="text" id="sobrenome" name="sobrenome" value= "<?php echo $usuario->getSobrenome() ?>" required="true"></td>
                    </tr>
                    <tr>
                        <td class='direita'><label for="dataNascimento">Data de Nascimento*: </label></td>
                        <td><input class="input" type="date" id="dataNascimento" name="dataNascimento" value="<?php echo $usuario->getDataNascimento() ?>" required="true"></td>
                    </tr>
                    <tr>
                        <td class='direita'><label for="email">E-mail*: </label></td>
                        <td><input class="input" type="email" id="email" name="email" value="<?php echo $usuario->getEmail()?>" required="true"></td>
                    </tr>
                    <tr>
                        <td class='direita'><label for="tipoUsuario">Tipo de Usuário: </label></td>
                        <td><input class="input" type="text" id="tipoUsuario"  name="tipoUsuario" readonly="true" value="<?php echo TipoUsuario::retornaDadosTipoUsuario($usuario->getIdTipoUsuario())->getDescricao()?>"></td>
                    </tr>                    
                </table>
                <input type="hidden" id="inpPerfil" name="perfil" value="<?php echo $usuario->getIdPerfil()?>">
                <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $usuario->getId()?>">
                <input type="hidden" id="itTipoUsuario" name="idTipoUsuario" value="<?php echo $usuario->getIdTipoUsuario()?>">
                
                <br>
                <p align="center">
                    <input class="botaoConfirmar" type="submit" value="Atualizar Dados"
                    <input class="botaoConfirmar" type="button" value="Retornar ao Início" onclick="window.history.back()"></p>
           <br>
                
            </form>
            
        </fieldset>
                    
    </body>
</html>>