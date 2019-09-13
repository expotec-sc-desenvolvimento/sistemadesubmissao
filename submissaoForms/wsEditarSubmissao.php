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
    
            if ($tamanho>0 && !strpos($tipoArquivo, $tipo)) { // Verifica o tipo de arquivo enviado
                echo "<script>window.alert('Tipo de Arquivo não permitido');window.history.back();</script>";
            }
            else {

                
                $submissao = new Submissao();
                $submissao = Submissao::retornaDadosSubmissao($idSubmissao);
                
                $novoArquivo = $submissao->getArquivo();

                //echo $novoArquivo; exit(1);
                
                
                if (Submissao::atualizarSubmissao($idSubmissao,$idEvento, $idArea, $idModalidade, $submissao->getIdTipoSubmissao(), 1, $novoArquivo, $titulo, $resumo, $palavrasChave, $relacaoCom, $idUsuariosAdd,'')) {
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