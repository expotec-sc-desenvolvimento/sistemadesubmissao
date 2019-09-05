<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"./paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
    
    date_default_timezone_set('America/Sao_Paulo');
    //if (!Avaliacao::atualizarSituacaoAvaliacoes()) {
      //  echo "erro"; exit(1);
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
        <title>SS - Finalizar Submissões em Lote</title>
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
        <script type="text/javascript">
            function marcarTodos() {
                if (document.getElementById('marcarTodas').checked == true) {
                    var itens = document.getElementsByName('submissoes[]');
                    var i = 0;
                    for(i=0; i<itens.length;i++){
                        itens[i].checked = true;
                    }
                    
                }
                else {
                    
                    var itens = document.getElementsByName('submissoes[]');
                    var i = 0;
                    for(i=0; i<itens.length;i++){
                        itens[i].checked = false;
                    }
                }
            }
        </script>
    </head>
    
    
    <body>
        
        <?php 
            include 'inc/menuInicial.php';
            include 'inc/modal.php';
        
            $listaSubmissoes = Submissao::retornaSubmissoesParaFinalizar();
            
        ?>
        <br>
        
        
        <fieldset>
            <h3 align='center'>Listagem de Submissões aptas a serem Finalizadas (<?php echo count($listaSubmissoes)?>)</h3>
            
            
            
            <form method="post" action="<?=htmlspecialchars('submissaoForms/wsFinalizarAvaliacoesEmLote.php');?>" enctype="multipart/form-data">
            <table border="1" align="center" class="table_list_3">
                <thead>
                    <tr>
                        <th>*</th>
                        <th>Evento</th>
                        <th>Area</th>
                        <th>Modalidade</th>
                        <th>Tipo</th>
                        <th>Titulo</th>
                        <th>Arquivo</th>
                        <th>Situação</th>
                        <th>Autores</th>
                        <th>Avaliadores</th>                        
                        <th><input type='checkbox' id='marcarTodas' name='marcarTodas' onclick="marcarTodos()"></th>

                    </tr>
                </thead>
                <tbody>
                <?php 
                    if (count($listaSubmissoes)==0) echo "<tr><td colspan='12' align=center>Nenhuma Submissão apta a ser Finalizada!</td></tr>";
                    else {
                        foreach ($listaSubmissoes as $submissao) {
                            
                            $usuariosSubmissao = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '');
                            $usuarioSubmissao = "<ul class='listaCriterios'>";
                            foreach ($usuariosSubmissao as $user) $usuarioSubmissao = $usuarioSubmissao . "<li>" . Usuario::retornaDadosUsuario($user->getIdUsuario())->getNome() . "</li>";
                            $usuarioSubmissao .= "</ul>";
                                    
                            $avaliacoes = Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(),'');
                            $avaliadores = "<ul class='listaCriterios'>";
                            
                            foreach ($avaliacoes as $avaliacao) {
                                $editarAvaliador = "";
                                $resultadoAvaliacao = "";
                                $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getId();
                                
                                // Situações de Avaliação = 1-Pendente, 2-Finalizada, 3-Atrasada, 4-Aprovado(a), 5-Aprovado(a) com ressalvas, 6-Reprovado
                                if (in_array($situacaoAvaliacao, array(1,3))) {
                                    $editarAvaliador = "<a class='editarObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><img src='".$iconEditar."' class='img-miniatura'></a>";
                                            //. "<a class='excluirObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><img src='".$iconExcluir."' class='img-miniatura'></a>";
                                }
                                else {
                                    $editarAvaliador = "<a class='visualizarObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><img src='".$iconVisualizar."' class='img-miniatura'></a>";
                                
                                    if ($situacaoAvaliacao == 2) /* Apresentado */ $resultadoAvaliacao = " - <img src='".$iconOK."' class='img-miniatura' title='Apresentado'>";
                                    else if ($situacaoAvaliacao == 4) /* Aprovado */ $resultadoAvaliacao = " - <img src='".$iconOK."' class='img-miniatura' title='Aprovado'>";
                                    else if ($situacaoAvaliacao == 5) /* Aprovado com Ressalvas */ $resultadoAvaliacao = " - <img src='".$iconOKRessalvas."' class='img-miniatura' title='Aprovado com Ressalvas'>";
                                    else /* Reprovado */ $resultadoAvaliacao = " - <img src='".$iconExcluir."' class='img-miniatura' title='Reprovado'>";
                                }
                                
                                
                                
                                $user = Usuario::retornaDadosUsuario($avaliacao->getIdUsuario());
                                $avaliadores = $avaliadores . "<li>" .$editarAvaliador . $user->getNome() . $resultadoAvaliacao ."</li>";
                            }
                            
                            $avaliadores .= "</ul>";

                            $finalizar="";
                            if (SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao()=="Em avaliacao") {
                                $contAvaliacoesFinalizadas = 0;
                                foreach (Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), '') as $aval) {
                                    if (in_array($aval->getIdSituacaoAvaliacao(), array(2,4,5,6)) && strtotime(date('d-m-Y'))>strtotime($aval->getDataRealizacaoAvaliacao())) {
                                        $contAvaliacoesFinalizadas++;
                                    }
                                }    
                                if ($contAvaliacoesFinalizadas==3) $finalizar = "<input type='button' class='editarObjeto btn-verde' id='".$submissao->getId()."' name='Finalizacao' value='Finalizar Submissão' />";
                            }
                            
                            
                            $addAvaliador = "";
                            $repetirAvaliadores = "";
                            
                            $situacaoSubmissao = SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao();
                            if ($situacaoSubmissao=="Submetida") {
                                $addAvaliador = "<p align='center'><input type='button' class='addObjeto btn-verde' id='".$submissao->getId()."' name='Avaliacao' value='Adicionar Manualmente'></p>";
                                $addAvaliador .= "<p align='center'><input type='button' class='btn-verde' onclick=\"window.location.href='submissaoForms/wsDistribuirAvaliacoesPorSubmissaoIndividual.php?id=".$submissao->getId()."'\" value='Distribuir Automaticamente'></p>";
                            }
                            
                            if (TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao()=="Final" &&
                                    SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao()=="Submetida") {
                                $repetirAvaliadores = "<p align='center'><input type='button' class='addObjeto btn-verde' id='".$submissao->getId()."' name='AvaliacaoRepetida' value='Repetir Avaliadores' ></p>";
                            }    //date('m/d/Y',$submissao->getDataEnvio());
                    ?>
                            <tr>
                                <td><a class='visualizarObjeto' id='<?php echo $submissao->getId() ?>' name='Submissao'><img src='<?php echo $iconVisualizar ?>' class='img-miniatura'></a></td>
                                <td><?php echo Evento::retornaDadosEvento($submissao->getIdEvento())->getNome() ?></td>
                                <td><?php echo Area::retornaDadosArea($submissao->getIdArea())->getDescricao() ?></td>
                                <td><?php echo Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao() ?></td>
                                <td><?php echo TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao() ?></td>
                                <td><?php echo $submissao->getTitulo(); ?></td>
                                <td><a href='<?php echo $pastaSubmissoes . $submissao->getArquivo()  ?>'>Visualizar</a></td>
                                <td><?php echo SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao() ?></td>
                                <td><?php echo $usuarioSubmissao ?></td>
                                <td><?php echo $avaliadores . $addAvaliador . $repetirAvaliadores?></td>
                                
                                <td><?php echo "<input type='checkbox' id='submissoes[]' name='submissoes[]' value='". $submissao->getId() ."'>"; ?></td></tr>
                      <?php          
                        }
                    }
                ?>
                </tbody>
            </table>
            <p align="center">
                <input class="btn-verde" type="submit" value="Finalizar Avaliações Selecionadas" onclick="return confirm('Deseja finalizar as submissões selecionadas?')"/>
            </p>
            </form>
    </body>
</html>