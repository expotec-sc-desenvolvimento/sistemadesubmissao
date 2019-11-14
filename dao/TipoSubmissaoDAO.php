<?php


require_once 'Conexao.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TipoSubmissaoDao {
        public static function listaTipoSubmissoes() {
        
            $sql = "CALL listaItens('tiposubmissao');";
            //echo $sql; exit(1);
            return Conexao::executar($sql);
        }
        
        public static function retornaIdTipoSubmissao($nome) {
            $sql = "CALL retornaIdTipoSubmissao('$nome');";
            //echo $sql; exit(1);
            return Conexao::executar($sql);
        }
        
        public static function retornaDadosTipoSubmissao($idTipo) {
            $sql = "CALL retornaItemPorID('tiposubmissao','$idTipo');";
            //echo $sql; exit(1);
            return Conexao::executar($sql);
        }
}