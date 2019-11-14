<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];

    //$submissoesDoUsuario = array (new UsuariosDaSubmissao());
    //$submissao = UsuariosDaSubmissao::retornaSubmissoesDoUsuario($usuario->getId());
    
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    if ($metodoHttp === 'GET') {
        try {
            
            $idSubmissao = $_GET['id'];
            $submissao = Submissao::retornaDadosSubmissao($idSubmissao);
            
            
            if ($submissao->getId()!="") {
                $situacaoSubmissao = SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao());
          
                if ($situacaoSubmissao->getDescricao() == "Submetida") {
                    if (count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($idSubmissao, $usuario->getId(), 1,'','')) == 1) { // Caso o usuário seja o Usuário submissor
                        if (Submissao::cancelarSubmissao($idSubmissao)) {
                            header('Location: ../minhasSubmissoes.php?Item=Cancelado');
                        }
                        else echo "<script>window.alert('Houve um erro na exclusão da Submissao. Contacte um administrador!');window.history.back();</script>";
                    }
                    else echo "<script>window.alert('Você não é o submissor desta Submissão. Apenas o Submissor por excluí-la!');window.history.back();</script>";
                }
                else echo "<script>window.alert('A submissão está com a situacao \"".$situacaoSubmissao->getDescricao()."\" e não pode ser excluída!');window.history.back();</script>";
                
            }
            else {
                echo "<script>window.alert('Submissão Inválida!');window.history.back();</script>";
            }
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>