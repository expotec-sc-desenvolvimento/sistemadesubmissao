<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"./paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
    
    $listaEventos = Evento::listaEventos();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Gerenciar Eventos</title>
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
        
            
            
    </head>
    
    <body>
        
        <?php 
            include 'inc/pInicial.php';
            include 'inc/modal.php';
            
        ?>
        
        <br>
        <h3 align='center'>Listagem de Eventos - <?php echo count($listaEventos)?></h3>

            <p align="center"><input type="button" class="addObjeto btn btn-sm marginTB-xs btn-success" name='Evento' value="Adicionar Evento"></p>
            
                <br>
                
        <table class='table table-striped table-bordered dt-responsive nowrap' border="1" align='center' >
            <tr>
                <td colspan="9" style="text-align: center"><strong>Lista de Eventos Cadastrados</strong></td>
            </tr>
            
            <tr>
                <th style="text-align: center">*</th>
                <th style="text-align: center">Logo</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Modalidades de Submissão</th>
                <th style="text-align: center">Áreas de Submissão</th>
                <th style="text-align: center">Prazos</th>
                
            </tr>
            <?php foreach($listaEventos as $evento){ 
                
                $modalidadesDoEvento = Modalidade::listaModalidadesPorEvento($evento->getId());
                $areasDoEvento = Area::listaAreasPorEvento($evento->getId());
            ?>
                        
                <tr><td align="center" style="vertical-align: middle;">
                        <a class='editarObjeto' id='<?php echo $evento->getId() ?>' name='Evento'><i class="fa fa-edit m-right-xs"></i></a>
                        <a class="excluirObjeto" id="<?php echo $evento->getId() ?>" name='Evento'><i class="fa fa-trash m-right-xs"></i></a>
                    </td>
                    
                    <td align="center" style="vertical-align: middle;"><img src='<?php echo $pastaFotosEventos . $evento->getLogo() ?>' width='90px'></td>
                    <td align="center" style="vertical-align: middle;"><?php echo $evento->getNome() ?></td>
                        
                    <?php if (count($modalidadesDoEvento)==0) { ?> <td>-
                    <?php 
                    }
                    else  { ?>
                        <td><ul class="listaCriterios">
                    <?php   foreach ($modalidadesDoEvento as $modalidade) {
                                $id = ModalidadeEvento::retornaIdModalidadeEvento($evento->getId(),$modalidade->getId()); ?>
                                <li>
                                     <a class='excluirObjeto' id='<?php echo $id ?>' name='ModalidadeEvento'><i class="fa fa-trash m-right-xs"></i></a>
                                     <?php echo $modalidade->getDescricao() ?>    
                                </li>
                    <?php   } ?>
                        </ul>
                            
                        
                    <?php }  ?>
                        <p align='center'><input type='button' class='addObjeto btn btn-sm marginTB-xs btn-success' id='<?php echo $evento->getId() ?>' name='ModalidadeEvento' value='Vincular Modalidade' ></p>
                        </td>
                    <?php
                    if (count($areasDoEvento)==0) { ?> <td>-
                    <?php 
                    }
                    else  { ?>
                        <td><ul class="listaCriterios">
                    <?php   foreach ($areasDoEvento as $area) {
                                $id = AreaEvento::retornaIdAreaEvento($evento->getId(),$area->getId()); ?>
                                <li>
                                     <a class='excluirObjeto' id='<?php echo $id ?>' name='AreaEvento'><i class="fa fa-trash m-right-xs"></i></a>
                                     <?php echo $area->getDescricao() ?>    
                                </li>
                    <?php   } ?>
                        </ul>
                            
                    <?php } ?>
                    <p align='center'><input type='button' class='addObjeto btn btn-sm marginTB-xs btn-success' id='<?php echo $evento->getId() ?>' name='AreaEvento' value='Vincular Area' ></p>
                        </td>
                        <td>
                            <ul class="listaCriterios">
                                <li><strong>Período de Submissão:</strong> <?php echo date('d/m/Y',strtotime($evento->getInicioSubmissao())) ." a ". date('d/m/Y',strtotime($evento->getFimSubmissao()));?></li>
                                <li><strong>Prazo para envio de Avaliações Parciais:</strong> <?php echo date('d/m/Y',strtotime($evento->getprazoFinalEnvioAvaliacaoParcial()));?></li>
                                <li><strong>Prazo para envio de Submissões Corrigidas:</strong> <?php echo date('d/m/Y',strtotime($evento->getprazoFinalEnvioSubmissaoCorrigida()));?></li>
                                <li><strong>Prazo para envio de Avaliações Corrigidas:</strong> <?php echo date('d/m/Y',strtotime($evento->getPrazoFinalEnvioAvaliacaoCorrigida()));?></li>
                                <li><strong>Prazo para envio de Avaliações Finais:</strong> <?php echo date('d/m/Y',strtotime($evento->getprazoFinalEnvioAvaliacaoFinal()));?></li>
                                <li><strong>Prazo para inscrição de Avaliadores:</strong> <?php echo date('d/m/Y',strtotime($evento->getprazoInscricaoAvaliadores()));?></li>
                                
                            </ul>
                        </td>
                    </tr>
                
            <?php }?>
             
        </table>
            <?php 
                include 'inc/pFinal.php';
            ?>
    </body>
</html>
