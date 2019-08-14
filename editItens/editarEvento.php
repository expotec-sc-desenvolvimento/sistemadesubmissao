<?php
    include dirname(__DIR__) . '../inc/includes.php';
    
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
                <td class='direita'><label for="mediaAprovacaoTrabalhos">Média: </label></td>
                <td>
                    <select class="campoDeEntrada" id="mediaAprovacaoTrabalhos" name="mediaAprovacaoTrabalhos" required="true">
                        <option value="">Selecione um valor</option>
                        <option value="60" <?php if ($evento->getMediaAprovacaoTrabalhos()==60) echo " selected"?>>60</option>
                        <option value="70" <?php if ($evento->getMediaAprovacaoTrabalhos()==70) echo " selected"?>>70</option>
                        <option value="80" <?php if ($evento->getMediaAprovacaoTrabalhos()==80) echo " selected"?>>80</option>
                    </select>

                </td>
            </tr>

            <tr>
                <td class='direita'><label for="inpImagem">Logo: </label></td>
                <td><input class="campoDeEntrada" type="file" id="inpImagem" name="pImagem"></td>
            </tr>

        </table>
        <div class="div-btn"><input class="btn-verde" type="submit" value="Atualizar Evento"></div>
        
    </form>
    
    </div>
