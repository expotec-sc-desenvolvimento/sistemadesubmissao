<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página

    $criterio = new Criterio();
    $criterio = Criterio::retornaDadosCriterio($_GET['id']);

    $submissoesDaModalidade = Submissao::listaSubmissoesComFiltro('', $criterio->getIdModalidade(), '', '', $criterio->getIdTipoSubmissao());
    $avaliacoesRealizadas = array();
    
    foreach ($submissoesDaModalidade as $submissao) {
        // Testa se já existem avaliações realizadas para esta modalidade/tiposubmissao
        if (count(Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), 2))) array_push ($avaliacoesRealizadas, $submissao);
    }

?>

<div class="titulo-modal">Excluir Critério</div>

<div class="itens-modal">
    
    <?php if (count($avaliacoesRealizadas)==0) {?>
    <p align='center'>Deseja realmente excluir o critério <strong><?php echo $criterio->getDescricao()?></strong>
        para a modalidade <strong><?php echo Modalidade::retornaDadosModalidade($criterio->getIdModalidade())->getDescricao() ?></strong>?
        
    </p>
        <div class="div-btn">
            <input type='button' value='Sim' class='btn-verde' onclick="location.href='submissaoForms/wsExcluirCriterio.php?id=<?php echo $_GET['id']?>'">
            <input type='button' value='Não' class='btn-vermelho' onclick="$('#modal').fadeOut(500)">
        </div>
    <?php }
    
    else {?>
        <p align='center'>O critério <strong><?php echo $criterio->getDescricao() ?></strong> não pode ser excluído devido às pendências abaixo:</p>
        <?php 
            // CONTINUAR DAQUI
            
            echo "<p align='center'><strong>Submissões com pelo menos 1 avaliação já realizada (".count($avaliacoesRealizadas).")</strong></p>";
            echo "<ul style='margin-left: 30px;'>";
            foreach ($avaliacoesRealizadas as $obj) {
                echo "<li>";
                echo "<strong>Trabalho: </strong>" . $obj->getTitulo();
                echo "</li>";
            }
            echo "</ul>";
    }
            
    ?>
        
    
</div>