<?php
    include dirname(__DIR__) . '../inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $modalidade = Modalidade::retornaDadosModalidade($_GET['idModalidade']);
    if ($modalidade->getId()=="") header('Location: ./gerenciarModalidades.php');
    
    $tipoCriterio = TipoSubmissao::retornaDadosTipoSubmissao($_GET['idTipo']);
    if ($tipoCriterio->getId()=="") header('Location: ./gerenciarModalidades.php');
    
    $submissoesDaModalidade = Submissao::listaSubmissoesComFiltro('', $modalidade->getId(), '', '', $tipoCriterio->getId());
    $avaliacoesRealizadas = array();
    
    foreach ($submissoesDaModalidade as $submissao) {
        // Testa se já existem avaliações realizadas para esta modalidade/tiposubmissao
        if (count(Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), 2))) array_push ($avaliacoesRealizadas, $submissao);
    }
    
?>

<div class="titulo-modal">Adicionar Critério</div>


<div class="itens-modal">
    
    <?php
    
    if (count($avaliacoesRealizadas)>0) {
        echo "<p align='center'>Não é possível adicionar Critério <strong>".$tipoCriterio->getDescricao()."</strong>"
                . " para esta Modalidade, pois existem avaliações já realizadas!</p>";
    }
    
    else {?>
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddCriterio.php');?>" enctype="multipart/form-data">
                
        <input type="hidden" name="pIdModalidade" value="<?php echo $modalidade->getId() ?>">
        <input type="hidden" name="pTipoCriterio" value="<?php echo $tipoCriterio->getId() ?>">
        
        <table class="cadastroItens">
            <tr><td><strong>Modalidade:</td><td><?php echo $modalidade->getDescricao()?></td></tr>
            <tr><td><strong>Tipo de Critério:</strong></td><td><?php echo $tipoCriterio->getDescricao()?></td></tr>
            <tr>
                <td class='direita'><strong>Descrição:</strong></td>
                <td><input class="campoDeEntrada" id="inpDescricao" name="pDescricao" required="true"></td>
                <td><div id="msgDescricao" class="msgerr"></div></td>
            </tr>
            <tr>
                <td class='direita'><strong>Detalhamento: </strong></td>
                <td><textarea class="campoDeEntrada" id="inpDescricao" name="pDetalhamento" cols="60" rows="5" required="true" style="resize: none;"></textarea></td>
                <td><div id="msgDescricao" class="msgerr"></div></td>
            </tr>
            <tr>
                <?php if ($tipoCriterio->getDescricao()=="Final") {?>
                <td class='direita'><strong>Peso: </strong></td>
                <td><select class="campoDeEntrada" id='inpPeso' name="pPeso">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </td>
                <?php } else echo "<input type='hidden' id='inpPeso' name='pPeso' value=''>;"?>
            </tr>

        </table>
        <div class="div-btn"><input class="btn-verde" type="submit" value="Adicionar Criterio"></div>
        
    </form>
    <?php }?>
    
    </div>    