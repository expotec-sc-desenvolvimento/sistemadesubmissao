<?php

require_once 'Conexao.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AreaEventoDAO {
    
     public static function adicionarAreaEvento($idEvento,$idArea) {
        $sql = "CALL adicionarAreaEvento('$idEvento','$idArea')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function excluirAreaEvento($id) {
        $sql = "CALL excluirItem('areasevento','$id')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarAreaEvento($id,$idEvento,$idArea) {
        $sql = "CALL atualizarAreaEvento('$id','$idEvento','$idArea')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosAreaEvento($id) {
        $sql = "CALL retornaItemPorId('areasevento','$id');";
     //   echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaIdAreaEvento($idEvento,$idArea) {
        $sql = "CALL retornaIdAreaEvento('$idEvento','$idArea')";
     //   echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function listaAreaEventoComFiltro($idArea,$idEvento) {
        $sql = "CALL listaAreaEventoComFiltro('$idArea','$idEvento')";
     //   echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}