<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página

    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    if ($metodoHttp === 'GET') {
        try {
            
            $avaliacao = new Avaliacao();
            $avaliacao = Avaliacao::retornaDadosAvaliacao($_GET['id']);
            
            if ($avaliacao->getId()!="") {
                if (Avaliacao::excluirAvaliacao($avaliacao->getId())) 
                    header('Location: ../gerenciarSubmissoes.php?Item=Excluido');
                
                else {
                    header('Location: ../gerenciarSubmissoes.php?Item=NaoExcluido');
                }
            }
            else {
                echo "<script>window.alert('Avaliador Inválido!');window.history.back();</script>";
            }
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }    
?>