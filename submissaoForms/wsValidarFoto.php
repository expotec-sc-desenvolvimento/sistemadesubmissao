<?php

    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
   
    
    $tipoArquivo = strtolower(pathinfo($_FILES[ 'pImagem' ]["name"], PATHINFO_EXTENSION));
    $tamanho = $_FILES[ 'pImagem' ][ 'size' ];
    
    $resposta = validarFoto($tamanho, $tipoArquivo);
    
    if ($resposta=="") { // Verifica se a imagem está de acordo com as especificações esperadas. Se não retornar nenhuma reposta, o arquivo está OK

        $caracteresCPF = array(".", "-");
        $nome = str_replace($caracteresCPF,"",$usuario->getCpf());

        if (move_uploaded_file($_FILES['pImagem']['tmp_name'], './../' . $pastaFotosPerfil . $nome . "." . $tipoArquivo)) { // Tenta Inserir a imagem na pasta

            $imagem = $nome . "." . $tipoArquivo;
            $usuario->setImagem($imagem);

            $_SESSION['usuario'] = $usuario;
            header('Location: ../paginaInicial.php?Item=Atualizado');
        }
        else echo "<script>window.alert('Houve um erro no Upload da Imagem. Tente fazer o Upload posteriormente')</script>";

    }
    else header('Location: ../paginaInicial.php?Item=NaoAtualizado');


?>

