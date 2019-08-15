<?php
    //include dirname(__FILE__)
    include dirname(__DIR__) . './inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $avaliacao = new Avaliacao();
    $submissao = new Submissao();
    $avaliacao = Avaliacao::retornaDadosAvaliacao($_GET['id']);
    $submissao = Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao());
    
    $avaliadorArea = 'outra-area';
    if (count(Avaliador::listaAvaliadoresComFiltro($submissao->getIdEvento(), $submissao->getIdArea(), $avaliacao->getIdUsuario(), 'area'))>0) $avaliadorArea = 'area';
    
?>

<div class="titulo-modal">Editar Avaliação</div>

<div class="itens-modal">
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAtualizarAvaliacao.php');?>">
        <input type="hidden" id="idAvaliacao" name="idAvaliacao" value="<?php echo $avaliacao->getId() ?>">
        <table class='cadastroItens-2'>
            <tr>
                <th class='direita'>Evento: </th>
                <td colspan="2"><input type=hidden name="evento" id="evento" readonly="true" value="<?php echo $submissao->getIdEvento() ?>">
                        <?php echo Evento::retornaDadosEvento($submissao->getIdEvento())->getNome()?>
                <td>
            </tr>
            <tr>
                <th class='direita'>Área: </th>
                <td colspan="2"><input type=hidden name="area" id="area" readonly="true" value="<?php echo $submissao->getIdArea() ?>">
                    <?php echo Area::retornaDadosArea($submissao->getIdArea())->getDescricao()?>
                <td>
            </tr>
            <tr>
                <th class='direita'>Situação: </th>
                <td colspan="2">
                    <?php echo SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao()?>
                <td>
            </tr>
            <tr>
                <th class='direita'>Avaliador: </th>
                <td><select class='campoDeEntrada' id="novoAvaliador" name="novoAvaliador" required="true"></select>
                <td>
                <td><input id="area" type="checkbox" checked="false" onchange="var x = this.checked ? 'area' : 'outra-area'; loadAvaliadores('',
                                                                                                                   <?php echo $submissao->getId() ?>,
                                                                                                                   <?php echo $submissao->getIdEvento() ?>,
                                                                                                                   <?php echo $submissao->getIdArea() ?>,
                                                                                                                   x,
                                                                                                                   'novoAvaliador')">Avaliador da Área</td>
            </tr>
            <tr>
                <th class='direita'>Prazo: </th>
                <td colspan="2">
                    <input class='campoDeEntrada' type='date' id='prazo' name='prazo' value='<?php echo $avaliacao->getPrazo() ?>'>
                <td>
            </tr>
        </table>
        <div class='div-btn'><input type="submit" class='btn-verde' value="Alterar Avaliação"><input type='button' value='Fechar' class='btn-vermelho' onclick="$('#modal').fadeOut(500)"></div>
    </form>
            

                
                
</div>
    <?php if ($avaliadorArea=='area') {?> 
        <script type='text/javascript'>
            document.getElementById('area').checked="true";
            loadAvaliadores(<?php echo $avaliacao->getIdUsuario() ?>,
                            <?php echo $submissao->getId() ?>,
                            <?php echo $submissao->getIdEvento() ?>,
                            <?php echo $submissao->getIdArea() ?>,
                            'area',
                            'novoAvaliador');
            
        </script>
    <?php } else { ?>
        <script type='text/javascript'>
            loadAvaliadores(<?php echo $avaliacao->getIdUsuario() ?>,
                                <?php echo $submissao->getId() ?>,
                                <?php echo $submissao->getIdEvento() ?>,
                                <?php echo $submissao->getIdArea() ?>,
                                'outra-area',
                                'novoAvaliador');
        </script>
    <?php } ?>
