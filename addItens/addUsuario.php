<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
?>

<div class="titulo-modal">Adicionar Usuário</div>


<div class="itens-modal">
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddUsuario.php');?>">
        
        <table class="cadastroItens-2">
            <tr>
                <td class='direita'><label for="cpf">CPF: </label></td>
                <td><input class="campoDeEntrada" id="cpf" name="cpf" minlength="14" maxlength="14" OnKeyPress="formatar('###.###.###-##', this);return event.charCode >= 48 && event.charCode <= 57" placeholder="Ex.: 000.000.000-00" onblur="cpfValido(this)" autofocus></td>
            </tr>
            <tr>
                <td class='direita'><label for="nome">Nome: </label></td>
                <td><input class="campoDeEntrada" id="nome" name="nome" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="sobrenome">Sobrenome: </label></td>
                <td><input class="campoDeEntrada" type="text" id="sobrenome" name="sobrenome" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="dataNascimento">Data de Nascimento: </label></td>
                <td><input class="campoDeEntrada" type="date" id="dataNascimento" name="dataNascimento" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="email">E-mail: </label></td>
                <td><input class="campoDeEntrada" type="email" id="email" name="email" required="true"></td>
            </tr>
            <tr>
            <td class="direita"><label for="tipoUsuario">Tipo de Usuário: </label></td>
                <td>
                    <select id="tipoUsuario" name="tipoUsuario" class='campoDeEntrada' required>
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
                <td class='direita'><label for="perfil">Perfil: </label></td>
                <td><select name="perfil" id="perfil" class="campoDeEntrada">
                        <?php
                            foreach (Perfil::listaPerfis() as $perfil) {

                                $option = "<option value='" . $perfil->getId() . "' ";
                                if ($perfil->getDescricao() == "Participante") $option = $option . " selected";
                                $option = $option . ">" . $perfil->getDescricao() . "</option>";
                                echo $option;
                            }
                        ?>
                  </select></td>
                <td></td>
            </tr>
        </table>
        <p align="center"><input class="botaoConfirmar" type="submit" value="Adicionar Usuário"></p>

    </form>
    
    </div>
