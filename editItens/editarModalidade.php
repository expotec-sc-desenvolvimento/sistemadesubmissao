<?php
    
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $modalidade = Modalidade::retornaDadosModalidade($_GET['id']);
    if ($modalidade->getId()=="") header('Location: ./gerenciarModalidades.php');
    
?>

<div class="titulo-modal">Editar Modalidade</div>

<div class="itens-modal">
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarModalidade.php');?>" enctype="multipart/form-data">
    <input type="hidden" name="pIdModalidade" value="<?php echo $modalidade->getId() ?>">
    
    <p align="center">Descrição: <input class="campoDeEntrada" rows="10" cols="40" id="inpModalidade" name="pNome" value="<?php echo $modalidade->getDescricao() ?>" required="true"></p>
    <div class="div-btn"><input class="btn-verde" type="submit" value="Atualizar Modalidade"></div>

    </form>
</div>
<br>