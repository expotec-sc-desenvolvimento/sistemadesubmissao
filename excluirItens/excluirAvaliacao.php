<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página

    $avaliacao = new Avaliacao();
    $avaliacao = Avaliacao::retornaDadosAvaliacao($_GET['id']);
    
    $nomeAvaliador = UsuarioPedrina::retornaDadosUsuario($avaliacao->getIdUsuario())->getNome();

?>

<div class="titulo-modal">Excluir Avaliador da Submissão</div>

<div class="itens-modal">
        
    <p align='center'>Tem certeza que deseja excluir o avaliador <strong><?php echo $nomeAvaliador?></strong> desta Submissão?</p>
    <div class="div-btn">
        <input type='button' value='Sim' class='btn-verde' onclick="location.href='submissaoForms/wsExcluirAvaliadorSubmissao.php?id=<?php echo $_GET['id']?>'">
        <input type='button' value='Não' class='btn-vermelho' onclick="$('#modal').fadeOut(500)">
    </div>
        
</div>