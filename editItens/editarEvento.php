<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $evento = new Evento();
    $evento = Evento::retornaDadosEvento($_GET['id']);
    
    
    if ($evento->getId()=="") header('Location: gerenciarEventos.php');
    
?>

<div class="titulo-modal">Editar Evento</div>


<div class="itens-modal">
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarEvento.php');?>" enctype="multipart/form-data">
                
        <input type="hidden" name="pIdEvento" value="<?php echo $evento->getId() ?>">
        
        <table class="cadastroItens-2">
            <tr>
                <td class='direita'><label for="inpNomeEvento">Nome do Evento: </label></td>
                <td><input class="campoDeEntrada" id="inpNomeEvento" name="pNomeEvento" value="<?php echo $evento->getNome() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpDescricao">Descrição: </label></td>
                <td><textarea class="campoDeEntrada" id="inpDescricaoEvento" name="pDescricaoEvento" required="true" cols="10" rows="4" style="resize: none;"><?php echo $evento->getDescricao()?></textarea></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpInicioSubmissao">Início da Submissão: </label></td>
                <td><input class="campoDeEntrada" type="date" id="inpInicioSubmissao" name="pInicioSubmissao" value="<?php echo $evento->getInicioSubmissao() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpFimSubmissao">Fim da Submissão: </label></td>
                <td><input class="campoDeEntrada" type="date" id="inpFimSubmissao" name="pFimSubmissao" value="<?php echo $evento->getFimSubmissao() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="prazoFinalEnvioAvaliacaoParcial">Avaliações Parciais: </label></td>
                <td><input class="campoDeEntrada" type="date" id="prazoFinalEnvioAvaliacaoParcial" name="prazoFinalEnvioAvaliacaoParcial" value="<?php echo $evento->getPrazoFinalEnvioAvaliacaoParcial() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="prazoFinalEnvioSubmissaoCorrigida">Submissões Corrigidas: </label></td>
                <td><input class="campoDeEntrada" type="date" id="prazoFinalEnvioSubmissaoCorrigida" name="prazoFinalEnvioSubmissaoCorrigida" value="<?php echo $evento->getPrazoFinalEnvioSubmissaoCorrigida() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="prazoFinalEnvioAvaliacaoCorrigida">Avaliações Corrigidas: </label></td>
                <td><input class="campoDeEntrada" type="date" id="prazoFinalEnvioAvaliacaoCorrigida" name="prazoFinalEnvioAvaliacaoCorrigida" value="<?php echo $evento->getPrazoFinalEnvioAvaliacaoCorrigida() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="prazoFinalEnvioAvaliacaoFinal">Avaliações Finais: </label></td>
                <td><input class="campoDeEntrada" type="date" id="prazoFinalEnvioAvaliacaoFinal" name="prazoFinalEnvioAvaliacaoFinal" value="<?php echo $evento->getPrazoFinalEnvioAvaliacaoFinal() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="prazoInscricaoAvaliadores">Inscrição de Avaliadores: </label></td>
                <td><input class="campoDeEntrada" type="date" id="prazoInscricaoAvaliadores" name="prazoInscricaoAvaliadores" value="<?php echo $evento->getPrazoInscricaoAvaliadores() ?>" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="distribuicaoAutomaticaAvaliadores">Distribuição Automática<br> de Avaliadores: </label></td>
                <td><select class='campoDeEntrada' id='distribuicaoAutomaticaAvaliadores' name='distribuicaoAutomaticaAvaliadores' onchange="if (this.value==1) alert('Ao ativar essa opção, os trabalhos submetidos a partir de agora serão distribuidos automaticamente!')">
                        <option value='1' <?php if ($evento->getDistribuicaoAutomaticaAvaliadores()=='1') echo " selected";?>>Ativado</option>
                        <option value='0' <?php if ($evento->getDistribuicaoAutomaticaAvaliadores()=='0') echo " selected";?>>Desativado</option>
                    </select></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpImagem">Logo: </label></td>
                <td><input class="campoDeEntrada" type="file" id="inpImagem" name="pImagem"></td>
            </tr>

        </table>
        <div class="div-btn"><input class="btn-verde" type="submit" value="Atualizar Evento"></div>
        
    </form>
    
    </div>
