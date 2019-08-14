<?php

    include dirname(__DIR__) . './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"./paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    

    $qtde = 0;
    
    foreach (Submissao::listaSubmissoesComFiltro('', '', '', '', '') as $submissao) {
        if (Submissao::verificarGeracaoNotaFinalSubmissao($submissao->getId())) $qtde+=1;
    }
    
    header('Location: ../gerenciarSubmissoes.php?Item=Atualizado&SubmissoesFinalizadas='.$qtde);
?>