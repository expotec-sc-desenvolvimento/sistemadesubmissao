<?php


include dirname(__FILE__) . '/../inc/includes.php';

$metodoHttp = filter_input(INPUT_SERVER, 'REQUEST_METHOD');


if ($metodoHttp === 'POST') {
    try {

        $p = filter_input_array(INPUT_POST);
        $cpf = $p['pCpf'];
        $email = $p['pEmail'];
        
        $novaSenha = substr(md5(time()), 0,6);
        $senhaCriptografada = md5($novaSenha);
        
        $usuario = null;
        $usuario = Usuario::recuperarSenha($cpf, $email,$senhaCriptografada);
        
        if ($usuario != NULL) {
            $EmailUsuario = EnviarEmail("Recuperação de senha do Sistema de Submissão 2.0",
                    "Olá,<br><br>"
                    . "Em nosso sistema foi solicitada a recuperação de senha "
                    . "para esse e-mail.<br>"
                    . "A sua senha foi redefinida para: <b>".$novaSenha."</b><br><br>"
                    . "att,<br>"
                    . "Equipe SS2.0"
                    ,"Sistema de Submissao",$email);
            
            
            if (!$EmailUsuario) {
                echo "<script>alert('Ocorreu um erro no envio da nova senha. Tente novamente ou contacte um administrador')</script>";
                header('Location: ../index.phpTrocarSenha=erro');
            }
            else {
                header('Location: ../index.php?Item=Atualizado');
            }
        }
        else header('Location: ../recuperarSenha.php?TrocarSenha=erro');
        
        
    } catch (Exception $e) {
        echo $e->getMessage();
    }
  //  echo json_encode(array("msg" => $mensagem, "t" => "Atenção"));
} else {
    //$_SESSION['msg'] = "Você deve fazer login no sistema";
    header('Location: ../index.php');
}

?>