<?php

require_once 'Conexao.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UsuariosDaSubmissaoDao{
    
    /**
     * Verifica se há Usuario com os Login e senha informados
     * @param string $cpf
     * @param string $senha
     * @return array NULL ou array com os dados do Usuario retornado
     */
    
    public static function retornaIdUsuarioSubmissao($idSubmissao,$idUsuario) {
        $sql = "CALL retornaIdUsuarioSubmissao('$idSubmissao','$idUsuario');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarUsuariosDaSubmissao($id,$idSubmissao,$idUsuario,$isSubmissor,$apresentouTrabalho,$envioEmailCartaAceite) {
        $sql = "CALL atualizarUsuariosDaSubmissao('$id','$idSubmissao','$idUsuario','$isSubmissor','$apresentouTrabalho','$envioEmailCartaAceite');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }

    public static function listaUsuariosDaSubmissaoComFiltro($idSubmissao,$idUsuario,$isSubmissor,$apresentouTrabalho,$envioEmailCartaAceite) {
        $sql = "CALL listaUsuariosDaSubmissaoComFiltro('$idSubmissao','$idUsuario','$isSubmissor','$apresentouTrabalho','$envioEmailCartaAceite');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosUsuariosDaSubmissao($idUsuarioDaSubmissao){
        $sql = "CALL retornaItemPorId('usuariosdasubmissao','$idUsuarioDaSubmissao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}
?>