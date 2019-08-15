<?php
    //include dirname(__FILE__)
    include dirname(__DIR__) . './inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    $avaliacao = Avaliacao::retornaDadosAvaliacao($_GET['id']);
    if ($avaliacao->getId()=="") header('Location: ./paginaInicial.php');
    
    if ($avaliacao->getIdUsuario()!=$usuario->getId()) header('Location: ./paginaInicial.php?User=permissaoNegada');
    
    $submissao = new Submissao();
    $submissao = Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao());

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
<div class="titulo-modal">Realizar Avaliação</div>

<div class="itens-modal">
    

    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsRealizarAvaliacao.php');?>" >
        <input type="hidden" id="idAvaliacao" name="idAvaliacao" value="<?php echo $avaliacao->getId() ?>" >
                

            <table align='center' class='cadastroItens'>
                <tr><td><strong>Título: </strong></td><td><?php echo $submissao->getTitulo() ?></td></tr>
                <tr><td><strong>Modalidade: </strong></td><td><?php echo Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao() ?></td></tr>
                <tr><td><strong>Resumo: </strong></td><td><?php echo $submissao->getResumo() ?></td></tr>
                <tr><td><strong>Palavras Chave: </strong></td><td><?php echo $submissao->getPalavrasChave() ?></td></tr>
                <tr>
                    <?php 
                        $tipoSubmissao = TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getId();
                        // 1 = Parcial , 2 = Corrigida , 3 - Final
                        if ($tipoSubmissao == 1 || $tipoSubmissao == 2) echo "<td><strong>Situação da Avaliação: </strong></td><td>" . SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao() . "</td>";
                        else echo "<td><strong>Nota: </strong></td><td>" . $avaliacao->getNota () . "</td>";
                    ?>
                </tr>
            </table>
                
            <h3 align='center'>Avaliar Trabalho</h3>
                
            <table  class='table_list_3' border=1 align='center'>
                <tr><th align='center'><strong>Descrição</strong></th>
                <th align='center'><strong>Peso</strong></th>
                <th align='center'><strong>Detalhes do Critério</strong></th>
                <th><strong>
                    <?php 
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
                        <td align='center'><?php echo $criterio->getPeso() ?></td>
                        <td align='center'><?php echo $criterio->getDetalhamento()?></td>
                        <td><select required='true' class='campoDeEntrada' style='width: 70px' onchange="document.getElementById('<?php echo $avaliacaoCriterio->getId() ?>').value=this.value">
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
                
                
                
                <table align='center'>
                    <?php if ($tipoSubmissao==1 || $tipoSubmissao==2){?>
                        <tr><th>Avaliação: </th>
                            <td>
                                <select class='campoDeEntrada' id='resultadoAvaliacao' name='resultadoAvaliacao' required="true" onchange="observacaoObrigatoria(this.value)">
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
                    <tr><th>Análise da Avaliação: </th>
                        <td><textarea class=campoDeEntrada id='observacao' name='observacao' cols='30' rows='5' style="resize: none;"><?php echo $avaliacao->getObservacao()?></textarea></td>
                    </tr>
                </table>
                
                <p align='center'><input type='submit' class='btn-verde' value='Enviar Avaliação'></p>
                
            </form>
</div>

<script>observacaoObrigatoria('<?php echo SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getId()?>')</script>