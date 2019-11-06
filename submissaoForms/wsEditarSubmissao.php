<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $idSubmissao = $p['idSubmissao'];
            $idUsuariosAdd = $p['idUsuariosAdd'];
            $idEvento = $p['select-Eventos'];
            $idModalidade = $p['select-Modalidades'];
            $idArea = $p['select-Areas'];
            
            $titulo = $p['titulo'];
            $resumo = $p['resumo'];
            $palavrasChave = $p['palavrasChave'];
            $relacaoCom = $p['relacaoCom'];
            
            $tipoArquivo = "/(.pdf)/";  
            $tipo = strtolower(pathinfo($_FILES[ 'arquivo' ]["name"], PATHINFO_EXTENSION));

            $tamanho = $_FILES[ 'arquivo' ][ 'size' ];            
    
            if (isset($p['novoArquivo']) && !strpos($tipoArquivo, $tipo)) { // Verifica o tipo de arquivo enviado
                echo "<script>window.alert('Tipo de Arquivo não permitido!');window.history.back();</script>";
            }
            else if (isset($p['novoArquivo']) && $_FILES[ 'arquivo' ][ 'size' ]==0 || $_FILES[ 'arquivo' ][ 'size' ]>(5 * 1024 * 1024)) {
                echo "<script>window.alert('Tamanho de arquivo inválido. O arquivo deve ter, no máximo, 5MB!');window.history.back();</script>";
            }
            else {

                
                $submissao = new Submissao();
                $submissao = Submissao::retornaDadosSubmissao($idSubmissao);
                
                $novoArquivo = $submissao->getArquivo();

                //echo $novoArquivo; exit(1);
                
                
		if (Submissao::atualizarSubmissao($idSubmissao,$idEvento, $idArea, $idModalidade, $submissao->getIdTipoSubmissao(), $submissao->getIdSituacaoSubmissao(), $novoArquivo, $titulo, $resumo, $palavrasChave, $relacaoCom, $idUsuariosAdd,'')) {
		
			// CODIGO INSERIDO TEMPORARIAMENTE
			if ($submissao->getIdRelacaoComSubmissao()!='') {
			   $subT = Submissao::retornaDadosSubmissao($submissao->getIdRelacaoComSubmissao());
			   Submissao::atualizarSubmissao($subT->getId(),$idEvento,$idArea,$idModalidade,$subT->getIdTipoSubmissao(),$subT->getIdSituacaoSubmissao(),$subT->getArquivo(),$subT->getTitulo(),$subT->getResumo(),$subT->getPalavrasChave(),$subT->getRelacaoCom(),$idUsuariosAdd,$subT->getIdRelacaoComSubmissao());

			   if ($subT->getIdRelacaoComSubmissao()!='') {
			   	$subT1 = Submissao::retornaDadosSubmissao($subT->getIdRelacaoComSubmissao());
				Submissao::atualizarSubmissao($subT1->getId(),$idEvento,$idArea,$idModalidade,$subT1->getIdTipoSubmissao(),$subT1->getIdSituacaoSubmissao(),$subT1->getArquivo(),$subT1->getTitulo(),$subT1->getResumo(),$subT1->getPalavrasChave(),$subT1->getRelacaoCom(),$idUsuariosAdd,$subT1->getIdRelacaoComSubmissao());
			   }
			}
			// FIM

                    if ($tamanho>0 ) { // Tenta Inserir a imagem na pasta
                        //unlink('./../' . $pastaSubmissoes . $novoArquivo);
                        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], dirname(__DIR__) . "/" . $pastaSubmissoes . $novoArquivo))
                            header('Location: ../minhasSubmissoes.php?Item=Atualizado');
                        else echo "<script>window.alert('2-Houve um erro na Submissao. Entre em contato com um Administrador do Sistema');window.history.back();</script>";
                    }
                    else header('Location: ../minhasSubmissoes.php?Item=Atualizado');
                }

                else echo "<script>window.alert('1-Houve um erro na Submissao. Entre em contato com um Administrador do Sistema');window.history.back();</script>";
                
            }
            

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>
