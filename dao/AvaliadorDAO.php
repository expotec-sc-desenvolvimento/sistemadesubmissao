<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Conexao.php';

class AvaliadorDAO {
    public static function adicionarAvaliador($idEvento,$idArea,$idUsuarios) {
        $sql = "CALL adicionarAvaliador('$idEvento','$idArea','$idUsuarios')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function excluirAvaliador($id) {
        $sql = "CALL excluirItem('avaliador','$id')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function atualizarAvaliador($id,$idEvento,$idArea,$idUsuario) {
        $sql = "CALL atualizarAvaliador('$id','$idEvento','$idArea','$idUsuario')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosAvaliador($idAvaliador) {
        $sql = "CALL retornaItemPorId('avaliador','$idAvaliador');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function listaAvaliadoresComFiltro($idEvento,$idArea,$idUsuario,$tipo) {
        $sql = "CALL listaAvaliadoresComFiltro('$idEvento','$idArea','$idUsuario','$tipo');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
}
?>