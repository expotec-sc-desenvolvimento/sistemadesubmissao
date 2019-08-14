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

            $submissao = new Submissao();
            $submissao = Submissao::retornaDadosSubmissao($p['idSubmissao']);
            
            // Tipo Submissões - 1-Parcial / 2-Corrigida / 3-Final
            // Tipo de Prazos - 2-Parcial / 3-Corrigda / 4-Final
            
            $novosAvaliadores = $p['avaliador1'] . ";" . $p['avaliador2'] . ";" . $p['avaliador3'] . ";";
            
            $prazo = "";
            
            if (count(PrazosEvento::listaPrazosEventoComFiltro($submissao->getIdEvento(), $submissao->getIdTipoSubmissao()+1))>0) {
                $idPrazoEvento = PrazosEvento::retornaIdPrazosEvento($submissao->getIdEvento(), $submissao->getIdTipoSubmissao()+1);
                $dias = PrazosEvento::retornaDadosPrazosEvento($idPrazoEvento)->getDias();
                $data = date('Y-m-d');
                $prazo = date('Y-m-d', strtotime($data. ' + '.$dias.' days'));
            }
            
            
            if (Avaliacao::adicionarAvaliacoes($submissao->getId(), $submissao->getIdTipoSubmissao(), $submissao->getIdModalidade(), $novosAvaliadores,$prazo)) {
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