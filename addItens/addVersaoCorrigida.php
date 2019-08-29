<?php

include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
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
    //echo $dataAtual . " - " . $dataFinalEnvioSubmissaoCorrigida;
    if (strtotime($dataAtual) > strtotime($dataFinalEnvioSubmissaoCorrigida)) $prazoEsgotado = true;
    if (count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), $usuario->getId(), 1))==0) $userNaoSubmissor = true;
    
    $submissores="";
    
    foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '') as $submissor) {
        $submissores .= $submissor->getIdUsuario().";";
    }
    
?>

<div class="titulo-modal">Enviar Versão Corrigida</div>


<div class="itens-modal">
    
    <?php
    
    if ($userNaoSubmissor) echo "<p align='center'>Apenas o usuário Submissor pode realizar esta Operação</p>";
    else if ($prazoEsgotado) echo "<p align='center'>O prazo para envio da Versão corrigida foi excedido. Prazo Final: <strong>".date('d/m/Y',strtotime($dataFinalEnvioSubmissaoCorrigida))."</strong></p>";
    
    
    else { ?>
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEnviarSubmissaoCorrigida.php');?>" enctype="multipart/form-data">
    <input type="hidden" id="idSubmissao" name="idSubmissao" value="<?php echo $submissao->getId() ?>">
    <input type="hidden" id="idUsuariosAdd" name="idUsuariosAdd" value="<?php echo $submissores ?>">

        <table class="cadastroItens-2">
            <tr><th></th><td><h2 align="center">Dados do Evento</h2></td></tr>
            <tr>
                <th class="direita">Evento: </th>
                <td>
                    <input type='hidden' id="select-Eventos" name="select-Eventos" value="<?php echo $evento->getId()?>">
                    <input class='campoDeEntrada' readonly="readonly" value="<?php echo $evento->getNome() ?>">
                </td>
            </tr>
            <tr>
                <th class="direita">Área: </th>
                <td>
                    <input type='hidden' id="select-Areas" name="select-Areas" value="<?php echo $area->getId()?>">
                    <input class='campoDeEntrada' readonly="readonly" value="<?php echo $area->getDescricao() ?>">
                </td>
            </tr>
            <tr>
                <th class="direita">Modalidade: </th>
                <td>
                    <input type='hidden' id="select-Modalidades" name="select-Modalidades" value="<?php echo $modalidade->getId()?>">
                    <input class='campoDeEntrada' readonly="readonly" value="<?php echo $modalidade->getDescricao() ?>">
                </td>
            </tr>
            <tr><th></th><td><h2 align="center">Dados do Trabalho</h2></td></tr>
            <tr>
                <th class='direita'>Título: </th>
                <td><input class="campoDeEntrada" id="titulo" name="titulo" required="true" value="<?php echo $submissao->getTitulo() ?>"></td>
            </tr>
            <tr>
                <th class='direita'>Resumo: </th>
                <td><textarea class="campoDeEntrada" id="resumo" name="resumo" rows="10" required="true"><?php echo $submissao->getResumo() ?></textarea></td>
            </tr>
            <tr>
                <th class='direita'>Palavras-chave: </th>
                <td><input class="campoDeEntrada" id="palavrasChave" name="palavrasChave" required="true" value="<?php echo $submissao->getPalavrasChave()?>"></td>
            </tr>
            
                <tr>
                    <th class='direita'>Relação com: </th>
                    <td>
                        <input type="radio" id="relacaoCom" name="relacaoCom" value="TCC" <?php if ($submissao->getRelacaoCom()=="TCC") echo " checked" ?> disabled="true">TCC
                        <input type="radio" id="relacaoCom" name="relacaoCom" value="PI" <?php if ($submissao->getRelacaoCom()=="PI") echo " checked"?> disabled="true">PI
                        <input type="radio" id="relacaoCom" name="relacaoCom" value="-" <?php if ($submissao->getRelacaoCom()=="-") echo " checked"?> disabled="true">Nenhuma das Alternativas
                    </td>
                </tr>

            <tr>
                <th class='direita'>Download: </th>
                <td><input class="campoDeEntrada" type="file" id="arquivo" name="arquivo" required="true"></td>
            </tr>

            <tr>
                <th class='direita'>Submissores: </th>
                <td>
                    <?php 
                        foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '') as $usuarioSubmissao) {
                            $user = Usuario::retornaDadosUsuario($usuarioSubmissao->getIdUsuario());
                            echo $user->getNome() . "<img src='" . $iconOK. "' class='img-miniatura'>";
                        }
                    ?>
                    
                </td>
            </tr>
            
        </table>
        <div class="div-btn"><input type='submit' class='btn-verde' value='Enviar Submissão Corrigida' onclick="submeterAutores('<?php echo $usuario->getId()?>')"></div>
    </form>       
<?php }?>
    
    </div>    