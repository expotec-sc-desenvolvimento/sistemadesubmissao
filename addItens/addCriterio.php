<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
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
        if (count(Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), 2)) ||
                count(Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), 4)) ||
                count(Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), 5)) ||
                count(Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), 6))) array_push ($avaliacoesRealizadas, $submissao);
    }

?>


<?php if (count($avaliacoesRealizadas)>0) { ?>
    <p align='center'>Não é possível adicionar Critério <strong><?php echo $tipoCriterio->getDescricao() ?></strong> para esta Modalidade, pois existem avaliações já realizadas!</p>
<?php } else { ?>
    <div class="panel-heading">
        <h3 class="panel-title">Adicionar Critério</h3>
    </div>

    <div class="panel-body">
        <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddCriterio.php');?>" enctype="multipart/form-data">
            <input type="hidden" name="pIdModalidade" value="<?php echo $modalidade->getId() ?>">
            <input type="hidden" name="pTipoCriterio" value="<?php echo $tipoCriterio->getId() ?>">
        <div class="row">
            <div class="col-md-6 mb-6">
                <label class="control-label">Modalidade</label>
                <input class="form-control" readonly="true" value="<?php echo $modalidade->getDescricao() ?>">
                <div class="help-inline ">

                </div>
            </div>
            <div class="col-md-6 mb-6">
                <label class="control-label">Tipo de Avaliação</label>
                <input class="form-control" readonly="true" value="<?php echo $tipoCriterio->getDescricao() ?>">
                <div class="help-inline ">

                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Descrição</label> 
                    <input class="form-control" id="inpDescricao" name="pDescricao" required="true">
                <div class="help-inline ">

                </div>
            </div>	
        </div>
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="resumo">Detalhamento</label> 
                <textarea id="inpDescricao" name="pDetalhamento" rows="6" class="form-control"  style="resize:none" required="true"></textarea>
                <div class="help-inline ">

                </div>
            </div>	
        </div>
        <?php if ($tipoCriterio->getDescricao()=="Final") {?>
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="resumo">Peso</label> 
                    <select class="form-control" id='inpPeso' name="pPeso">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                <div class="help-inline ">

                </div>
            </div>	
        </div>
        <?php } ?>

        <div class="control-group form-actions">
            <div class="row">
                <div class="col-md-3 mb-4">
                <button class="btn btn-lg btn-primary btn-block mb-15" type="submit">Adicionar Critério</button>
                </div>

                <div class="col-md-3 mb-4">
                    <a class="btn btn-lg btn-default  btn-block" onclick="$('#modal').fadeOut(500)">Retornar</a>
                </div>
            </div>
        </div>
        </form>
    </div>

<?php } ?>