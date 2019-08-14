<?php

require_once 'Conexao.php';

class TipoPrazoDao {
        
    public static function listaTipoPrazo(){
        $sql = "CALL listaItens('tipoprazo');";
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosTipoPrazo($idTipoPrazo) {
        $sql = "CALL retornaItemPorId('tipoprazo','$idTipoPrazo');";
        return Conexao::executar($sql);
    }
}
?>