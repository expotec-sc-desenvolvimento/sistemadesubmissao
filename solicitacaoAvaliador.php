<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
?>
    <!DOCTYPE html>
    <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="author" content="José Sueney de Lima">
            <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
            <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>SS - Minhas Solicitacoes de Avaliador</title>
            
            <?php
                include 'inc/css.php';
                include 'inc/javascript.php';
            ?>
            
        </head>

        <body>

            
            <?php 
                include dirname(__FILE__) . '/inc/pInicial.php'; 
                include 'inc/modal.php';
            ?>

            <?php
                $solicitacoes = SolicitacaoAvaliador::listaSolicitacaoAvaliadorComFiltro($usuario->getId(), '', '', '');
                
            ?>
            
            <fieldset class='inicio'>
                <p align='center'><input class="addObjeto btn btn-sm marginTB-xs btn-success" type="button" name='SolicitacaoAvaliador' value="Adicionar Solicitação"></p>
            
                <h2 align="center">Solicitacões para Avaliador do Usuário</h2>
                <table border="1" align="center" class="table table-striped table-bordered dt-responsive nowrap">
                <?php if (count($solicitacoes)==0) {
                        echo "<tr><td align=center>Nenhuma solicitação feita</td></tr>";
                      }
                      else {
                          echo "<tr>"
                                . "<td><strong>*</strong></td>"
                                . "<td><strong>Evento</strong></td>"
                                . "<td><strong>Area</strong></td>"
                                . "<td><strong>Situação</strong></td>"
                                . "<td><strong>Observação</strong></td>";
                                
                                
                          foreach ($solicitacoes as $obj) {
                              $evento = new Evento();
                              $evento = Evento::retornaDadosEvento($obj->getIdEvento());
                              
                              $area = new Area();
                              $area = Area::retornaDadosArea($obj->getIdArea());
                              
                              $situacao = $obj->getSituacao();

                              $excluir="";
                              if ($situacao=='Pendente') {
                                  $excluir = "<a href='submissaoForms/wsExcluirSolicitacaoAvaliador.php?id=" . $obj->getId() . "' "
                                          . "onclick=\"return confirm('Tem certeza que deseja excluir esta Solicitacao?')\">"
                                          . "<i class='fa fa-trash-alt m-right-xs'></i></a>";
                                  
                              }
                              
                              if ($situacao == 'Pendente') $situacao= "<img src='".$iconAguardando."' class='img-miniatura' title='Aguardando'>";
                              if ($situacao == 'Deferida') $situacao= "<img src='".$iconOK."' class='img-miniatura' title='Deferido'>";
                              if ($situacao == 'Indeferida') $situacao= "<img src='".$iconExcluir."' class='img-miniatura' title='Indeferido'>";
                              
                              
                              echo "<tr>"
                                . "<td>".$excluir."</td>"
                                . "<td>". $evento->getNome()."</td>"
                                . "<td>".$area->getDescricao()."</td>"
                                . "<td>".$situacao."</td>"
                                . "<td>".$obj->getObservacao()."</td></tr>";
                                
                              
                          }
                          
                      }
                ?>
                </table>
            </fieldset>
            <?php 
                include dirname(__FILE__) . '/inc/pFinal.php'; 
            ?>
        </body>
    </html>
