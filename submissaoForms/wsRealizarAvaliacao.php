<?php


    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
        
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    
    
    
    if ($metodoHttp === 'POST') {
        try {
            
            $p = filter_input_array(INPUT_POST);    

            $avaliacao = new Avaliacao();
            $avaliacao = Avaliacao::retornaDadosAvaliacao($p['idAvaliacao']);
            
            if ($avaliacao->getId()=="" || ($avaliacao->getIdUsuario() != $usuario->getId())) header('Location: ./paginaInicial.php');
            
            $tipoAvaliacao = TipoSubmissao::retornaDadosTipoSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdTipoSubmissao())->getId();
            // 1 = Parcial , 2 = Corrigida , 3 - Final
            
            $idAvaliacao = $p['idAvaliacao'];
            $observacao = $p['observacao'];
            
            $situacaoAvaliacao = '';
            $notas = "";
            $somaNotas = 0;
            $somaPesos = 0;
                
            if ($tipoAvaliacao==1 || $tipoAvaliacao==2) $situacaoAvaliacao = $p['resultadoAvaliacao']; // Avaliação Aprovado(a), Aprovado(a) com Ressalvas ou Reprovado(a)
            else $situacaoAvaliacao = 2; // Avaliação Finalizada
            
            $avaliacaoCriterios = AvaliacaoCriterio::retornaCriteriosParaAvaliacao($avaliacao->getId());
            
            //echo $tipoAvaliacao . " - " . $idAvaliacao . " - " . $observacao . " - " . $situacaoAvaliacao; exit(1);

                
            foreach ($avaliacaoCriterios as $avaliacaoCriterio) {

                $notas = $notas . $avaliacaoCriterio->getId() ."=". $p[$avaliacaoCriterio->getId()] . ";";

                if ($tipoAvaliacao==3) { // Caso seja avaliação final, terá nota ponderada
                    $somaNotas += ($p[$avaliacaoCriterio->getId()] * Criterio::retornaDadosCriterio($avaliacaoCriterio->getIdCriterio())->getPeso());
                    $somaPesos += Criterio::retornaDadosCriterio($avaliacaoCriterio->getIdCriterio())->getPeso();
                }
            }

            if ($tipoAvaliacao==1 || $tipoAvaliacao==2) $notaFinalAvaliacao = ''; // Caso seja uma avaliação Parcial/Corrigida, não necessita de Nota
            else $notaFinalAvaliacao = round($somaNotas / $somaPesos);
            
            
            if (Avaliacao::realizarAvaliacao($avaliacao->getId(),$situacaoAvaliacao,$notas,$notaFinalAvaliacao,$observacao)) {
                header('Location: ../minhasAvaliacoes.php?Item=Atualizado');
            }
            else header('Location: ../minhasAvaliacoes.php?Item=NaoAtualizado');
            
            /* Caso a avaliação não exista ou o usuário que tenta acessar essa avaliação não é o usuário para qual a avaliação está vinculada,
               o usuário é redirecionado para a página inicial*/ 
            
            
            
            
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }
    
?>