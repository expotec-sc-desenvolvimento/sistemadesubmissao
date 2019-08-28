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

            $submissao = Submissao::retornaDadosSubmissao($p['idSubmissao']);
            
            // Tipo Submissões - 1-Parcial / 2-Corrigida / 3-Final
            // Tipo de Prazos - 2-Parcial / 3-Corrigda / 4-Final
            
            $novosAvaliadores = $p['avaliador1'] . ";" . $p['avaliador2'] . ";" . $p['avaliador3'] . ";";
            
            $prazo = "";
            
            
            // Tipos de Submissoes: 1-Parcial, 2-Corrigida, 3-Final
            switch ($submissao->getIdTipoSubmissao()) {
                case 1: $prazo = Evento::retornaDadosEvento($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoParcial(); break;
                case 2: $prazo = Evento::retornaDadosEvento($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoCorrigida(); break;
                case 3: $prazo = Evento::retornaDadosEvento($submissao->getIdEvento())->getPrazoFinalEnvioAvaliacaoFinal(); break;
            }
            

            if (Avaliacao::adicionarAvaliacoes($submissao->getId(), $submissao->getIdTipoSubmissao(), $submissao->getIdModalidade(), $novosAvaliadores,$prazo)) {
                
                $emails = array();
                array_push($emails, Usuario::retornaDadosUsuario($p['avaliador1'])->getEmail());
                array_push($emails, Usuario::retornaDadosUsuario($p['avaliador2'])->getEmail());
                array_push($emails, Usuario::retornaDadosUsuario($p['avaliador3'])->getEmail());
                
                emailAtribuicaoAvaliacao($submissao, $prazo, $emails);
                header('Location: ../gerenciarSubmissoes.php?Item=Atualizado');
            }
            else header('Location: ../gerenciarSubmissoes.php?Item=NaoAtualizado'); 

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>