<?php

    include dirname(__FILE__) . './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
    
    
    // Caso a submissão seja invalida...
    if ($submissao->getId()=="" ) header('Location: ./paginaInicial.php');
    
    // Caso o usuário não seja administrador e não seja usuário da submissão
    if (count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), $usuario->getId(), ''))==0 
            && Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao()!="Administrador") header('Location: ./paginaInicial.php');
    
        
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Visualizar Submissao</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>


    </head>
    
    <body>
        
        <?php include './inc/menuInicial.php';?>
        
         <fieldset>
            <h3 align='center'>Dados da Submissão</h3>
            
            <table align='center'>
                <tr><td><strong>Tipo de Submissao:</strong></td><td><?php echo TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao()?></td></tr>
                <tr><td><strong>Titulo:</strong></td><td><?php echo $submissao->getTitulo()?></td></tr>
                <tr><td><strong>Área:</strong></td><td><?php echo Area::retornaDadosArea($submissao->getIdArea())->getDescricao()?></td></tr>
                <tr><td><strong>Modalidade:</strong></td><td><?php echo Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao()?></td></tr>
                <tr><td><strong>Palavras chave:</strong></td><td><?php echo $submissao->getPalavrasChave()?></td></tr>
                <tr><td><strong>Nota Final:</strong></td><td><?php echo $submissao->getNota() == null ? "-" : $submissao->getNota() ?></td></tr>
                <tr><td><strong>Resumo:</strong></td><td><textarea rows="20" cols="40" readonly="true"><?php echo $submissao->getResumo()?></textarea></td></tr>
                <tr><td><strong>Autores:</strong></td><td>
                <?php
                    foreach(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '') as $obj) {
                        $user = Usuario::retornaDadosUsuario($obj->getIdUsuario());
                        echo $user->getNome() . " " , $user->getSobrenome();
                        if ($obj->getIsSubmissor()==1) echo "(Submissor)";
                        echo "<br>";
                    }
                ?>
                        </td></tr>
            </table>
            <h3 align='center'>Dados das Avaliações</h3>
            
            <?php
                $avaliacoes = Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(),'');
                
                if (count($avaliacoes)==0) {
                    echo "<h3 align='center'>Nenhuma Avaliação cadastrada para a Submissão</h3>";
                }
                
                $cont = 1;
                foreach ($avaliacoes as $avaliacao) {
                    $user = Usuario::retornaDadosUsuario($avaliacao->getIdUsuario());
                    $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao());
                    
                    $nomeCompleto = "AVALIADOR $cont";
                    $cont++;
                    if (Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao() == "Administrador") $nomeCompleto = $user->getNome() . " " . $user->getSobrenome();
                    
                    echo "<table align='center' border=1>"
                        ."<tr><td><strong>Nome do Avaliador:</strong></td><td align='center'>" . $nomeCompleto . "</td>"
                        ."<tr><td><strong>Situacao da Avaliação:</strong></td><td>" . $situacaoAvaliacao->getDescricao() . "</td>";
                        
                    
                    // Situação 4 - Aprovado, 5 - Aprovado Com Ressalvas, 6 - Reprovado(a) 
                    if (in_array($situacaoAvaliacao->getId(), array('4','5','6'))) {
                        
                        echo "<tr><td><strong>Avaliação: </strong></td><td>";
                        $avaliacaoCriterios = AvaliacaoCriterio::retornaCriteriosParaAvaliacao($avaliacao->getId());
                        
                        foreach ($avaliacaoCriterios as $avaliacaoCriterio) {
                            $criterio = Criterio::retornaDadosCriterio($avaliacaoCriterio->getIdCriterio());
                            echo $criterio->getDescricao() ."(" .$criterio->getPeso().") - ";
                            if ($submissao->getIdTipoSubmissao()==3) echo "<i>" . $avaliacaoCriterio->getNota() . "</i><br>";
                            else echo $avaliacaoCriterio->getNota()==1 ? "<i>Sim</i><br>" : "<i>Não</i><br>";
                        }
                        if ($submissao->getIdTipoSubmissao()==3) echo "<br>Nota Final: <strong>". $avaliacao->getNota()."</strong></td>";
                        echo "<tr><td><strong>Observações:</strong></td><td>" . $avaliacao->getObservacao() . "</td></tr>";
                    }
                    if ($situacaoAvaliacao->getDescricao()=="Pendente" && Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao() == "Administrador") {
                        echo "<tr><td colspan='2' align='center'><a href='alterarAvaliador.php?id=".$avaliacao->getId()."'>Alterar Avaliador</a></td></tr>";
                    }
                    echo "</table><br>";
                }
    
            ?>
         </fieldset>
        
    </body>
</html>