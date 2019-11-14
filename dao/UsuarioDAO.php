<?php

require_once 'Conexao.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UsuarioDao{
    
    /**
     * Verifica se há Usuario com os Login e senha informados
     * @param string $cpf
     * @param string $senha
     * @return array NULL ou array com os dados do Usuario retornado
     */
    
    public static function login($cpf, $senha){
        $sql = "CALL login('$cpf', '$senha');";
//        echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function logout($id, $nome){
        $sql = "CALL logout('$id', '$nome');";
//        echo $sql; exit(1);
        Conexao::executar($sql);
    }
    
    public static function alterarSenha($id,$senhaAntiga,$senhaNova) {
        $sql = "CALL atualizarSenha('$id','$senhaAntiga','$senhaNova')";
//        echo $sql; exit(1);
        return Conexao::executar($sql);
    }
  
    public static function recuperarSenha($cpf,$email,$senha) {
        $sql = "CALL recuperarSenha('$cpf','$email','$senha')";
//        echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function listaUsuarios($filtroNome,$tipoUsuario,$filtroPerfil) {
        $sql = "CALL listaUsuarios('$filtroNome','$tipoUsuario','$filtroPerfil')";
//        echo $sql; exit(1);
        return Conexao::executar($sql);
    }

    public static function atualizarUsuario($idUsuario,$perfil,$cpf,$nome,$sobrenome,$dataNascimento,$email,$tipoUsuario) {
        $sql = "CALL atualizarUsuario('$idUsuario','$perfil','$cpf','$nome','$sobrenome','$dataNascimento','$email','$tipoUsuario')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function excluirUsuario($idUsuario) {
        $sql = "CALL excluirItem('usuario','$idUsuario')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public function adicionarUsuario($perfil,$cpf,$nome,$sobrenome,$senha,$dataNascimento,$email,$tipoUsuario,$foto) {
        $sql = "CALL adicionarUsuario('$perfil','$cpf','$nome','$sobrenome','$senha','$dataNascimento','$email','$tipoUsuario','$foto')";
      //  echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    
    public function retornaDadosUsuario($idUsuario) {
        $sql = "CALL retornaItemPorId('usuario','$idUsuario')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function setarSenha($idUsuario,$senha) {
        $sql = "CALL setarSenha('$idUsuario','$senha')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }

    public static function listaAvaliadoresParaCadastro($idEvento,$idArea,$tipo,$limite,$idSubmissao) {
        $sql = "CALL listaAvaliadoresParaCadastro('$idEvento','$idArea','$tipo','$limite','$idSubmissao')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}
?>