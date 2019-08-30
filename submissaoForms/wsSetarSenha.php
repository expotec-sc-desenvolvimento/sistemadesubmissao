<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();
    
    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página

    $id = $_GET['id'];
    $senhaNova = md5 ("12345");

    Usuario::setarSenha($id, $senhaNova);
    header('Location: ../gerenciarUsuarios.php?Item=Atualizado');
    

?>