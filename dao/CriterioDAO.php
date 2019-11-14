<?php


require_once 'Conexao.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CriterioDao {
    
    public static function adicionarCriterio($idModalidade,$idTipoSubmissao,$descricao,$detalhamento,$peso) {
        
        $sql = "CALL adicionarCriterio('$idModalidade','$idTipoSubmissao','$descricao','$detalhamento','$peso');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function excluirCriterio($id) {
        
        $sql = "CALL excluirItem('criterio','$id');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarCriterio($id,$descricao,$detalhamento,$peso) {
        
        $sql = "CALL atualizarCriterio('$id','$descricao','$detalhamento','$peso');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    
    
    public static function retornaDadosCriterio($id){
        $sql = "CALL retornaItemPorId('criterio','$id');";
        return Conexao::executar($sql);
    }
    
    
    public static function listaCriteriosComFiltro($idModalidade,$idTipoSubmissao) {
        $sql = "CALL listaCriteriosComFiltro('$idModalidade','$idTipoSubmissao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
}