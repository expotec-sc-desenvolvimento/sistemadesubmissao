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

            
            $idEvento = $p['pEvento'];
            $nomeArquivo = $p['pNomeArquivo'];
            $descricaoArquivo = $p['pDescricaoArquivo'];

            $tipoArquivo = "/(.pdf)/";            
            
            if ($_FILES[ 'pArquivo' ][ 'size' ]>0) { // Verifica se o usuário fez o upload de algum arquivo
                
                $tipo = strtolower(pathinfo($_FILES[ 'pArquivo' ]["name"], PATHINFO_EXTENSION));
                
                if (!strpos($tipoArquivo, $tipo)) { // Verifica o tipo de arquivo enviado
                    echo "<script>window.alert('Tipo de Arquivo não permitido');window.history.back();</script>";
                }
                else {
                    
                    Download::adicionarDownload($idEvento, $nomeArquivo, $descricaoArquivo, "-1");
                    $idDownload = Download::retornaIdUltimoDownload();
                    
                    $nomeArquivo = $idDownload . "-" . $nomeArquivo . "." . $tipo;
                    
                    if (move_uploaded_file($_FILES['pArquivo']['tmp_name'], './../' . $pastaDownloads . $nomeArquivo)) { // Tenta Inserir a imagem na pasta
                        Download::atualizarDownload($idDownload,$idEvento, $nomeArquivo, $descricaoArquivo, $nomeArquivo);
                        header('Location: ../gerenciarDownloads.php?Item=Criado');
                    }
                    else echo "<script>window.alert('Houve um erro no Upload da Imagem. Tente fazer o Upload posteriormente')";
                }
            }
            else {
                header('Location: ../addDownload.php?Download=ArquivoInvalido');
            }

        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>