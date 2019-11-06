<?php

require_once 'Conexao.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AvaliacaoCriterioDao {
    public static function retornaCriteriosParaAvaliacao($idAvaliacao) {
        $sql = "CALL retornaCriteriosParaAvaliacao('$idAvaliacao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}

