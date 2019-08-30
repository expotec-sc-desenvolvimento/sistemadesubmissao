<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $criterio = Criterio::retornaDadosCriterio($_GET['id']);
    if ($criterio->getId()=="") header('Location: paginaInicial.php');
    
    $pendencias = '';
    $readonly = '';
    $disable = '';
    $flag=false;
    
    foreach (Submissao::listaSubmissoesComFiltro('', $criterio->getIdModalidade(), '', '', $criterio->getIdTipoSubmissao()) as $submissao) {
        foreach (Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), '') as $avaliacao) {
            // Situações da avaliação: 2-Finalizada, 4-Aprovado, 5-Aprovado com ressalvas, 6-Reprovado
            if (in_array($avaliacao->getIdSituacaoAvaliacao(), array(2,4,5,6))) {
                $pendencias = "<p align='center'><strong>Já existem avaliações realizadas. Não é possível alterar os dados dos critérios</strong></p>";
                $readonly = " readonly='true' ";
                $disable = " disabled='true' ";
                $flag=true;
                break;
            }
            if ($flag) break;
        }
    }
    
?>

<div class="titulo-modal">Editar Critério</div>


<div class="itens-modal">
    
    
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarCriterio.php');?>" enctype="multipart/form-data">
                
        <input type="hidden" name="pIdCriterio" value="<?php echo $criterio->getId() ?>">
        <?php echo $pendencias ?>
        
        <table class="cadastroItens-2">
            <tr><td><strong>Modalidade:</td><td><?php echo Modalidade::retornaDadosModalidade($criterio->getIdModalidade())->getDescricao()?></td></tr>
            <tr><td><strong>Tipo de Critério:</strong></td><td><?php echo TipoSubmissao::retornaDadosTipoSubmissao($criterio->getIdTipoSubmissao())->getDescricao()?></td></tr>
            <tr>
                <td class='direita'><strong>Descrição:</strong></td>
                <td><input class="campoDeEntrada" id="inpDescricao" name="pDescricao" required="true" value="<?php echo $criterio->getDescricao()?>" <?php echo $readonly; ?>></td>
                <td><div id="msgDescricao" class="msgerr"></div></td>
            </tr>
            <tr>
                <td class='direita'><strong>Detalhamento: </strong></td>
                <td><textarea class="campoDeEntrada" id="inpDescricao" name="pDetalhamento" cols="60" rows="5" required="true" style="resize: none;" <?php echo $readonly; ?>><?php echo $criterio->getDetalhamento()?></textarea></td>
                <td><div id="msgDescricao" class="msgerr"></div></td>
            </tr>
            <tr>
                <?php if ($criterio->getIdTipoSubmissao()==3) {?>
                <td class='direita'><strong>Peso: </strong></td>
                <td><select class="campoDeEntrada" id='inpPeso' name="pPeso" <?php echo $disable ?>>
                        <option value="1" <?php if ($criterio->getPeso()==1) echo " selected"?>>1</option>
                        <option value="2" <?php if ($criterio->getPeso()==2) echo " selected"?>>2</option>
                        <option value="3" <?php if ($criterio->getPeso()==3) echo " selected"?>>3</option>
                        <option value="4" <?php if ($criterio->getPeso()==4) echo " selected"?>>4</option>
                        <option value="5" <?php if ($criterio->getPeso()==5) echo " selected"?>>5</option>
                    </select></td>
                <?php } else echo "<input type='hidden' id='inpPeso' name='pPeso' value=''>;"?>
            </tr>

        </table>
        
        <?php if (!$flag) { ?><div class="div-btn"><input class="btn-verde" type="submit" value="Atualizar Criterio"></div> <?php } ?>

    </form>
    
    </div>



    

    