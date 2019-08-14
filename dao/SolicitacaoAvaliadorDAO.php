<?php

require_once 'Conexao.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SolicitacaoAvaliadorDAO {
    
     public static function adicionarSolicitacaoAvaliador($idUsuario,$idEvento,$idArea) {
        $sql = "CALL adicionarSolicitacaoAvaliador('$idUsuario','$idEvento','$idArea');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function excluirSolicitacaoAvaliador($id) {
        $sql = "CALL excluirItem('solicitacaoavaliador','$id');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function atualizarSolicitacaoAvaliador($id,$idUsuario,$idEvento,$idArea,$situacao,$observacao) {
        $sql = "CALL atualizarSolicitacaoAvaliador('$id','$idUsuario','$idEvento','$idArea','$situacao','$observacao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosSolicitacoesAvaliador($idSolicitacao) {
        $sql = "CALL retornaItemPorId('solicitacaoavaliador','$idSolicitacao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function listaSolicitacaoAvaliadorComFiltro($idUsuario,$idEvento,$idArea,$situacao) {
        $sql = "CALL listaSolicitacaoAvaliadorComFiltro('$idUsuario','$idEvento','$idArea','$situacao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}