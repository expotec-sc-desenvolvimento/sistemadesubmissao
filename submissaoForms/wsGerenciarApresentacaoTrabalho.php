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
        
        
        // Pegando os usuários da submissao
        $usersSubmissao = array();
        foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($p['submissao'], '', '', '','') as $obj) {
            array_push($usersSubmissao, $obj->getId());
        }
        
        // Pegando os usuários que foram marcados pelo administrador
        $userApresentacao = array();
        if (isset($p['apresentados'])) {foreach ($p['apresentados'] as $obj) array_push ($userApresentacao, $obj);}
  
        foreach ($usersSubmissao as $obj) {
            $user = UsuariosDaSubmissao::retornaDadosUsuariosDaSubmissao($obj);
            
            if (in_array($obj, $userApresentacao)) {
                UsuariosDaSubmissao::atualizarUsuariosDaSubmissao($obj, $user->getIdSubmissao(), $user->getIdUsuario(), $user->getIsSubmissor(), 1,'');
            } 
            else{
                UsuariosDaSubmissao::atualizarUsuariosDaSubmissao($obj, $user->getIdSubmissao(), $user->getIdUsuario(), $user->getIsSubmissor(), '','');
                // Retirar algum certificado que tenha sido gerado
                if (existeCertificadoApresentacao($user->getIdSubmissao(), $user->getIdUsuario())) {
                    foreach (Certificado::listaCertificadosComFiltro('Apresentacao', $user->getIdUsuario()) as $certificado) {
                        $pos = strpos($certificado->getArquivo(), "-".$user->getIdSubmissao()."-");
                        if ($pos === false) continue;
                        else if (Certificado::excluirCertificado($certificado->getId())) {
                            unlink('./../' . $pastaCertificados . $certificado->getArquivo());
                            break;
                        }
                    }
                }
            }
            
        }
        
        header('Location: '.$_SERVER["HTTP_REFERER"].'?Item=Atualizado');    
        
        
    }
    else echo "<script>window.alert('Erro no Envio de Certificados!');window.history.back();</script>";
?>