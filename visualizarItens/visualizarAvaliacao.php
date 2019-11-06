<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    $avaliacao = Avaliacao::retornaDadosAvaliacao($_GET['id']);
    $submissao = Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao());
    if ($avaliacao->getId()=="") header('Location: ./paginaInicial.php');
    
    $perfilUsuario = Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao();
    
    if ($perfilUsuario!="Administrador" && $avaliacao->getIdUsuario()!=$usuario->getId()) header('Location: ./paginaInicial.php');

    
?>

<div class="titulo-modal">Visualizar Avaliação</div>


<div class="itens-modal">
    <?php 
        if (SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao() == "Pendente") {
            echo "<p align='center'>Avaliação ainda não realizada</p>";
        }
        else {
            $user = UsuarioPedrina::retornaDadosUsuario($avaliacao->getIdUsuario());
            $nomeCompleto = $user->getNome();
            $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao();
            $avaliacaoCriterios = AvaliacaoCriterio::retornaCriteriosParaAvaliacao($avaliacao->getId());
        ?>
    
            
            <table align='center' border=1 class='table_list'>
                <tr><th style="width: 10px">Nome do Avaliador:</th><td id='listaAvaliacoes'><?php echo $nomeCompleto ?></td>
                <tr><th>Situação da Avaliação:</th><td id='listaAvaliacoes'><?php echo $situacaoAvaliacao ?></td>
                <tr><th>Avaliação:</th><td style='text-align:left; padding-left:10px;'>
            
            
        <?php
            foreach ($avaliacaoCriterios as $avaliacaoCriterio) {
                $criterio = Criterio::retornaDadosCriterio($avaliacaoCriterio->getIdCriterio());
                if ($submissao->getIdTipoSubmissao()==3) echo "<p style='white-space:pre-line;text-align=justify'>" . $criterio->getDescricao() ."(" .$criterio->getPeso().") - <b>" . $avaliacaoCriterio->getNota() . "</b></p><br>";
		else {
			echo "<p style='white-space:pre-line;text-align=justify'>" . $criterio->getDescricao() ." - <b>";
		        if ($avaliacaoCriterio->getNota()==1) echo  "Sim</b></p><br>";
		else echo "Não</i></p><br>";
		}
	    }
        ?>
                <?php // 1 - Parcial / 2 - Corrigida / 3 - Final 
                if ($submissao->getIdTipoSubmissao()==3) {
                    echo "<br><strong> Nota Final: ".$avaliacao->getNota()."<strong></td>";
                }
                ?>
                </td>
                <tr><th>Observações:</th><td id='listaAvaliacoes'><p style='white-space:pre-line;text-align:justify;'> <?php echo $avaliacao->getObservacao() ?></p></td></tr>
            </table>
        <?php } ?>
    </div>
