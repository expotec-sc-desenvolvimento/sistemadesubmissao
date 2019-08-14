<?php

require_once 'Conexao.php';

class PrazosEventoDao {
    public static function adicionarPrazosEvento($idEvento,$idTipoPrazo,$dias) {
        $sql = "CALL adicionarPrazosEvento('$idEvento','$idTipoPrazo','$dias');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);    
    }
    
    public static function excluirPrazosEvento($id) {
        $sql = "CALL excluirItem('prazosevento','$id')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarPrazosEvento($id,$idEvento,$idTipoPrazo,$dias) {
        $sql = "CALL atualizarPrazosEvento('$id','$idEvento','$idTipoPrazo','$dias')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosPrazosEvento($id) {
        $sql = "CALL retornaItemPorId('prazosevento','$id');";
     //   echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function listaPrazosEventoComFiltro($idEvento,$idTipoPrazo) {
        $sql = "CALL listaPrazosEventoComFiltro('$idEvento','$idTipoPrazo');";
     //   echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaIdPrazosEvento($idEvento,$idTipoPrazo) {
        $sql = "CALL retornaIdPrazosEvento('$idEvento','$idTipoPrazo');";
     //   echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}

?>