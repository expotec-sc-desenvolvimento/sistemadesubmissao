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

            $idEvento = $p['select-Eventos'];
            $idTipoAvalicao = $p['select-tipoAvaliacao'];
            
            $qtdeAvaliadoresArea = $p['avaliadoresDaArea'];
            $qtdeAvaliadoresOutraArea = $p['avaliadoresOutraArea'];

            $submissoes = Submissao::listaSubmissoesComFiltro($idEvento, '', '', 1, $idTipoAvalicao); // Situação 1 = Submetida
            
            $avaliacoesComAvaliadores = 0;
            $avaliacoesSemAvaliadores = 0;
            
            //echo "Quantidade de avaliadores para a área: " . $qtdeAvaliadoresArea . "<br>"
            //        . "Quantidade de avaliadores para outra área: " . $qtdeAvaliadoresOutraArea . "<br><br>";
            
            
            foreach($submissoes as $submissao) {
                $listaAvaliadoresArea = Usuario::listaAvaliadoresParaCadastro($submissao->getIdEvento(),$submissao->getIdArea(),'mesma-area',$qtdeAvaliadoresArea,$submissao->getId());
                $listaAvaliadoresOutraArea = Usuario::listaAvaliadoresParaCadastro($submissao->getIdEvento(),$submissao->getIdArea(),'outra-area',$qtdeAvaliadoresOutraArea,$submissao->getId());
                
                
                if (count($listaAvaliadoresArea)>=$qtdeAvaliadoresArea && count($listaAvaliadoresOutraArea)>=$qtdeAvaliadoresOutraArea) {
                    // DISTRIBUIR AVALIADORES
                    $idsAvaliadores="";
                    
                    // Coleta os ID's dos avaliadores da área do evento com menos avaliações
                    foreach($listaAvaliadoresArea as $usuarioAvaliador) {
                        $idsAvaliadores = $idsAvaliadores . $usuarioAvaliador->getId() . ";";
                    }
                    
                    // Coleta os ID's dos avaliadores de outras áreas do evento com menos avaliações
                    if ($qtdeAvaliadoresOutraArea>0) {
                        foreach($listaAvaliadoresOutraArea as $usuarioAvaliador) {
                            $idsAvaliadores = $idsAvaliadores . $usuarioAvaliador->getId() . ";";
                        }
                    }
                    
                    
                    if (Avaliacao::adicionarAvaliacoes($submissao->getId(),$submissao->getIdTipoSubmissao(),$submissao->getIdModalidade(),$idsAvaliadores)) {
                        $avaliacoesComAvaliadores+=1;
                    }
                    else $avaliacoesSemAvaliadores+=1;                
                }
                else $avaliacoesSemAvaliadores+=1;                
            }
            
            /*echo "Avaliacoes com avaliadores: " . $avaliacoesComAvaliadores . "<br>"
                    . "Avaliacoes sem avaliadores: " . $avaliacoesSemAvaliadores . "<br>"; */
              
                header('Location: ../gerenciarSubmissoes.php?Item=Atualizado');
            } catch (Exception $e) {
            $e->getMessage();
        }
    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>