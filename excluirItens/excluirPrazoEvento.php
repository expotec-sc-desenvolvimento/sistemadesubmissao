<?php

    include dirname(__DIR__) . './inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página

    $prazoEvento = PrazosEvento::retornaDadosPrazosEvento($_GET['id']);

    
    $evento = Evento::retornaDadosEvento($prazoEvento->getIdEvento());
    $tipoPrazo = TipoPrazo::retornaDadosTipoPrazo($prazoEvento->getIdTipoPrazo());
     
      
?>

<div class="titulo-modal">Excluir Prazo</div>

<div class="itens-modal">
    
    <p align='center'>Deseja realmente excluir a o prazo de <strong><?php echo $tipoPrazo->getDescricao() ?></strong> do Evento 
        <strong><?php echo $evento->getNome() ?></strong>?</p>
    <div class="div-btn">
        <input type='button' value='Sim' class='addObjeto btn-verde' onclick="location.href='submissaoForms/wsExcluirPrazoEvento.php?id=<?php echo $_GET['id']?>'">
        <input type='button' value='Não' class='addObjeto btn-vermelho' onclick="$('#modal').fadeOut(500)">
    </div>
    
</div>