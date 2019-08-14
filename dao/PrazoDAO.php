<?php

require_once 'Conexao.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PrazoDAO {
    
    public static function adicionarPrazo($idPrazoEvento,$idEntidade,$dataFinal) {
        $sql = "CALL adicionarPrazo('$idPrazoEvento','$idEntidade','$dataFinal')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function excluirPrazo($id) {
        $sql = "CALL excluirItem('prazo','$id')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarPrazo($id,$idPrazoEvento,$idEntidade,$dataFinal) {
        $sql = "CALL atualizarPrazo('$id','$idPrazoEvento','$idEntidade','$dataFinal')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosPrazo($id) {
        $sql = "CALL retornaItemPorId('prazo','$id')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosPrazoPorTipoEntidade($idTipoPrazo,$idEntidade) {
        $sql = "CALL retornaDadosPrazoPorTipoEntidade('$idTipoPrazo','$idEntidade')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function listaPrazosComFiltro($idPrazoEvento,$idEntidade) {
        $sql = "CALL listaPrazosComFiltro('$idPrazoEvento','$idEntidade')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
}