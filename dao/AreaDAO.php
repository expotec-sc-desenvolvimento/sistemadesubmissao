<?php

require_once 'Conexao.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AreaDao{
    
    /**
     * Verifica se há Usuario com os Login e senha informados
     * @param string $cpf
     * @param string $senha
     * @return array NULL ou array com os dados do Usuario retornado
     */
    
    public static function listaAreas(){
        $sql = "CALL listaItens('area');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function adicionarArea($descricao,$subareas) {
        $sql = "CALL adicionarArea('$descricao','$subareas');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarArea($idArea, $descricao, $subAreas) {
        $sql = "CALL atualizarArea('$idArea','$descricao','$subAreas');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    
    public static function excluirArea($idArea) {
        $sql = "CALL excluirItem('area','$idArea');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function listaAreasPorEvento($idEvento) {
        $sql = "CALL listaAreasPorEvento('$idEvento');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosArea($idArea){
        $sql = "CALL retornaItemPorId('area','$idArea');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
}