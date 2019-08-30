<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página

    $avaliador = Avaliador::retornaDadosAvaliador($_GET['id']);
    
    
    $avaliacoes = Avaliacao::listaAvaliacoesComFiltro($avaliador->getIdUsuario(), '', '');
    
    $avParciais = array();
    $avFinais = array();
    
    foreach ($avaliacoes as $avaliacao) {
        $submissao = Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao());
        if ($submissao->getIdArea() == $avaliador->getIdArea() && $submissao->getIdEvento() == $avaliador->getIdEvento()) {
            if (TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao()=="Parcial") array_push($avParciais, $submissao);
            else array_push($avFinais, $submissao);
        }
    }
      
    $pendencias = count($avParciais)+ count($avFinais);

    $nome = Usuario::retornaDadosUsuario($avaliador->getIdUsuario())->getNome();
    $area = Area::retornaDadosArea($avaliador->getIdArea())->getDescricao();
    $evento = Evento::retornaDadosEvento($avaliador->getIdEvento())->getNome();
?>

<div class="titulo-modal">Excluir Avaliador</div>

<div class="itens-modal">

    
    <?php if ($pendencias==0) {?>
        <p align='center'>Deseja realmente excluir o vinculo de Avaliador <strong><?php echo $nome  ?></strong> da Área/Evento <strong><?php echo $area."/".$evento  ?>?</strong></p>
        <div class="div-btn">
            <input type='button' value='Sim' class='btn-verde' onclick="location.href='submissaoForms/wsExcluirAvaliador.php?id=<?php echo $_GET['id']?>'">
            <input type='button' value='Não' class='btn-vermelho' onclick="$('#modal').fadeOut(500)">
        </div>
    <?php }
    
    else {?>
        <p align='center'>O vínculo do avaliador <strong><?php echo $nome ?></strong> não pode ser excluído devido às pendências abaixo:</p>
        <?php 
            if (count($avParciais)>0) {
                echo "<p align='center'><strong>Avaliações Parciais atribuidas (".count($avParciais).")</strong></p>";
                echo "<ul>";
                foreach ($avParciais as $obj) {
                    echo "<li>";
                    echo "<strong>Trabalho: </strong>" . $obj->getTitulo();
                    echo "</li>";
                }
                echo "</ul>";
            }
            if (count($avFinais)>0) {
                echo "<p align='center'><strong>Avaliações Finais atribuidas (".count($avFinais).")</strong></p>";
                echo "<ul>";
                foreach ($avFinais as $obj) {
                    echo "<li>";
                    echo "<strong>Trabalho: </strong>" . $obj->getTitulo();
                    echo "</li>";
                }
                echo "</ul>";
            }
    ?>
        
    <?php }?>
    
</div>