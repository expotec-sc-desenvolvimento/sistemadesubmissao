<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    // echo $_GET['idEvento'] . " " . $_GET['idTipoAvaliacao'] . " " . $_GET['avArea'] . " " . $_GET['avOutraArea'];
?>

<div class="titulo-modal">Verificar Distribuição</div>


<div class="itens-modal">
    <?php
        
        $submissoes = Submissao::listaSubmissoesComFiltro($_GET['idEvento'], '', '', 1, $_GET['idTipoAvaliacao']);

        if (count($submissoes)==0) echo "<p align='center'><strong>Não existem submissões com esses filtros ou todas as submissões possuem avaliadores</strong></p>";
        else {?>
            <h3 align="center">Situação da distribuição com esses filtros</h3>
            <table class="table_list" align="center" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Trabalho</th>
                        <th>Área</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($submissoes as $submissao) {
                            $situacao = "";
                            $listaAvaliadoresArea = Usuario::listaAvaliadoresParaCadastro($submissao->getIdEvento(),$submissao->getIdArea(),'mesma-area',2,$submissao->getId());
                            $listaAvaliadoresOutraArea = Usuario::listaAvaliadoresParaCadastro($submissao->getIdEvento(),$submissao->getIdArea(),'outra-area',1,$submissao->getId());

                            if (count($listaAvaliadoresArea)>=2 && count($listaAvaliadoresOutraArea)>=1) $situacao = "<img class='img-miniatura' src='".$iconOK."' title='Há avaliadores suficientes'>";
                            else $situacao = "<img class='img-miniatura' src='".$iconExcluir."' title='Sem avaliadores suficientes'>";
                            ?>
                    <tr>
                        <td><?php echo $submissao->getTitulo() ?></td>
                        <td><?php echo Area::retornaDadosArea($submissao->getIdArea())->getDescricao() ?></td>
                        <td><?php echo $situacao ?></td>
                    </tr>
                       <?php }
                    ?>
                </tbody>

            </table>
            <form method="post" action="<?=htmlspecialchars('submissaoForms/wsDitribuirAvaliacoes.php');?>">
                <input type="hidden" name="select-Eventos" value="<?php echo $_GET['idEvento'] ?>">
                <input type="hidden" name="select-tipoAvaliacao" value="<?php echo $_GET['idTipoAvaliacao'] ?>">
                <div class="div-btn">
                    <input class="btn-verde" type="submit" value="Distribuir Avaliadores" onclick="return confirm('Confirma a Distribuição dos Avaliadores?')">
                    <input class="btn-vermelho" type="button" value="Fechar" onclick="$('#modal').fadeOut(500)">
                </div>    
            </form>

        <?php }
        
    ?>
</div>    