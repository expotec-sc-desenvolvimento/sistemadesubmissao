<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
?>

<div class="titulo-modal">Adicionar Área</div>

<div class="itens-modal">

    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddArea.php');?>" enctype="multipart/form-data">

        <table class="cadastroItens-2" align="center">
            <tr>
                <td class='direita'><label for="descricao">Descrição: </label></td>
                <td><input class="campoDeEntrada" id="descricao" name="descricao" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="subareas">SubAreas: </label></td>
                <td><input class="campoDeEntrada" id="subareas" name="subareas" required="true"></td>
            </tr>
        </table>
        
        <div class="div-btn"><input class="btn-verde" type="submit" value="Adicionar Area"></div>
    </form>
    
</div>