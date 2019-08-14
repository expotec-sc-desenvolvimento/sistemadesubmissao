<?php

    include dirname(__FILE__) . './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
 //   verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    $avaliacao = new Avaliacao();
    $avaliacao = Avaliacao::retornaDadosAvaliacao($_GET['id']);
    
    /* Caso a avaliação não exista ou o usuário que tenta acessar essa avaliação não é o usuário para qual a avaliação está vinculada,
       o usuário é redirecionado para a página inicial*/ 
    if ($avaliacao->getId()=="" || ($avaliacao->getIdUsuario() != $usuario->getId())) header('Location: paginaInicial.php');
    
    $readonly = "";
    if (SituacaoSubmissao::retornaDadosSituacaoSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdSituacaoSubmissao())->getDescricao()!="Em avaliacao") {
        $readonly = " disabled";
    }    
        
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Realizar Avaliação</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>
    </head>
    
    <body>
        
        <?php include './inc/menuInicial.php';?>
       
        
        <fieldset>
            <h2 align="center">Realizar Avaliação</h2>
            <br>
            
            <form method="post" action="<?=htmlspecialchars('submissaoForms/wsRealizarAvaliacao.php');?>" >
                <input type="hidden" id="idAvaliacao" name="idAvaliacao" value="<?php echo $avaliacao->getId() ?>" >
            <?php
            
                $submissao = new Submissao();
                $submissao = Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao());
                
                $avaliacaoCriterios = AvaliacaoCriterio::retornaCriteriosParaAvaliacao($avaliacao->getId());
                
                $nota = "-";
                if ($avaliacao->getNota()!=null) $nota = $avaliacao->getNota ();
                
                echo "<table align='center'";
                echo "  <tr><td><strong>Título: </strong></td><td>" . $submissao->getTitulo() . "</td></tr>";
                echo "  <tr><td><strong>Modalidade: </strong></td><td>" . $submissao->getIdModalidade() . "</td></tr>";
                echo "  <tr><td><strong>Resumo: </strong></td><td>" . $submissao->getResumo() . "</td></tr>";
                echo "  <tr><td><strong>Palavras Chave: </strong></td><td>" . $submissao->getPalavrasChave() . "</td></tr>";
                echo "  <tr><td><strong>Arquivo: </strong></td><td><a href='" . $pastaSubmissoes . $submissao->getArquivo() . "'>Visualizar</a></td></tr>";
                echo "  <tr><td><strong>Nota: </strong></td><td>".$nota."</td></tr>";
                
                echo "</table>";
                
                echo "<h3 align='center'>Avaliar Trabalho</h3>";
                //echo count($criterios);
                
                echo "<table border=1 align='center'>"
                    ."<tr><td align='center'><strong>Descricao do Critério</strong></td>"
                    ."<td align='center'><strong>Nota</strong></td>"
                    ."<td align='center'><strong>Detalhes<br>do Critério</strong></td>"
                    ."<td align='center'><strong>Peso</strong></td></tr>";
                
                foreach ($avaliacaoCriterios as $avaliacaoCriterio ) {
                    $criterio = new Criterio();
                    $criterio = Criterio::retornaDadosCriterio($avaliacaoCriterio->getIdCriterio());
                    
                    echo "
                          <input type='hidden' id='".$avaliacaoCriterio->getId()."' name='".$avaliacaoCriterio->getId()."' value='".$avaliacaoCriterio->getNota()."'>";
                    echo "<tr><td>" . $criterio->getDescricao() . "</td>"
                            ."<td><select required='true' onchange=\"document.getElementById('".$avaliacaoCriterio->getId()."').value=this.value\"".$readonly.">
                            .       <option value=''>-</option>";
                    
                    for ($i=50;$i<=100;$i=$i+5) {
                        $selected = "";
                        if ($avaliacaoCriterio->getNota() == $i) $selected = " selected";
                        echo "<option value='".$i."'".$selected.">".$i."</option>";
                    }
                    echo "</td>";
                    echo "<td align='center'>".$criterio->getDetalhamento()."</td>";
                    echo "<td align='center'>".$criterio->getPeso()."</td>";
                }
                echo "</table><br>";
                
                echo "<table align='center'>"
                . "<tr><td>Observações: </td>"
                . "<td><textarea id='observacao' name='observacao' cols='30' rows='5'".$readonly.">". $avaliacao->getObservacao()."</textarea>"
                . "</td></tr></table>";
                
                if ($readonly=="") {
                ?>
                <p align='center'><input type='submit' value='Enviar Avaliacao'></p>
                <?php }?>
            </form>
        </fieldset>
    </body>
</html>