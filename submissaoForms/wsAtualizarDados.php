<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    $metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');


    if ($metodoHttp === 'POST') {
        try {
            $p = filter_input_array(INPUT_POST);    

            $cpf = $p['cpf'];
            $nome = $p['nome'];
            $sobrenome = $p['sobrenome'];
            $dataNascimento = $p['dataNascimento'];
            $email = $p['email'];
            $tipoUsuario = $p['idTipoUsuario'];
            $perfil = $p['perfil'];
            $idUsuario = $p['idUsuario'];

            
            
            
            if ($usuario->atualizarUsuario($idUsuario,$perfil,$cpf,$nome,$sobrenome,$dataNascimento,$email,$tipoUsuario)) {
                $usuario->setCpf($cpf);
                $usuario->setNome($nome);
                $usuario->setSobrenome($sobrenome);
                $usuario->setDataNascimento($dataNascimento);
                $usuario->setEmail($email);
                $usuario->setIdTipoUsuario($tipoUsuario);
                $usuario->setIdPerfil($perfil);
                $_SESSION['usuario'] = $usuario;
                header('Location: ../paginaInicial.php?Item=Atualizado');
            }
            else {
                echo "<script>window.alert('Erro na atualização. Verifique se seu Email ou CPF já não está cadastrado!');window.history.back();</script>";
            }
            
        } catch (Exception $e) {
            $e->getMessage();
        }

    } else {
        //$_SESSION['msg'] = "Você deve fazer login no sistema";
        header('Location: ../index.php');
    }

?>