<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $modalidadeEvento = new ModalidadeEvento();
    $modalidadeEvento = ModalidadeEvento::retornaDadosModalidadeEvento($_GET['id']);
    
    $submissoes = Submissao::listaSubmissoesComFiltro($modalidadeEvento->getIdEvento(), $modalidadeEvento->getIdModalidade(), '', '', '');
    
    $nomeEvento = Evento::retornaDadosEvento($modalidadeEvento->getIdEvento())->getNome();
    $nomeModalidade = Modalidade::retornaDadosModalidade($modalidadeEvento->getIdModalidade())->getDescricao();

?>

<div class="titulo-modal">Excluir Vínculo Modalidade/Evento</div>

<div class="itens-modal">
    
    <?php if (count($submissoes)==0) {?>
        <p align='center'>Deseja realmente excluir a Modalidade <strong><?php echo $nomeModalidade ?></strong> do evento <strong><?php echo $nomeEvento  ?></strong>?</p>
        <div class="div-btn">
            <input type='button' value='Sim' class='btn-verde' onclick="location.href='submissaoForms/wsExcluirModalidadeEvento.php?id=<?php echo $_GET['id']?>'">
            <input type='button' value='Não' class='btn-vermelho' onclick="$('#modal').fadeOut(500)">
        </div>
    <?php }
    
    else {?>
        <p align='center'>O vínculo não pode ser excluído excluída devido às pendências abaixo:</p>
        <?php 
            echo "<p align='center'><strong>Submissoes desta Modalidade (".count($submissoes).")</strong></p>";
            echo "<ul>";
            foreach ($submissoes as $submissao) {
                echo "<li>".$submissao->getTitulo()."</li>";
            }
            echo "</ul>";
    ?>
        
    <?php }?>
    
</div>