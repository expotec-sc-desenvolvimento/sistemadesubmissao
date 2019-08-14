<?php

    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');
    
    if (isset($_GET['id'])) {
        $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
        if ($submissao->getId()!="" || $submissao->getNota()==NULL) {
            
            $mediaAprovacao = Evento::retornaDadosEvento($submissao->getIdEvento())->getMediaAprovacaoTrabalhos();
            $situacao = 0;
            
            if ($submissao->getNota()>=$mediaAprovacao) $situacao = 4; //APROVADO
            else $situacao = 5; // REPROVADO;
            
            if (Submissao::finalizarSubmissao($submissao->getId(),$situacao)) {
                header("Location: ../gerenciarSubmissoes.php?Item=Atualizado");
            }
            else header("Location: ../gerenciarSubmissoes.php?Item=NaoAtualizado");
            
        }
        else echo "<script>window.alert('Submissão Inválida para finalização!');window.history.back();</script>";
    }
    else echo "<script>window.alert('Submissão Inválida!');window.history.back();</script>";
?>