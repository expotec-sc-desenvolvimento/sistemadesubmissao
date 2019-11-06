<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    date_default_timezone_set('America/Sao_Paulo');
 //   verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
  //  if (!Avaliacao::atualizarSituacaoAvaliacoes()) {
    //    echo "erro"; exit(1);
    //}  
        
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Minhas Avaliações</title>
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
    </head>
    
    <body>
        
        <?php 
            include dirname(__FILE__) . '/inc/pInicial.php'; 
            include 'inc/modal.php';
            $minhasAvaliacoes = Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), '', '');
        ?>

        <fieldset>
            <h2 align="center">Minhas avaliações</h2>
            
            
            
                
                <?php
                    if (count($minhasAvaliacoes)==0) { ?>
                        <table border='1' align='center' class='table table-striped table-bordered dt-responsive nowrap'>
                            <tr><td colspan="11" align='center'>Não existem avaliações a serem realizadas por você</td></tr>
                        </table>
                    
                    <?php }
                        
                    else {
                        $cabecalho = "<table border='1' align='center' class='table table-striped table-bordered dt-responsive nowrap'>
                                            <thead>
                                                <tr>
                                                    <th>*</th>
                                                    <th>Evento</th>
                                                    <th>Área</th>
                                                    <th>Modalidade</th>
                                                    <th>Título</th>
                                                    <th>Versão</th>
                                                    
                                                    <th>Situação desta Avaliação</th>
                                                    <th>Data de Realização da Avaliação</th>
                                                    <th>Prazo de Entrega</th>
                                                    <th>Nota</th>

                                                </tr>
                                            </thead>
                                            <tbody>";
                        
                        $contAvParciais = 0;
                        $contAvCorrigidas = 0;
                        $contAvFinais = 0;
                        
                        $avParciais = "";
                        $avCorrigidas = "";
                        $avFinais = "";
                        
                        foreach ($minhasAvaliacoes as $avaliacao) {

                            $tipoSubmissao = TipoSubmissao::retornaDadosTipoSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdTipoSubmissao())->getId();
                            $a;
                            if ($tipoSubmissao==1) {$a = &$avParciais; $contAvParciais++;}
                            else if ($tipoSubmissao==2) {
                                // Tipos De Submissao: 1-Parcial, 2-Corrigida, 3-Final
                                // Tipos de Situacao Submissao: 4-Aprovado, 5-Aprovado com Ressalvas, 6-Reprovado

                                /*
                                 * O IF abaixo verifica se essa é uma Avaliação de uma submissão corrigida. Sendo assim, o sistema busca a situação da avaliação do usuário
                                 * na versão Parcial da Submissão. Caso tenha diso APROVADO COM RESSALVAS (5), o sistema habilita para ele realizar a avaliação. Caso contrário,
                                 * ou seja, o avaliador tenha avaliado a versão parcial do Trabalho como APROVADO ou REPROVADO, ele não precisa mais realizar a avaliação
                                 */
                                $submissaoParcial = Submissao::retornaDadosSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdRelacaoComSubmissao());
			        if (count(Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), $submissaoParcial->getId(), 5))!=1) continue;
			        else {
                                    $a = &$avCorrigidas;
                                    $contAvCorrigidas++;
                                }
                                
                            }
                            else if ($tipoSubmissao==3) {$a = &$avFinais; $contAvFinais++;}
                            
                            
                             $arquivo = "<a href='".$pastaSubmissoes .  Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getArquivo()."' target='blank'><i class='fa fa-file'></i>  </a>";

                            $situacaoSubmissao = SituacaoSubmissao::retornaDadosSituacaoSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdSituacaoSubmissao())->getDescricao();
                            $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao());
                            
                            
                            $avParcialCorrigida = array(1,2);
                            
                            if ($situacaoSubmissao=="Em avaliacao") { // Se a submissão não tiver sido finalizada...
                                if (!in_array($situacaoAvaliacao->getId(), array(2,4,5,6))) { // Se a avaliação não tiver sido finalizada
				     if ($tipoSubmissao!=3)  $a.= "<td><a class='editarObjeto' id='".$avaliacao->getId()."' name='AvaliacaoIndividual'><img src='$iconEditar' class='img-miniatura'></a>".$arquivo."</td>";
				     else	$a .= "<td></td>"; //REVER ISSO
                                }
                                else if (strtotime(date('d-m-Y'))<=strtotime ($avaliacao->getDataRealizacaoAvaliacao())) { //Se a avaliação tiver sido finalizada, mas foi ainda está no prazo para alteração (mesmo dia da avaliação)
                                    $a.= "<td><a class='editarObjeto' id='".$avaliacao->getId()."' name='AvaliacaoIndividual'><i class='fa fa-edit m-right-xs'></i></a>".$arquivo."</td>";
                                }
                                else $a.= "<td><a class='visualizarObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><i class='fa fa-search m-right-xs'></i></a>".$arquivo."</td>";
                            }
                            else $a.= "<td><a class='visualizarObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><i class='fa fa-search m-right-xs'></i></a>".$arquivo."</td>";
                            
                            $a.= "<td>".Evento::retornaDadosEvento(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdEvento())->getNome()."</td>";
                            $a.= "<td>".Area::retornaDadosArea(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdArea())->getDescricao()."</td>";
                            $a.= "<td>".Modalidade::retornaDadosModalidade(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdModalidade())->getDescricao()."</td>";
                            $a.= "<td>".Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getTitulo()."</td>";
                            $a.= "<td>".TipoSubmissao::retornaDadosTipoSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdTipoSubmissao())->getDescricao()."</td>";
                                                        
                            $a.= "<td>".SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao()."</td>";
                            
                            if ($avaliacao->getDataRealizacaoAvaliacao()=='') {$a.= "<td>-</td>";}
                            else $a.= "<td>" .date('d/m/Y', strtotime($avaliacao->getDataRealizacaoAvaliacao()))."</td>";
                            
                            if (in_array($avaliacao->getIdSituacaoAvaliacao(), array(2,4,5,6))) $a.= "<td>-</td>";
                            else $a.= "<td>".date('d/m/Y', strtotime($avaliacao->getPrazo()))."</td>";
                            
                            if (in_array($tipoSubmissao, $avParcialCorrigida)) $a.= "<td>-</td></tr>";
                            else $a.= "<td>".$avaliacao->getNota()."</td></tr>";
                            
                        }
                        
                        if ($contAvParciais>=1) { $avParciais = "<h3 align='center'>Avaliações Parciais (".$contAvParciais.")</h3>" . $cabecalho . $avParciais . "</tbody></table><br>"; echo $avParciais; }
                        if ($contAvCorrigidas>=1) { $avCorrigidas = "<h3 align='center'>Avaliações de Ressubmissão - Solicitações de Correção (".$contAvCorrigidas.")</h3>" . $cabecalho . $avCorrigidas . "</tbody></table><br>"; echo $avCorrigidas; }
                        if ($contAvFinais>=1) { $avFinais = "<h3 align='center'>Avaliações de Apresentação (".$contAvFinais.")</h3>" . $cabecalho . $avFinais. "</tbody></table>"; echo $avFinais; }
                    }
                ?>
                
        </fieldset>
            <?php 
                include dirname(__FILE__) . '/inc/pFinal.php'; 
            ?>
    </body>
</html>
