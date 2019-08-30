<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página

    
    $listaAvaliacoesDoUsuario = Avaliacao::listaAvaliacoesComFiltro($_GET['id'], '', '');
    $listaSolicitacoesAvaliadorDoUsuario = SolicitacaoAvaliador::listaSolicitacaoAvaliadorComFiltro($_GET['id'], '', '', '');
    $listaSubmissoesDoUsuario = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro('', $_GET['id'], '');
    $listaAreasEventosAvaliacaoDoUsuario = Avaliador::listaAvaliadoresComFiltro('', '', $_GET['id'], '');
    
    $pendencias = count($listaAvaliacoesDoUsuario)+count($listaSolicitacoesAvaliadorDoUsuario)+count($listaSubmissoesDoUsuario)+ count($listaAreasEventosAvaliacaoDoUsuario);
    

    
    $nome = Usuario::retornaDadosUsuario($_GET['id'])->getNome();
?>
<div class="titulo-modal">Excluir Usuário</div>

<div class="itens-modal">
    
    <?php if ($pendencias==0) {?>
        <p align='center'>Deseja realmente excluir o usuário <strong><?php echo $nome ?>?</strong></p>
        <div class="div-btn">
            <input type='button' value='Sim' class='btn-verde' onclick="location.href='submissaoForms/wsExcluirUsuario.php?id=<?php echo $_GET['id']?>'">
            <input type='button' value='Não' class='btn-vermelho' onclick="$('#modal').fadeOut(500)">
        </div>
    <?php }
    
    else {?>
        <p align='center'>O usuário <strong><?php echo $nome ?></strong> não pode ser excluído devido às pendências abaixo:</p>
        <?php 
            if (count($listaAvaliacoesDoUsuario)>0) {
                echo "<p align='center'><strong>Avaliações vinculadas (".count($listaAvaliacoesDoUsuario).")</strong></p>";
                echo "<ul>";
                foreach ($listaAvaliacoesDoUsuario as $obj) {
                    echo "<li>";
                    echo "<strong>Trabalho: </strong>" . Submissao::retornaDadosSubmissao($obj->getIdSubmissao())->getTitulo();
                    echo "</li>";
                }
                echo "</ul>";
            }
            
            if (count($listaSolicitacoesAvaliadorDoUsuario)>0) {
                echo "<p align='center'><strong>Solicitações para Avaliador de Área/Evento (".count($listaSolicitacoesAvaliadorDoUsuario).")</strong></p>";
                echo "<ul>";
                foreach ($listaSolicitacoesAvaliadorDoUsuario as $obj) {
                    echo "<li>";
                    echo "<strong>Evento: </strong>" . Evento::retornaDadosEvento($obj->getIdEvento())->getNome() . " / ";
                    echo "<strong>Área: </strong>" . Area::retornaDadosArea($obj->getIdArea())->getDescricao();
                    echo "</li>";
                }
                echo "</ul>";
            }
            if (count($listaSubmissoesDoUsuario)>0) {
                echo "<p align='center'><strong>Submissões do Usuário (".count($listaSubmissoesDoUsuario)."): </strong></p>";
                echo "<ul>";
                foreach ($listaSubmissoesDoUsuario as $obj) {
                    $submissao = Submissao::retornaDadosSubmissao($obj->getIdSubmissao());
                    
                    echo "<li>";
                    echo "<strong>Evento: </strong>" . Evento::retornaDadosEvento($submissao->getIdEvento())->getNome() . " / ";
                    echo "<strong>Modalidade: </strong>" . Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao() . " / ";
                    echo "<strong>Trabalho: </strong>" . $submissao->getTitulo();
                    echo "</li>";
                }
                echo "</ul>";
            }
            if (count($listaAreasEventosAvaliacaoDoUsuario)>0) {
                echo "<p align='center'><strong>Avaliador das seguintes Áreas (".count($listaAreasEventosAvaliacaoDoUsuario).") </strong></p>";
                echo "<ul>";
                foreach ($listaAreasEventosAvaliacaoDoUsuario as $obj) {
                    
                    echo "<li>";
                    echo "<strong>Evento: </strong>" . Evento::retornaDadosEvento($obj->getIdEvento())->getNome() . " / ";
                    echo "<strong>Área: </strong>" . Area::retornaDadosArea($obj->getIdArea())->getDescricao();
                    echo "</li>";
                }
                echo "</ul>";
            }
    ?>
        
    <?php }?>
    
</div>