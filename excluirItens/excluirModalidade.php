<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página


    $listaEventosDaModalidade = ModalidadeEvento::listaModalidadeEventoComFiltro($_GET['id'], '');
    $listaCriteriosParciaisDaModalidade = Criterio::listaCriteriosComFiltro($_GET['id'], 1);
    $listaCriteriosFinaisDaModalidade = Criterio::listaCriteriosComFiltro($_GET['id'], 2);
    
    $pendencias = count($listaEventosDaModalidade)+count($listaCriteriosParciaisDaModalidade)+ count($listaCriteriosFinaisDaModalidade);
    $nome = Modalidade::retornaDadosModalidade($_GET['id'])->getDescricao();
?>

<div class="titulo-modal">Excluir Usuário</div>

<div class="itens-modal">
    
    <?php if ($pendencias==0) {?>
        <p align='center'>Deseja realmente excluir a Modalidade <strong><?php echo $nome  ?>?</strong></p>
        <div class="div-btn">
            <input type='button' value='Sim' class='btn-verde' onclick="location.href='submissaoForms/wsExcluirModalidade.php?id=<?php echo $_GET['id']?>'">
            <input type='button' value='Não' class='btn-vermelho' onclick="$('#modal').fadeOut(500)">
        </div>
    <?php }
    
    else {?>
        <p align='center'>A Modalidade <strong><?php echo $nome ?></strong> não pode ser excluída devido às pendências abaixo:</p>
        <?php 
            if (count($listaEventosDaModalidade)>0) {
                echo "<p align='center'><strong>Eventos desta Modalidade (".count($listaEventosDaModalidade).")</strong></p>";
                echo "<ul style='margin-left: 30px;'>";
                foreach ($listaEventosDaModalidade as $obj) {
                    echo "<li>";
                    echo "<strong>Evento: </strong>" . Evento::retornaDadosEvento($obj->getIdEvento())->getNome();
                    echo "</li>";
                }
                echo "</ul>";
            }
            if (count($listaCriteriosParciaisDaModalidade)>0) {
                echo "<p align='center'><strong>Critérios Parciais desta Modalidade (".count($listaCriteriosParciaisDaModalidade).")</strong></p>";
                echo "<ul style='list-style-type:none; margin-left: 30px;'>";
                foreach ($listaCriteriosParciaisDaModalidade as $obj) {
                    echo "<li>";
                    echo "<strong>Critério: </strong>" .$obj->getDescricao();
                    echo "</li>";
                }
                echo "</ul>";
            }
            if (count($listaCriteriosFinaisDaModalidade)>0) {
                echo "<p align='center'><strong>Critérios Finais desta Modalidade (".count($listaCriteriosFinaisDaModalidade).")</strong></p>";
                echo "<ul style='list-style-type:none; margin-left: 30px;'>";
                foreach ($listaCriteriosFinaisDaModalidade as $obj) {
                    echo "<li>";
                    echo "<strong>Critério: </strong>" .$obj->getDescricao();
                    echo "</li>";
                }
                echo "</ul>";
            }
    ?>
        
    <?php }?>
    
</div>