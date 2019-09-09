<?php
    //include dirname(__FILE__)
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    $avaliacao = Avaliacao::retornaDadosAvaliacao($_GET['id']);
    if ($avaliacao->getId()=="") header('Location: ./paginaInicial.php');
    
    if ($avaliacao->getIdUsuario()!=$usuario->getId()) header('Location: ./paginaInicial.php?User=permissaoNegada');
    
    
    
    $submissao = new Submissao();
    $submissao = Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao());

    $realizarAvaliacao = "";
    if ($submissao->getIdTipoSubmissao()==1) $realizarAvaliacao = "Realizar Avaliação Parcial";
    else if ($submissao->getIdTipoSubmissao()==2) $realizarAvaliacao = "Realizar Avaliação da Versão Corrigida";
    if ($submissao->getIdTipoSubmissao()==3) $realizarAvaliacao = "Realizar Avaliação Final";
    
    $avaliacaoCriterios = AvaliacaoCriterio::retornaCriteriosParaAvaliacao($avaliacao->getId());
    
?>

<script type='text/javascript'>
    function observacaoObrigatoria(valor) {

        if (valor=='5' || valor=='6') {          
            document.getElementById('observacao').setAttribute('required',true);
        }
        else document.getElementById('observacao').removeAttribute('required');
    }
</script>

<div class="panel-heading">
    <h3 class="panel-title">Dados da Submissão</h3>
</div>
<div class="panel panel-headline">

    <div class="panel-body">

        <form method="post" action="<?=htmlspecialchars('submissaoForms/wsRealizarAvaliacao.php');?>" enctype="multipart/form-data">
            <input type="hidden" id="idAvaliacao" name="idAvaliacao" value="<?php echo $avaliacao->getId() ?>" >


            <div class="row">
                <div class="col-md-4 mb-4">
                    <label class="control-label">Evento</label>
                        <input class='form-control' readonly="true" value="<?php echo Evento::retornaDadosEvento($submissao->getIdEvento())->getNome() ?>">
                    <div class="help-inline ">

                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <label class="control-label">Modalidade</label>
                        <input class='form-control' readonly="true" value="<?php echo Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao() ?>">
                    <div class="help-inline ">

                    </div>
                </div>


                <div class="col-md-4 mb-4">
                    <label for="select-Areas">Área</label> 
                        <input class='form-control' readonly="true" value="<?php echo Area::retornaDadosArea($submissao->getIdArea())->getDescricao() ?>">
                    <div class="help-inline ">

                    </div>
                </div>

            </div>
            <hr/>

            <div class="row">
                <div class="col-md-12  mb-4">
                    <label for="e.address">Título</label> 
                        <input class="form-control" id="titulo" name="titulo" required="true" value="<?php echo $submissao->getTitulo()?>" readonly="true">
                    <div class="help-inline ">

                    </div>
                </div>	
            </div>


            <div class="row">
                <div class="col-md-12  mb-4">
                    <label for="resumo">Resumo</label> 
                    <textarea id="resumo" name="resumo" rows="10" class="form-control" required="true" style="resize:none" readonly="true"><?php echo $submissao->getResumo() ?></textarea>
                    <div class="help-inline ">

                    </div>
                </div>	
            </div>


            <div class="row">

                <div class="col-md-4 mb-4">
                        <label for="e.contact">Palavras-Chave</label>
                            <input class="form-control" id="palavrasChave" name="palavrasChave" required="true" value="<?php echo $submissao->getPalavrasChave()?>" readonly="true">
                        <div class="help-inline ">
                            
                        </div>
                </div>

                <div class="col-md-4 mb-4">
                        <label for="e.contact">Tipo de Submissão</label>
                            <input class="form-control" required="true" value="<?php echo TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao()?>" readonly="true">
                        <div class="help-inline ">
                            
                        </div>
                </div>

                <div class="col-md-4 mb-4">
                    <label for="e.contact">Situação desta Avaliação</label>
                        <input class="form-control" required="true" value="<?php echo SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao()?>" readonly="true">
                    <div class="help-inline ">
                        <?php if (!in_array($avaliacao->getIdSituacaoAvaliacao(), array(2,4,5,6))) echo "Prazo final da Avaliação: " . date('d/m/Y', strtotime($avaliacao->getPrazo())) ?>
                    </div>
                </div>


            </div>

            
            <hr/>

            <script>
                    $(function(){
                             $('#about').summernote({
                                     airMode: true,
                                     popover: {
                                            air: [
                                                // [groupName, [list of button]]
                                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                                ['fontsize', ['fontsize']],
                                                ['color', ['color']],
                                                ['insert', ['link']],
                                                ['para', ['ul', 'ol', 'paragraph']],
                                              ]
                                     }
                             });
                    });

            </script>
        
        <div class="panel-heading">
            <h3 class="panel-title" align='center'>Avaliação do Trabalho</h3>
        </div>
        <table class="table table-striped table-bordered dt-responsive nowrap">
                <tr><th align='center'><strong>Descrição</strong></th>
                <th align='center'><strong>Peso</strong></th>
                <th align='center'><strong>Detalhes do Critério</strong></th>
                <th><strong>
                    <?php
                        $tipoSubmissao = Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdTipoSubmissao();
                    
                        // 1 = Parcial / 2 = Corrigida
                        if ($tipoSubmissao == 1 || $tipoSubmissao == 2) echo "Resposta: ";
                        else echo "Nota: ";
                    ?>
                    </strong>
                </th>
                
                
                
                <?php 
                foreach ($avaliacaoCriterios as $avaliacaoCriterio ) {
                    $criterio = new Criterio();
                    $criterio = Criterio::retornaDadosCriterio($avaliacaoCriterio->getIdCriterio());
                    $id = $avaliacaoCriterio->getId();
                ?>
                    <input type='hidden' id='<?php echo $id ?>' name='<?php echo $id ?>' value='<?php echo $avaliacaoCriterio->getNota()?>'>
                    <tr><td><?php echo $criterio->getDescricao() ?></td>
                        <td align='center'><?php echo $submissao->getIdTipoSubmissao()==3 ? $criterio->getPeso() : "-" ?></td>
                        <td><?php echo $criterio->getDetalhamento()?></td>
                        <td><select required='true' class='form-control' style='width: 70px' onchange="document.getElementById('<?php echo $avaliacaoCriterio->getId() ?>').value=this.value">
                               <option value=''>-</option>
                               <?php if ($tipoSubmissao == 1 || $tipoSubmissao == 2) { ?>
                                    <option value='1' <?php if ($avaliacaoCriterio->getNota() == '1') echo " selected"; ?>>Sim</option>
                                    <option value='0' <?php if ($avaliacaoCriterio->getNota() == '0') echo " selected"; ?>>Não</option>
                               <?php }
                               else {
                                    for ($i=50;$i<=100;$i=$i+5) {
                                        $selected = "";
                                        if ($avaliacaoCriterio->getNota() == $i) $selected = " selected";
                                        echo "<option value='".$i."'".$selected.">".$i."</option>";
                                    }
                                } ?>
                            </select>
                        </td>
                    </tr>
                <?php }?>

                </table><br>
                
                
                
                <table class="table table-striped table-bordered dt-responsive nowrap">
                    <?php if ($tipoSubmissao==1 || $tipoSubmissao==2){?>
                        <tr><td align='right'>Avaliação: </td>
                            <td>
                                <select class='form-control' id='resultadoAvaliacao' name='resultadoAvaliacao' required="true" onchange="observacaoObrigatoria(this.value)">
                                    <option value=''>-</option>
                                    <?php
                                        $opcoes = array();
                                        // 4 - Aprovado(a), 5 - Aprovado(a) com Ressalvas, 6 - Reprovado(a)
                                        if ($tipoSubmissao == 1) $opcoes = array (4,5,6); // Se for uma submissão Parcial...
                                        else $opcoes = array (4,6); // Se for uma submissão Corrigida;

                                        foreach ($opcoes as $opcao) {
                                            if ($opcao == $avaliacao->getIdSituacaoAvaliacao()) echo "<option selected value='".$opcao."'>".SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($opcao)->getDescricao()."</option>";
                                            else echo "<option value='".$opcao."'>".SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($opcao)->getDescricao()."</option>";
                                        }
                                        
                                    ?>
                                </select>
                            </td>
                        </tr>
                    <?php }?>
                    <tr><td align='right'>Análise da Avaliação: </td>
                        <td><textarea class=form-control id='observacao' name='observacao' cols='80' rows='10' style="resize: none;"><?php echo $avaliacao->getObservacao()?></textarea></td>
                    </tr>
                    <?php if ($tipoSubmissao == 2) { // Submissão Corrigida, mostradas as observações feitas na submissão anterior?>
                    <tr><th>Observações da <br>Submissão Parcial: </th>
                        <td><i><?php 
                                    foreach (Avaliacao::listaAvaliacoesComFiltro($avaliacao->getIdUsuario(), Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdRelacaoComSubmissao(), '') as $avalParcial) {
                                        echo $avalParcial->getObservacao(); break;
                                    }
                                ?>
                            </i></td>
                    </tr>
                    <?php } ?>
                </table>
                
                <div class="control-group form-actions">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                        <button class="btn btn-lg btn-primary btn-block mb-4" type="submit">Realizar Avaliação</button>
                        </div>

                        <div class="col-md-3 mb-4">
                            <a class="btn btn-lg btn-default  btn-block" onclick="$('#modal').fadeOut(500)">Retornar</a>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    
</div>
    
