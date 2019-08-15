<?php

    include dirname(__FILE__) . './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
 //   verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
    if (!Avaliacao::atualizarSituacaoAvaliacoes()) {
        echo "erro"; exit(1);
    }  
        
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
            include './inc/css.php';
            include './inc/javascript.php';
        ?>
    </head>
    
    <body>
        
        <?php 
            include './inc/menuInicial.php';
            include './inc/modal.php';
            $minhasAvaliacoes = Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), '', '');
        ?>

        <fieldset>
            <h2 align="center">Minhas avaliações</h2>
            
            <table border="1" align="center" class='table_list'>
                <tr>
                    <td align="center"><strong>*</strong></td>
                    <td align="center"><strong>Evento</strong></td>
                    <td align="center"><strong>Área</strong></td>
                    <td align="center"><strong>Modalidade</strong></td>
                    <td align="center"><strong>Título</strong></td>
                    <td align="center"><strong>Arquivo</strong></td>
                    <td align="center"><strong>Situação<br>da Submissão</strong></td>
                    <td align="center"><strong>Situação<br>desta Avaliação</strong></td>
                    <td align="center"><strong>Nota</strong></td>
                    
                </tr>
                
                <?php
                    if (count($minhasAvaliacoes)==0)
                        echo "<tr><td colspan='9' align=center>Não existem avaliações a serem realizadas por você</td></tr>";
                    else {
                        foreach ($minhasAvaliacoes as $avaliacao) {
                           
                            $tipoSubmissao = TipoSubmissao::retornaDadosTipoSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdTipoSubmissao())->getId();
                            
                            // Tipos De Submissao: 1-Parcial, 2-Corrigida, 3-Final
                            // Tipos de Situacao Submissao: 4-Aprovado, 5-Aprovado com Ressalvas, 6-Reprovado
                            
                            /*
                             * O IF abaixo verifica se essa é uma Avaliação de uma submissão corrigida. Sendo assim, o sistema busca a situação da avaliação do usuário
                             * na versão Parcial da Submissão. Caso tenha diso APROVADO COM RESSALVAS (5), o sistema habilita para ele realizar a avaliação. Caso contrário,
                             * ou seja, o avaliador tenha avaliado a versão parcial do Trabalho como APROVADO ou REPROVADO, ele não precisa mais realizar a avaliação
                             */
                            if ($tipoSubmissao==2) {
                                $submissaoParcial = Submissao::retornaDadosSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdRelacaoComSubmissao());
                                if (count(Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), $submissaoParcial->getId(), 5))!=1) continue;
                            }
                            
                            $situacaoSubmissao = SituacaoSubmissao::retornaDadosSituacaoSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdSituacaoSubmissao())->getDescricao();
                            $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao();
                            
                            
                            $avParcialCorrigida = array(1,2);
                            
                            if ($situacaoSubmissao=="Em avaliacao") {
                                echo "<td><a class='editarObjeto' id='".$avaliacao->getId()."' name='AvaliacaoIndividual'><img src='$iconEditar' class='img-miniatura'></a></td>";
                            }
                            else echo "<td><a class='visualizarObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><img src='$iconVisualizar' class='img-miniatura'></a></td>";
                            
                            echo "<td>".Evento::retornaDadosEvento(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdEvento())->getNome()."</td>";
                            echo "<td>".Area::retornaDadosArea(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdArea())->getDescricao()."</td>";
                            echo "<td>".Modalidade::retornaDadosModalidade(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdModalidade())->getDescricao()."</td>";
                            echo "<td>".Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getTitulo()."</td>";
                            echo "<td><a href='".$pastaSubmissoes . Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getArquivo()."'>Visualizar</td>";
                            echo "<td>".$situacaoSubmissao."</td>";
                            echo "<td>".SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao()."</td>";
                            
                            if (in_array($tipoSubmissao, $avParcialCorrigida)) echo "<td>-</td></tr>";
                            else echo "<td>".$avaliacao->getNota()."</td></tr>";
                            
                        }
                    }
                ?>
            </table>
        </fieldset>
    </body>
</html>