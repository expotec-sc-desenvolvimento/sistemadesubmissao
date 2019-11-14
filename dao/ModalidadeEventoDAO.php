<?php

require_once 'Conexao.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModalidadeEventoDAO {
    
     public static function adicionarModalidadeEvento($idEvento,$idModalidade) {
        $sql = "CALL adicionarModalidadeEvento('$idEvento','$idModalidade');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function excluirModalidadeEvento($id) {
        $sql = "CALL excluirItem('modalidadesevento','$id');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarModalidadeEvento($id,$idEvento,$idModalidade) {
        $sql = "CALL atualizarModalidadeEvento('$id','$idEvento','$idModalidade');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }

  
    public static function retornaDadosModalidadeEvento($id) {
        $sql = "CALL retornaItemPorId('modalidadesevento','$id');";
     //   echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaIdModalidadeEvento($idEvento,$idModalidade) {
        $sql = "CALL retornaIdModalidadeEvento('$idEvento','$idModalidade');";
     //   echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function listaModalidadeEventoComFiltro($idModalidade,$idEvento) {
        $sql = "CALL listaModalidadeEventoComFiltro('$idModalidade','$idEvento');";
     //   echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
}