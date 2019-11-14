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
        
        //echo count($p['cartaAceite']); exit(1);
        
        if (isset($p['cartaAceite'])) {
            foreach ($p['cartaAceite'] as $idSubmissao) {
                
                foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($idSubmissao, '', '', '', '') as $userSubmissao) {
                    if ($userSubmissao->getEnvioEmailCartaAceite()==1) continue;
                    
                    else
                        enviarCartaAceite (Submissao::retornaDadosSubmissao ($idSubmissao), $userSubmissao);
                }
            }
        }
        
        header('Location: ../gerenciarSubmissoes.php?Item=Criado');
        
    }
    else echo "<script>window.alert('Erro no Envio das Cartas de Aceite!');window.history.back();</script>";
?>