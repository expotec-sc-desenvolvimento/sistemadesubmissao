<?php

require_once 'Conexao2.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UsuarioPedrinaDAO{
    
    /**
     * Verifica se há Usuario com os Login e senha informados
     * @param string $cpf
     * @param string $senha
     * @return array NULL ou array com os dados do Usuario retornado
     */
    
    public static function retornaDadosUsuarioPedrina($id){
        $sql = "CALL retornaDadosUsuarioPedrina('$id');";
        //echo $sql; exit(1);
        return Conexao2::executar($sql);
    }
}