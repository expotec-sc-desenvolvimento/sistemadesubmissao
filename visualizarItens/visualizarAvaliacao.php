<?php
    include dirname(__DIR__) . '../inc/includes.php';
    
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
            $user = Usuario::retornaDadosUsuario($avaliacao->getIdUsuario());
            $nomeCompleto = $user->getNome() . " " . $user->getSobrenome();
            $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao();
            $avaliacaoCriterios = AvaliacaoCriterio::retornaCriteriosParaAvaliacao($avaliacao->getId());
        ?>
    
            
            <table align='center' border=1 class='table_list'>
                <tr><th>Nome do Avaliador:</th><td align='center'><?php echo $nomeCompleto ?></td>
                <tr><th>Situacao da Avaliação:</th><td><?php echo $situacaoAvaliacao ?></td>
                <tr><th>Avaliação:</th><td>
            
            
        <?php
            foreach ($avaliacaoCriterios as $avaliacaoCriterio) {
                $criterio = Criterio::retornaDadosCriterio($avaliacaoCriterio->getIdCriterio());
                if ($submissao->getArquivo()==3) echo $criterio->getDescricao() ."(" .$criterio->getPeso().") - <i>" . $avaliacaoCriterio->getNota() . "</i><br>";
                else echo $criterio->getDescricao() ." - <i>" . $avaliacaoCriterio->getNota() . "</i><br>";
            }
        ?>
                <?php // 1 - Parcial / 2 - Corrigida / 3 - Final 
                if ($submissao->getIdTipoSubmissao()==3) {
                    echo "<br><strong> Nota Final: ".$avaliacao->getNota()."<strong></td>";
                }
                ?>
                </td>
                <tr><th>Observações:</th><td><?php echo $avaliacao->getObservacao() ?></td></tr>
            </table>
        <?php } ?>
    </div>