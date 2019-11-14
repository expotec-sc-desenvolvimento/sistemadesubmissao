<?php

    include dirname(__DIR__) . '/inc/includes.php';
    include dirname(__DIR__) . '/vendor/autoload.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    if ($metodoHttp === 'POST') {
        
        $p = filter_input_array(INPUT_POST);
        
        $tipo = $p['tipoCertificado'];
        
        if ($tipo == "Monitoria") {
            if (isset($p['certificados'])) {
                foreach ($p['certificados'] as $idUsuario) {
                    gerarCertificado($tipo, $idUsuario,'');
                }
            }
        }
        else if ($tipo == "Apresentacao") {
            if (isset($p['certificados'])) {
                foreach ($p['certificados'] as $idSubmissao) {
                    foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($idSubmissao, '', '', 1,'') as $userSubmissao) {
                        if (!existeCertificadoApresentacao($idSubmissao, $userSubmissao->getIdUsuario())) {
                            gerarCertificado($tipo, $userSubmissao->getIdUsuario(),$idSubmissao);
                        }
                    }
                }
            }
        }

        header('Location: ../gerenciarCertificados.php?Item=Criado');
        
    }
    else echo "<script>window.alert('Erro no Envio de Certificados!');window.history.back();</script>";
?>