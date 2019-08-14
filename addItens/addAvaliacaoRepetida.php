<?php

    include dirname(__DIR__) . '../inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $submissao = new Submissao();
    $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
    
    
?>

<div class="titulo-modal">Repertir Avaliadores da Versão Inicial</div>

<div class="itens-modal">
    <?php echo $submissao->getId() ?>
</div>