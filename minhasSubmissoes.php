<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
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
        <title>SS - Minhas Submissões</title>
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
    </head>
    
    <body>
        
        <?php 
            include dirname(__FILE__) . '/inc/pInicial.php'; 
            include './inc/modal.php';
        ?>
            
            <?php
                $submissoes = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro('', $usuario->getId(), '');
                
            ?>
            
            <fieldset class='inicio'>
                <p align='center'><input class="btn btn-sm marginTB-xs btn-success" type="button" value="Adicionar Submissão" onclick="location.href='addSubmissao2.php'"></p>
            
                <h2 align="center">Submissões do Usuário</h2>
                <table class="table table-striped table-bordered dt-responsive nowrap">
                
                <?php if (count($submissoes)==0) echo "<tr><td>Nenhum trabalho submetido</td></tr>";
                      else { ?>
                        <thead>
                            <tr>
                                <th><strong>*</th>
                                <th><strong>Evento</th>
                                <th><strong>Area</th>
                                <th><strong>Modalidade</th>
                                <th><strong>Tipo</th>
                                <th><strong>Titulo</th>
                                <th><strong>Arquivo</th>
                                <th><strong>Situação</th>
                                <th><strong>Autores</th>
                                <th><strong>Versão Final</td>
                            </tr>
                        </thead>
                        <tbody>
                                
                       <?php         
                          foreach ($submissoes as $obj) {
                              $submissao = Submissao::retornaDadosSubmissao($obj->getIdSubmissao());
                              $usuarioSubmissao = "";
                              
                              foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($obj->getIdSubmissao(), '', '') as $user) {
                                  $usuarioSubmissao = $usuarioSubmissao . Usuario::retornaDadosUsuario($user->getIdUsuario())->getNome();
                                  if ($user->getIsSubmissor() == 1) $usuarioSubmissao = $usuarioSubmissao . " (Submissor)";
                                  $usuarioSubmissao = $usuarioSubmissao . "<br>";
                              }
                              $id = $submissao->getId();
                              $nota = $submissao->getNota();
                              $situacao = SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao());
                                                            
                              $visualizar = "<a id='".$id."' onclick=\"location.href='visualizarSubmissao2.php?id=".$submissao->getId()."'\"><img class='img-miniatura' src='".$iconVisualizar."' width='20px'></a>";
                              $editar="";
                              $excluir="";
                              if ($obj->getIsSubmissor() && $situacao->getDescricao()=="Submetida" && $submissao->getIdTipoSubmissao()==1) {
                                  $editar = "<a id='".$id."' onclick=\"location.href='editarSubmissao2.php?id=".$submissao->getId()."'\"><img class='img-miniatura' src='".$iconEditar."' width='20px'></a>";
                                  
                                  if (TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao() == "Parcial") {
                                    $excluir = "<a href='submissaoForms/wsCancelarSubmissao.php?id=" . $id . "' "
                                              . "onclick=\"return confirm('Tem certeza que deseja excluir esta Submissao?')\">"
                                              . "<img src='".$iconExcluir."' width='20px'></a>";
                                  }
                              }
                              
                              $versaoFinal = "-";
                              
                                // Tipos de Submissoes: 1-Parcial, 2-Corrigida, 3-Final
                                // Tipos de Situacao de Submissao: 4-Aprovado(a), 5-Aprovado(a), 6-Reprovado(a)
                                if ($submissao->getIdTipoSubmissao()==1 && $submissao->getIdSituacaoSubmissao()==5 && !Submissao::existeSubmissaoCorrigida($submissao->getId())) {  
                                      $versaoFinal = "<input type='button' class='addObjeto btn-verde' name='VersaoCorrigida' id='".$submissao->getId()."' value='Enviar Versão Corrigida'><br><strong>Prazo Final:</strong> ". date('d/m/Y', strtotime(Evento::retornaDadosEvento($submissao->getIdEvento())->getPrazoFinalEnvioSubmissaoCorrigida()));
                                }
                                else if ($submissao->getIdTipoSubmissao()==1 && $submissao->getIdSituacaoSubmissao()==5 && Submissao::existeSubmissaoCorrigida($submissao->getId())) {
                                    $versaoFinal = "Enviada";
                                }
                              
                                ?>
                                    <tr>
                                        <td align='center'><?php echo $visualizar.$editar.$excluir ?></td>
                                        <td><?php echo Evento::retornaDadosEvento($submissao->getIdEvento())->getNome() ?></td>
                                        <td><?php echo Area::retornaDadosArea($submissao->getIdArea())->getDescricao() ?></td>
                                        <td><?php echo Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao() ?></td>
                                        <td><?php echo TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao() ?></td>
                                        <td><?php echo $submissao->getTitulo() ?></td>
                                        <td><a href='<?php echo $pastaSubmissoes . $submissao->getArquivo()  ?>'>Visualizar</a></td>
                                        <td><?php echo $situacao->getDescricao() ?></td>
                                        <td><?php echo $usuarioSubmissao ?></td>
                                        <td><?php echo $versaoFinal ?></td></tr>
                                
                              
                    <?php }
                          
                          
                      } ?>
                    </tbody>
                </table>
            </fieldset>   
        
        <?php include dirname(__FILE__) . '/inc/pFinal.php'; ?>
                            
                        
    </body>
</html>

