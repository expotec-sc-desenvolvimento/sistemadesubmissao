<?php

    function loginObrigatorio () {
        if ( !isset( $_SESSION['usuario'] )) 
            header('Location: index.php?User=NaoLogado');
    }
    
    function verificarPermissaoAcesso($perfilUsuario,$perfisPermitidos,$direcionar) {
        
        foreach ($perfisPermitidos as $perfil) 
            if ($perfil == $perfilUsuario) return;

        header('Location:'.$direcionar.'?User=permissaoNegada');
    }
    

    function validarFoto($tamanho,$tipo) {
        $mensagem="";
        
        $tamanhoMaximoEmBytes = 2 * 1024 * 1024;
        $tiposArquivosPermitidos = "/(.jpg)(.jpeg)(.gif)(.png)/";
        
        
        if (!$tamanho>0) $mensagem = 'Selecione um arquivo válido';
        else if ($tamanho>$tamanhoMaximoEmBytes) $mensagem = 'O Tamanho Máximo da Imagem é de 2MB!';
        else if (!strpos($tiposArquivosPermitidos, $tipo)) $mensagem = 'Tipo de Arquivo não permitido';
        
        return $mensagem;
    }
    
    
    // As funções abaixo estão relacionadas com as classes. As mesmas teriam a mesma estrutura, então foram colocadas como uma função geral
    function retornaRespostaUnica($dado) {
        
        $resposta = -1;
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) {
                    return $value;
                }
            }

        } catch (Exception $e){
            echo  $e->getMessage();
        }

        return $resposta;
    }
    

?>