<?php
    include dirname(__DIR__) . '../inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $usuarioEditar = new Usuario();
    $usuarioEditar = Usuario::retornaDadosUsuario($_GET['id']);

    
    $listaPerfis = Perfil::listaPerfis();
    
?>

<div class="titulo-modal">Editar Usuário</div>


<div class="itens-modal">
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarUsuario.php');?>">
                
        <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $_GET['id']?>">
        
        <table class="cadastroItens" border="1">
            <tr>
                <td colspan="3">
                    <img style="margin: 0 auto; margin-left: 30%; width: 100px" src="<?php echo $pastaFotosPerfil . $usuarioEditar->getImagem() ?>">
                    <p align='center'><input class="botaoConfirmar" type="button" value="Reiniciar Senha" onclick="reiniciarSenha('<?php echo $_GET['id'] ."','" . $usuarioEditar->getNome() ?>')"></p>
                </td>
            </tr>

            <tr>
                <td class='direita'><label for="cpf">CPF*: </label></td>
                <td><input class="input" id="cpf" name="cpf" minlength="14" maxlength="14" value= "<?php echo $usuarioEditar->getCpf() ?>" OnKeyPress="formatar('###.###.###-##', this);return event.charCode >= 48 && event.charCode <= 57" placeholder="Ex.: 000.000.000-00" required="true" autofocus></td>
            </tr>
            <tr>
                <td class='direita'><label for="nome">Nome*: </label></td>
                <td><input type="text" id="nome" name="nome" value= "<?php echo $usuarioEditar->getNome() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="sobrenome">Sobrenome*: </label></td>
                <td><input type="text" id="sobrenome" name="sobrenome" value= "<?php echo $usuarioEditar->getSobrenome() ?>" required="true"></td>
            </tr>

            <tr>
                <td class='direita'><label for="dataNascimento">Data de Nascimento*: </label></td>
                <td><input class="input" type="date" id="dataNascimento" name="dataNascimento" value="<?php echo $usuarioEditar->getDataNascimento() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="email">E-mail*: </label></td>
                <td><input class="input" type="email" id="email" name="email" value="<?php echo $usuarioEditar->getEmail() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="tipoUsuario">Tipo de Usuário: </label></td>
                <td>
                    <select id="tipoUsuario" name="tipoUsuario" required>
                    <?php
                        foreach (TipoUsuario::listaTipoUsuarios() as $tipoUsuario) {
                            echo "<option value='".$tipoUsuario->getId()."'";
                            if ($tipoUsuario->getId()==$usuarioEditar->getIdTipoUsuario()) echo " selected";
                            echo ">".$tipoUsuario->getDescricao()."</option>";
                    }
                    ?>
                    </select>
                </td>
            </tr>

            <tr>

                <td class='direita'><label for="perfil">Perfil: </label></td>
                <td><select name="perfil" id="perfil" <?php if ($_GET['id'] == $usuario->getId()) echo "disabled='true'" ?>>
                        <?php
                            foreach ($listaPerfis as $perfil) { 
                                $option = "<option value='" . $perfil->getId() . "' ";
                                if ($perfil->getId() == $usuarioEditar->getIdPerfil()) $option = $option . "selected";
                                $option = $option . ">" . $perfil->getDescricao() . "</option>";
                                echo $option;
                            }
                        ?>
                  </select>
                </td>
            </tr>
        </table>
        <p align="center"><input class="botaoConfirmar" type="submit" value="Atualizar Usuário"></p>
        <br>
    </form>
    
    </div>
