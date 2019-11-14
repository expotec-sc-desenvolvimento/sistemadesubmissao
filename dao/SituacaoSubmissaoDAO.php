<?php

require_once 'Conexao.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SituacaoSubmissaoDAO {
    public static function retornaDadosSituacaoSubmissao($idSituacao) {
        $sql = "CALL retornaItemPorId('situacaosubmissao','$idSituacao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function listaSituacaoSubmissao() {
        $sql = "CALL listaItens('situacaosubmissao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
}
