<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $areaEvento = new AreaEvento();
    $areaEvento = AreaEvento::retornaDadosAreaEvento($_GET['id']);
    
    $submissoes = Submissao::listaSubmissoesComFiltro($areaEvento->getIdEvento(), '', $areaEvento->getIdArea(), '', '');
    $avaliadores = Avaliador::listaAvaliadoresComFiltro($areaEvento->getIdEvento(), $areaEvento->getIdArea(), '', 'area');
    
    $nomeEvento = Evento::retornaDadosEvento($areaEvento->getIdEvento())->getNome();
    $nomeArea = Area::retornaDadosArea($areaEvento->getIdArea())->getDescricao();
    
?>

<div class="titulo-modal">Excluir Vínculo Área/Evento</div>

<div class="itens-modal">
    
    <?php if (count($submissoes)==0) {?>
        <p align='center'>Deseja realmente excluir a Área <strong><?php echo $nomeArea  ?></strong> do evento <strong><?php echo $nomeEvento  ?></strong>
            e seus respectivos avaliadores?
        </p>
        <?php 
            if (count($avaliadores)==0) echo "<p align='center'>Nenhum avaliador cadastrado para esta Área/Evento";
            else {
                echo "<p align='center'>Avaliadores desta Área/Evento:";
                "<ul style='margin-left: 30px;'>";
                foreach ($avaliadores as $avaliador) {
                    echo "<li>". UsuarioPedrina::retornaDadosUsuario($avaliador->getIdUsuario())->getNome()."</li>";
                }
                "</ul>";
            }
        ?>
        <div class="div-btn">
            <input type='button' value='Sim' class='btn-verde' onclick="location.href='submissaoForms/wsExcluirAreaEvento.php?id=<?php echo $_GET['id']?>'">
            <input type='button' value='Não' class='btn-vermelho' onclick="$('#modal').fadeOut(500)">
        </div>
    <?php }
    
    else {?>
        <p align='center'>O vínculo não pode ser excluído excluída devido às pendências abaixo:</p>
        <?php 
            echo "<p align='center'><strong>Submissoes desta Área (".count($submissoes).")</strong></p>";
            echo "<ul style='margin-left: 30px;'>";
            foreach ($submissoes as $submissao) {
                echo "<li>".$submissao->getTitulo()."</li>";
            }
            echo "</ul>";
    ?>
        
    <?php }?>
    
</div>