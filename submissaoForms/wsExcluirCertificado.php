<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    if ($metodoHttp === 'GET') {
        try {
            
            $idCertificado = $_GET['id'];

            $certificado = Certificado::retornaDadosCertificado($idCertificado);
            
            if ($certificado->getId()!="") {
                
                if (Certificado::excluirCertificado($idCertificado)) {
                    unlink('./../' . $pastaCertificados . $certificado->getArquivo());    
                    header('Location: ../gerenciarCertificados.php?Item=Excluido');
                }
                else {
                    header('Location: ../gerenciarCertificados.php?Item=NaoExcluido');
                }
                
            }
            else {
                echo "<script>window.alert('Certificado Inválido!');window.history.back();</script>";
            }
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>