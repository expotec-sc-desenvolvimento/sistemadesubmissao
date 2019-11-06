<?php

include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];

    date_default_timezone_set('America/Sao_Paulo');    
    // O código abaixo verifica se há eventos com datas disponíveis para submissão
    
    $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
    $evento = Evento::retornaDadosEvento($submissao->getIdEvento());
    $area = Area::retornaDadosArea($submissao->getIdArea());
    $modalidade = Modalidade::retornaDadosModalidade($submissao->getIdModalidade());
    
    $dataFinalEnvioSubmissaoCorrigida = Evento::retornaDadosEvento($submissao->getIdEvento())->getPrazoFinalEnvioSubmissaoCorrigida();
    $dataAtual = date('Y-m-d');

    $userNaoSubmissor = false;
    $prazoEsgotado = false;
 //   echo $dataAtual . " - " . $dataFinalEnvioSubmissaoCorrigida;
//    echo date('Y-m-d H:m:s');
    if (strtotime($dataAtual) > strtotime($dataFinalEnvioSubmissaoCorrigida)) $prazoEsgotado = true;
    if (count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), $usuario->getId(), 1))==0) $userNaoSubmissor = true;
    
    $submissores="";
    
    foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '') as $submissor) {
        $submissores .= $submissor->getIdUsuario().";";
    }
    
?>

<div class="panel-heading">
    <h3 class="panel-title">Ressubmeter Trabalho</h3>
</div>

<div class="panel-body">
    <?php
    if ($userNaoSubmissor) echo "<p align='center'>Apenas o usuário Submissor pode realizar esta Operação</p>";
    else if ($prazoEsgotado) echo "<p align='center'>O prazo para envio da Versão corrigida foi excedido. Prazo Final: <strong>".date('d/m/Y',strtotime($dataFinalEnvioSubmissaoCorrigida))."</strong></p>";
        
    
    else { ?>
        <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEnviarSubmissaoCorrigida.php');?>" enctype="multipart/form-data">
        <input type="hidden" id="idSubmissao" name="idSubmissao" value="<?php echo $submissao->getId() ?>">
        <input type="hidden" id="idUsuariosAdd" name="idUsuariosAdd" value="<?php echo $submissores ?>">
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <label class="control-label">Evento</label>
                <input type='hidden' id="select-Eventos" name="select-Eventos" value="<?php echo $evento->getId()?>">
                <input class='form-control' readonly="true" value="<?php echo $evento->getNome() ?>">
                <div class="help-inline ">

                </div>
            </div>

            <div class="col-md-4 mb-4">
                <label class="control-label">Modalidade</label>
                <input type='hidden' id="select-Modalidades" name="select-Modalidades" value="<?php echo $modalidade->getId()?>">
                <input class='form-control' readonly="true" value="<?php echo $modalidade->getDescricao() ?>">
                <div class="help-inline ">

                </div>
            </div>


            <div class="col-md-4 mb-4">
                <label class="control-label">Área</label>
                <input type='hidden' id="select-Areas" name="select-Areas" value="<?php echo $area->getId()?>">
                <input class='form-control' readonly="true" value="<?php echo $area->getDescricao() ?>">
                <div class="help-inline ">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Título</label> 
                    <input class="form-control" id="titulo" name="titulo" value="<?php echo $submissao->getTitulo() ?>">
                <div class="help-inline ">

                </div>
            </div>	
        </div>
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="resumo">Resumo</label> 
                <textarea rows="10" class="form-control"  id="resumo" name="resumo" style="resize:none"><?php echo $submissao->getResumo() ?></textarea>
                <div class="help-inline ">

                </div>
            </div>	
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                    <label for="e.contact">Palavras-Chave</label>
                    <input class="form-control" id="palavrasChave" name="palavrasChave" value="<?php echo $submissao->getPalavrasChave() ?>">
                    <div class="help-inline ">
                        Inserir de 3 a 5 palavras-chave, Separadas por vírgula (Ex.: palavra1, palavra2)
                    </div>
            </div>

            <div class="col-md-4 mb-4">
                <label for="e.contact">Relação com</label>
                <input class="form-control" id="relacaoCom" name="relacaoCom" readonly="true" value="<?php echo $submissao->getRelacaoCom() ?>">
                <div class="help-inline ">

                </div>
            </div>

            <div class="col-md-4  mb-4">
                <label  for="arquivo" >Download</label>
                <input class="form-control" type="file" id="arquivo" name="arquivo" required="true">
                <div class="help-inline ">

                </div>
            </div>
            
        </div>
        
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Autores</label><br>
                    <ul style='list-style-type: none;'>
                        <?php
                            foreach(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '') as $obj) {
                                $user = UsuarioPedrina::retornaDadosUsuario($obj->getIdUsuario());
                                echo "<li><div><img class='flag' src='public/img/semFoto.jpg'>" .$user->getNome();
                                if ($obj->getIsSubmissor()==1) echo "(Submissor)";


                            }
                        ?>
                    </ul>
                <div class="help-inline ">

                </div>
            </div>
        </div>
        <div class="control-group form-actions">
            <div class="row">
                <div class="col-md-3 mb-4">
                <button class="btn btn-lg btn-primary btn-block mb-4" type="submit" onclick="submeterAutores('<?php echo $usuario->getId()?>')">Enviar</button>
                </div>

                <div class="col-md-3 mb-4">
                    <a class="btn btn-lg btn-default  btn-block" onclick="$('#modal').fadeOut(500)">Retornar</a>
                </div>
            </div>
        </div>
    <?php }?>
</div>

            
              
