<?php
    //include dirname(__FILE__)
    include dirname(__DIR__) . './inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    $prazoEvento = PrazosEvento::retornaDadosPrazosEvento($_GET['id']);
?>

<div class="titulo-modal">Editar Prazo - Evento <?php echo Evento::retornaDadosEvento($prazoEvento->getIdEvento())->getNome()?></div>

<div class="itens-modal">
    

<form method="post" action="<?=htmlspecialchars('submissaoForms/wsAtualizarPrazoEvento.php');?>" enctype="multipart/form-data">
    <input type="hidden" name="idPrazo" value="<?php echo $prazoEvento->getId() ?>">
    <input type="hidden" name="idEvento" value="<?php echo $prazoEvento->getIdEvento() ?>">
    <input type="hidden" name="idTipoPrazo" value="<?php echo $prazoEvento->getIdTipoPrazo() ?>">
    <table class="cadastroItens-2" align="center">
        <tr>
            <th class='direita'><label for="tipoPrazo">Tipo de Prazo: </label></th>
            <td><input class="campoDeEntrada" id="tipoPrazo" name="tipoPrazo" value="<?php echo TipoPrazo::retornaDadosTipoPrazo($prazoEvento->getIdTipoPrazo())->getDescricao() ?>" readonly="true"></td>

        </tr>
        <tr>
            <th class='direita'><label for="dias">Prazo (em dias): </label></th>
            <td><input class="campoDeEntrada" id="dias" name="dias" value="<?php echo $prazoEvento->getDias() ?>" required="true"></td>
        </tr>
    </table>
    <div class="div-btn"><input class="btn-verde" type="submit" value="Atualizar Prazo"></div>
</form>


</div>