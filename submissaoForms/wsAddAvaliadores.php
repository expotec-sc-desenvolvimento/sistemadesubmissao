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

            $idEvento = $p['select-Eventos'];
            $idArea = $p['select-Areas'];
            $idUsuarios = $p['idUsuariosAdd'];


            
            if (Avaliador::adicionarAvaliador($idEvento, $idArea, $idUsuarios)) {

                header('Location: ../gerenciarAvaliadores.php?Item=Criado');
            }
            else echo "<script>window.alert('Erro no Cadastro! Verifique novamente os Avaliadores');window.history.back();</script>";
            

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>