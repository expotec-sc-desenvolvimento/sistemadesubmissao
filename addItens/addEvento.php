<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
        
?>

<div class="titulo-modal">Adicionar Evento</div>


<div class="itens-modal">
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddEvento.php');?>" enctype="multipart/form-data">
        
        <table class="cadastroItens-2">
            <tr>
                <td class='direita'><label for="inpNomeEvento">Nome do Evento: </label></td>
                <td><input class="campoDeEntrada" id="inpNomeEvento" name="pNomeEvento" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpDescricaoEvento">Descrição: </label></td>
                <td><textarea class="campoDeEntrada" rows="10" cols="40" id="inpDescricaoEvento" name="pDescricaoEvento" required="true"></textarea></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpInicioSubmissao">Início da Submissão: </label></td>
                <td><input class="campoDeEntrada" type="date" id="inpInicioSubmissao" name="pInicioSubmissao" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpFimSubmissao">Fim da Submissão: </label></td>
                <td><input class="campoDeEntrada" type="date" id="inpFimSubmissao" name="pFimSubmissao" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="prazoFinalEnvioAvaliacaoParcial">Avaliações Parciais: </label></td>
                <td><input class="campoDeEntrada" type="date" id="prazoFinalEnvioAvaliacaoParcial" name="prazoFinalEnvioAvaliacaoParcial" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="prazoFinalEnvioSubmissaoCorrigida">Submissões Corrigidas: </label></td>
                <td><input class="campoDeEntrada" type="date" id="prazoFinalEnvioSubmissaoCorrigida" name="prazoFinalEnvioSubmissaoCorrigida" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="prazoFinalEnvioAvaliacaoCorrigida">Avaliações Corrigidas: </label></td>
                <td><input class="campoDeEntrada" type="date" id="prazoFinalEnvioAvaliacaoCorrigida" name="prazoFinalEnvioAvaliacaoCorrigida" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="prazoFinalEnvioAvaliacaoFinal">Avaliações Finais: </label></td>
                <td><input class="campoDeEntrada" type="date" id="prazoFinalEnvioAvaliacaoFinal" name="prazoFinalEnvioAvaliacaoFinal" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpImagem">Logo: </label></td>
                <td><input class="campoDeEntrada" type="file" id="inpImagem" name="pImagem" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="distribuicaoAutomaticaAvaliadores">Distruibuição <br>automática: </label></td>
                <td>
                    <select class='campoDeEntrada' id='distribuicaoAutomaticaAvaliadores' name='distribuicaoAutomaticaAvaliadores' onchange="if (this.value==1) alert('Ao ativar essa opção, os trabalhos submetidos a partir de agora serão distribuidos automaticamente!')">
                        <option value='1'>Ativado</option>
                        <option value='0' selected>Desativado</option>
                    </select>
                </td>
            </tr>
        </table>
        <div class="div-btn"><input class="btn-verde" type="submit" value="Adicionar Evento"></div>
        
    </form>
    
    </div>
