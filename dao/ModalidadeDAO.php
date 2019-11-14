<?php

require_once 'Conexao.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModalidadeDAO{
    
    /**
     * Verifica se há Usuario com os Login e senha informados
     * @param string $cpf
     * @param string $senha
     * @return array NULL ou array com os dados do Usuario retornado
     */
    
    public static function adicionarModalidade($descricao) {
        $sql = "CALL adicionarModalidade('$descricao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarModalidade($id, $descricao) {
        $sql = "CALL atualizarModalidade('$id','$descricao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    
    public static function excluirModalidade($id) {
        $sql = "CALL excluirItem('modalidade','$id');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function listaItens($tabela) {
        $sql = "CALL listaItens('$tabela');";
        return Conexao::executar($sql);
    }
    
    
    
    // REVER OS CODIGOS ABAIXO
    public static function listaModalidadesPorEvento($idEvento) {
        $sql = "CALL listaModalidadesPorEvento('$idEvento');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosModalidade($idModalidade){
        $sql = "CALL retornaItemPorId('modalidade','$idModalidade');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}