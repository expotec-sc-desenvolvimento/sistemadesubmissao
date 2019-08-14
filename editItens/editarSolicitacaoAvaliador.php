<?php

    include dirname(__DIR__) . '../inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $solicitacao = SolicitacaoAvaliador::retornaDadosSolicitacoesAvaliador($_GET['id']);
    
    if ($solicitacao->getId()=="") header('Location: ./paginaInicial.php');

    $user = Usuario::retornaDadosUsuario($solicitacao->getIdUsuario());
    
    $eventoDaSolicitacao = Evento::retornaDadosEvento($solicitacao->getIdEvento());
    $areaDaSolicitacao = Area::retornaDadosArea($solicitacao->getIdArea());
?>

<div class="titulo-modal">Avaliar Solicitação</div>

<div class="itens-modal">
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarSolicitacaoAvaliador.php');?>">
        <input type='hidden' id='idSolicitacao' name='idSolicitacao' value='<?php echo $solicitacao->getId()?>'>
        <input type='hidden' id='idUsuario' name='idUsuario' value='<?php echo $user->getId()?>'>
        <input type='hidden' id='idEvento' name='idEvento' value='<?php echo $eventoDaSolicitacao->getId()?>'>
        <input type='hidden' id='idArea' name='idArea' value='<?php echo $areaDaSolicitacao->getId()?>'>
        
        <table class="cadastroItens-2">
            <tr><td><strong>Evento: </strong></td><td><?php echo $eventoDaSolicitacao->getNome()?></td></tr>
            <tr><td><strong>Área:</strong></td><td><?php echo $areaDaSolicitacao->getDescricao()?></td></tr>
            <tr>
                <td><strong>Avaliação:</strong></td>
                <td><select class="campoDeEntrada" id="select-Situacao" name="select-Situacao" required="true">
                            <option value="">Selecione uma situação</option>
                            <option value="Deferida">Deferida</option>
                            <option value="Indeferida">Indeferida</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><strong>Observação:</strong></td>
                <td><textarea class="campoDeEntrada" id="observacao" name="observacao" style="width: 393px; height: 80px; resize: none;"></textarea></td>
            </tr>

        </table>
        <div class="div-btn"><input class="btn-verde" type="submit" value="Avaliar Solicitação"></div>
    </form>
</div>