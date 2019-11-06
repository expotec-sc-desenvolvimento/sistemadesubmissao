<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
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

<div class="panel-heading">
    <h3 class="panel-title">Editar Critério</h3>
</div>

<div class="panel-body">
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarCriterio.php');?>" enctype="multipart/form-data">
        <input type="hidden" name="pIdCriterio" value="<?php echo $criterio->getId() ?>">
        <?php echo $pendencias ?>
    <div class="row">
        <div class="col-md-6 mb-6">
            <label class="control-label">Modalidade</label>
            <input class="form-control" readonly="true" value="<?php echo Modalidade::retornaDadosModalidade($criterio->getIdModalidade())->getDescricao() ?>">
            <div class="help-inline ">

            </div>
        </div>
        <div class="col-md-6 mb-6">
            <label class="control-label">Tipo de Avaliação</label>
            <input class="form-control" readonly="true" value="<?php echo TipoSubmissao::retornaDadosTipoSubmissao($criterio->getIdTipoSubmissao())->getDescricao() ?>">
            <div class="help-inline ">

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12  mb-4">
            <label for="e.address">Descrição</label> 
                <input class="form-control" id="inpDescricao" name="pDescricao" required="true" value="<?php echo $criterio->getDescricao()?>" <?php echo $readonly; ?>>
            <div class="help-inline ">

            </div>
        </div>	
    </div>
    <div class="row">
        <div class="col-md-12  mb-4">
            <label for="resumo">Detalhamento</label> 
            <textarea class="form-control" id="inpDescricao" name="pDetalhamento" rows="6"   style="resize:none" required="true" <?php echo $readonly; ?>><?php echo $criterio->getDetalhamento()?></textarea>
            <div class="help-inline ">

            </div>
        </div>	
    </div>
    <?php if (($criterio->getIdTipoSubmissao()==3)) {?>
    <div class="row">
        <div class="col-md-12  mb-4">
            <label for="resumo">Peso</label> 
                <select class="form-control" id='inpPeso' name="pPeso" <?php echo $disable ?>>
                    <option value="1" <?php if ($criterio->getPeso()==1) echo " selected"?>>1</option>
                    <option value="2" <?php if ($criterio->getPeso()==2) echo " selected"?>>2</option>
                    <option value="3" <?php if ($criterio->getPeso()==3) echo " selected"?>>3</option>
                    <option value="4" <?php if ($criterio->getPeso()==4) echo " selected"?>>4</option>
                    <option value="5" <?php if ($criterio->getPeso()==5) echo " selected"?>>5</option>
                </select>
            <div class="help-inline ">

            </div>
        </div>	
    </div>
    <?php } else echo "<input type='hidden' id='inpPeso' name='pPeso' value=''>;" ?>


    <?php if (!$flag) { ?>    
    <div class="control-group form-actions">
        <div class="row">
            <div class="col-md-3 mb-4">
            <button class="btn btn-lg btn-primary btn-block mb-15" type="submit">Atualizar</button>
            </div>

            <div class="col-md-3 mb-4">
                <a class="btn btn-lg btn-default  btn-block" onclick="$('#modal').fadeOut(500)">Retornar</a>
            </div>
        </div>
    </div>
    <?php } ?>
    </form>
</div>    
