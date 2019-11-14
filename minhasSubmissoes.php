<?php

    include 'inc/includes.php';
    
    session_start();
    

    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    //echo $usuario->getNome(); 
   // exit(1);  
    
        
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
                $submissoes = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro('', $usuario->getId(), '','','');

            ?>
            
            <fieldset class='inicio'>
                <p align='center'><input class="btn btn-sm marginTB-xs btn-success" type="button" value="Adicionar Submissão" onclick="location.href='addSubmissao2.php'"></p>
            
                <h2 align="center">Submissões do Usuário</h2>
                <table class="table table-striped table-bordered dt-responsive nowrap">
                
                <?php if (count($submissoes)==0) echo "<tr><td align='center'>Nenhum trabalho submetido</td></tr>";
                      else { ?>
                        <thead>
                            <tr>
                                <td align='center'><strong>*</td>
				<td align='center'><strong>Título</td>
				<td align='center'><strong>Evento</td>
                                <td align='center'><strong>Area</td>
                                <td align='center'><strong>Modalidade</td>
                                <td align='center'><strong>Tipo</td>
                                <td align='center'><strong>Situação</td>
                                <td align='center'><strong>Autores</td>
                                <td align='center'><strong>Versão Final</td>
                            </tr>
                        </thead>
                        <tbody>
                                
                       <?php         
                          foreach ($submissoes as $obj) {
                              $submissao = Submissao::retornaDadosSubmissao($obj->getIdSubmissao());
                              $usuarioSubmissao = "";
                              
			      foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($obj->getIdSubmissao(), '', '','','') as $user) {

				  $user12 = UsuarioPedrina::retornaDadosUsuario($user->getIdUsuario());
				  $img = "<img src='/sistemadesubmissao/uploads/fotosPerfil/semFoto.jpg' class='flag'>";
				  if ($user12->getPicture()!=NULL) $img ="<img src='/expotecsc/attendees/getuserpicture/".$user12->getId()."/' class='flag'>";

	  		          $usuarioSubmissao .= $img . $user12->getNome();
			  	  				  
                                  if ($user->getIsSubmissor() == 1) $usuarioSubmissao .= " (Submissor)";
                                  $usuarioSubmissao .= "<br>";
                              }
                              $id = $submissao->getId();
                              $nota = $submissao->getNota();
                              $situacao = SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao());
                                                            
                              $visualizar = "<a id='".$id."' onclick=\"location.href='visualizarSubmissao.php?id=".$submissao->getId()."'\"><i class='fa fa-search m-right-xs'></i></a>";
                              $editar="";
                              $excluir="";
			      $arquivo = "<a href='".$pastaSubmissoes . $submissao->getArquivo()."' target='blank'><i class='fa fa-file'></i>  </a>";
			      if ($obj->getIsSubmissor() && $situacao->getDescricao()=="Submetida" && $submissao->getIdTipoSubmissao()==1) {
                                  $editar = "<a id='".$id."' onclick=\"location.href='editarSubmissao2.php?id=".$submissao->getId()."'\"><i class='fa fa-edit m-right-xs'></i></a>";
                                  
                                  if (TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao() == "Parcial") {
                                    $excluir = "<a href='submissaoForms/wsCancelarSubmissao.php?id=" . $id . "' "
                                              . "onclick=\"return confirm('Tem certeza que deseja excluir esta Submissao?')\">"
                                              . "<i class='fa fa-trash m-right-xs'></i></a>";
                                  }
                              }
			      // INSERÇÃO DE CODIGO MOMENTANEO PARA ALTERAÇÃO DE ALGUNS DADOS:
			      if ($obj->getIsSubmissor() && ($submissao->getIdTipoSubmissao()==3 || $submissao->getIdTipoSubmissao()==2)) {
				  $editar = "<a id='".$id."' onclick=\"location.href='editarSubmissao2.php?id=".$submissao->getId()."'\"><i class='fa fa-edit m-right-xs'></i></a>";
			      }
			      // FIM


                              $versaoFinal = "-";
                              
                                // Tipos de Submissoes: 1-Parcial, 2-Corrigida, 3-Final
                                // Tipos de Situacao de Submissao: 4-Aprovado(a), 5-Aprovado(a), 6-Reprovado(a)
                                if ($submissao->getIdTipoSubmissao()==1 && $submissao->getIdSituacaoSubmissao()==5 && !Submissao::existeSubmissaoCorrigida($submissao->getId())) {  
                                      $versaoFinal = "<input type='button' class='addObjeto btn-sm marginTB-xs btn-primary' name='VersaoCorrigida' id='".$submissao->getId()."' value='Enviar Versão Corrigida'><br><strong>Prazo Final:</strong> ". date('d/m/Y', strtotime(Evento::retornaDadosEvento($submissao->getIdEvento())->getPrazoFinalEnvioSubmissaoCorrigida()));
                                }
                                else if ($submissao->getIdTipoSubmissao()==1 && $submissao->getIdSituacaoSubmissao()==5 && Submissao::existeSubmissaoCorrigida($submissao->getId())) {
                                    $versaoFinal = "Enviada";
                                }
                              
                                ?>
                                    <tr>
					<td align='center' style='vertical-align: middle;'><?php echo $visualizar.$arquivo.$editar.$excluir ?></td>
					<td align='center' style='vertical-align: middle;'><?php echo $submissao->getTitulo() ?> </td>
                                        <td align='center' style='vertical-align: middle;'><?php echo Evento::retornaDadosEvento($submissao->getIdEvento())->getNome() ?></td>
                                        <td align='center' style='vertical-align: middle;'><?php echo Area::retornaDadosArea($submissao->getIdArea())->getDescricao() ?></td>
                                        <td align='center' style='vertical-align: middle;'><?php echo Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao() ?></td>
                                        <td align='center' style='vertical-align: middle;'><?php echo TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao() ?></td>
                                        
                                     
                                        <td align='center' style='vertical-align: middle;'><?php echo $situacao->getDescricao() ?></td>
                                        <td style='vertical-align: middle;'><?php echo $usuarioSubmissao ?></td>
                                        <td align='center' style='vertical-align: middle;'><?php echo $versaoFinal ?></td></tr>
                                
                              
                    <?php }
                          
                          
                      } ?>
                    </tbody>
                </table>
            </fieldset>   
        
        <?php include dirname(__FILE__) . '/inc/pFinal.php'; ?>
                            
                        
    </body>
</html>

