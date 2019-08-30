<?php
    
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    $area = Area::retornaDadosArea($_GET['id']);
?>

<div class="titulo-modal">Editar Área</div>

<div class="itens-modal">
    

<form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarArea.php');?>" enctype="multipart/form-data">
    <input type="hidden" name="pIdArea" value="<?php echo $area->getId() ?>">
    <table class="cadastroItens-2" align="center">
        <tr>
            <td class='direita'><label for="inpArea">Area: </label></td>
                <td><input class="campoDeEntrada" rows="10" cols="40" id="inpArea" name="pArea" value="<?php echo $area->getDescricao() ?>" required="true"></td>
                <td><div id="msgArea" class="msgerr"></div></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpSubAreas">Subareas: </label></td>
                <td><input class="campoDeEntrada" class="input" id="inpSubAreas" name="pSubAreas" value="<?php echo $area->getSubAreas() ?>" required="true"></td>
                <td><div id="msgSubAreas" class="msgerr"></div></td>
            </tr>
    </table>
    <div class="div-btn"><input class="btn-verde" type="submit" value="Atualizar Area"></div>
</form>


</div>