<?php
    
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
    $situacaoSubmissao = "";
    
    $contAp=0; $contApRes=0; $contRep=0;
    foreach (Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), '') as $aval) {
        if ($aval->getIdSituacaoAvaliacao()==4) $contAp++;
        else if ($aval->getIdSituacaoAvaliacao()==5) $contApRes++;
        else if ($aval->getIdSituacaoAvaliacao()==6) $contRep++;
    }
    if ($contAp>=2) $situacaoSubmissao = "Aprovado(a)";
    else if ($contRep>=2) $situacaoSubmissao = "Reprovado(a)";
    else $situacaoSubmissao = "Aprovado(a) com Ressalvas";
?>

<div class="titulo-modal">Finalizar Submissão</div>

<div class="itens-modal">
    
    <p align="center">A Submissão <strong><?php echo TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao()?></strong> do Trabalho 
                    <strong><?php echo $submissao->getTitulo() ?></strong> será finalizada com a situação <strong><?php echo $situacaoSubmissao?></strong>. Deseja continuar?</p>
    
    <div class="div-btn">
        <input type='button' value='Sim' class='btn-verde' onclick="location.href='submissaoForms/wsFinalizarSubmissao.php?id=<?php echo $_GET['id']?>'">
            <input type='button' value='Não' class='btn-vermelho' onclick="$('#modal').fadeOut(500)">
    </div>>



</div>