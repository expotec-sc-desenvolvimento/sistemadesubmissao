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

            $idCriterio = $p['pIdCriterio'];
            $descricao = $p['pDescricao'];
            $detalhamento = $p['pDetalhamento'];
            $peso = $p['pPeso'];

            $criterio = new Criterio();
            $criterio = Criterio::retornaDadosCriterio($idCriterio);
            
            
            if ($criterio->getId()!="") {
                
                $idModalidade = $criterio->getIdModalidade();
                
                if (Criterio::atualizarCriterio($idCriterio,$descricao,$detalhamento,$peso)) {
                    header('Location: ../gerenciarModalidades.php?Item=Atualizado');
                    
                }
                else {
                    header('Location: ../gerenciarModalidades.php?Item=NaoAtualizado');
                }
                
            }
            else {
                echo "<script>window.alert('Criterio Inválido!');window.history.back();</script>";
            }
            
            

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }
?>