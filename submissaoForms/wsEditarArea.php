<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    
    if ($metodoHttp === 'POST') {
        try {
            
            $p = filter_input_array(INPUT_POST);    

            $idArea = $p['pIdArea'];
            $descricao = $p['pArea'];
            $subAreas = $p['pSubAreas'];

            $area = new Area();
            $area = Area::retornaDadosArea($idArea);

            if ($area->getId()!="") {
                if (Area::atualizarArea($idArea,$descricao,$subAreas)) {
                    header("Location: ../gerenciarAreas.php?Item=Atualizado");
                }
                else {
                    header("Location: ../gerenciarAreas.php?Item=NaoAtualizado");
                }
            }
            else {
                echo "<script>window.alert('Modalidade Inválida!');window.history.back();</script>";
            }
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }
?>