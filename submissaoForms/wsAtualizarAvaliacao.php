<?php

    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $idAvaliacao = $p['idAvaliacao'];
            $novoAvaliador = $p['novoAvaliador'];
            $prazo = $p['prazo'];
            
            $dataAtual = date('Y-m-d');
            
            
            if (strtotime($prazo)>=strtotime($dataAtual)) {
                if (Avaliacao::atualizarAvaliacao($idAvaliacao, $novoAvaliador,1,$prazo)) {
                    header('Location: '.$_SERVER["HTTP_REFERER"].'?Item=Atualizado');
                }
                    else header('Location: '.$_SERVER["HTTP_REFERER"].'?Item=NaoAtualizado');
                }
            else echo "<script>window.alert('A data do prazo é menor que a data Atual!');window.history.back();</script>";
            

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>