<?php

require_once 'Conexao.php';

class TipoCertificadoDao {
        
    public static function listaTipoCertificado(){
        $sql = "CALL listaItens('tiposcertificado');";
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosTipoCertificado($idTipoCertificado) {
        $sql = "CALL retornaItemPorId('tiposcertificado','$idTipoCertificado');";
        return Conexao::executar($sql);
    }
}
?>