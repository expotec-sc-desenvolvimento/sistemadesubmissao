<?php

    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
            
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

    date_default_timezone_set('America/Sao_Paulo');

    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

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
            
    
            if (!strpos($tipoArquivo, $tipo)) { // Verifica o tipo de arquivo enviado
                echo "<script>window.alert('Tipo de Arquivo não permitido');window.history.back();</script>";
            }
            else {
                $evento = Evento::retornaDadosEvento($idEvento);
                $modalidade = Modalidade::retornaDadosModalidade($idModalidade);
                $idTipoSubmissao = TipoSubmissao::retornaIdTipoSubmissao("Parcial");
                
                $novoArquivo = $evento->getNome() . "-" . $modalidade->getDescricao() . "-" . substr(md5(time()), 0,15) . "-Parcial.pdf";

                //echo $novoArquivo; exit(1);
                // CONTINUAR DAQUI
                
                if (Submissao::adicionarSubmissao($idEvento, $idArea, $idModalidade,$idTipoSubmissao,1,$novoArquivo,$titulo,$resumo,$palavrasChave,$relacaoCom,$idUsuariosAdd,'')) {
                    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], './../' . $pastaSubmissoes . $novoArquivo)) { // Tenta Inserir a imagem na pasta
                        header('Location: ../minhasSubmissoes.php?Item=Criado');
                    }
                    else echo "<script>window.alert('2-Houve um erro na Submissao. Entre em contato com um Administrador do Sistema');window.history.back();";
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