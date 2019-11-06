<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página


    $listaAreasDoEvento = AreaEvento::listaAreaEventoComFiltro('', $_GET['id']);
    $listaModalidadesDoEvento = ModalidadeEvento::listaModalidadeEventoComFiltro('', $_GET['id']);

    $pendencias = count($listaAreasDoEvento)+ count($listaModalidadesDoEvento);
      
    $nome = Evento::retornaDadosEvento($_GET['id'])->getDescricao();
?>

<div class="titulo-modal">Excluir Evento</div>

<div class="itens-modal">
    
    <?php if ($pendencias==0) {?>
        <p align='center'>Deseja realmente excluir o Evento <strong><?php echo $nome  ?>?</strong></p>
        <div class="div-btn">
            <input type='button' value='Sim' class='btn-verde' onclick="location.href='submissaoForms/wsExcluirEvento.php?id=<?php echo $_GET['id']?>'">
            <input type='button' value='Não' class='btn-vermelho' onclick="$('#modal').fadeOut(500)">
        </div>
    <?php }
    
    else {?>
        <p align='center'>O evento <strong><?php echo $nome ?></strong> não pode ser excluído devido às pendências abaixo:</p>
        <?php 
            if (count($listaAreasDoEvento)>0) {
                echo "<p align='center'><strong>Áreas vinculadas a este evento (".count($listaAreasDoEvento).")</strong></p>";
                echo "<ul style='margin-left: 30px;'>";
                foreach ($listaAreasDoEvento as $obj) {
                    echo "<li>";
                    echo "<strong>Área: </strong>" . Area::retornaDadosArea($obj->getIdArea())->getDescricao();
                    echo "</li>";
                }
                echo "</ul>";
            }
            if (count($listaModalidadesDoEvento)>0) {
                echo "<p align='center'><strong>Áreas vinculadas a este evento (".count($listaModalidadesDoEvento).")</strong></p>";
                echo "<ul style='list-style-type:none; margin-left: 30px;'>";
                foreach ($listaModalidadesDoEvento as $obj) {
                    echo "<li>";
                    echo "<strong>Modalidade: </strong>" . Modalidade::retornaDadosModalidade($obj->getIdModalidade())->getDescricao();
                    echo "</li>";
                }
                echo "</ul>";
            }
    ?>
        
    <?php }?>
    
</div>