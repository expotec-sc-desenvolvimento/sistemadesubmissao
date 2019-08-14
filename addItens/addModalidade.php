<?php
    include dirname(__DIR__) . '../inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
?>

<div class="titulo-modal">Adicionar Modalidade</div>

<div class="itens-modal">
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddModalidade.php');?>" enctype="multipart/form-data">

        <p align="center">Descrição: <input class="campoDeEntrada" id="descricao" name="descricao" required="true" ></p>
        <div class="div-btn"><input class="btn-verde" type="submit" value="Adicionar Modalidade"></div>
    </form>
</div>