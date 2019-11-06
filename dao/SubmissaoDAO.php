<?php

require_once 'Conexao.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SubmissaoDAO {
    
     public static function adicionarSubmissao($idEvento,$idArea,$idModalidade,$idTipoSubmissao,$idSituacaoSubmissao,$arquivo,$titulo,$resumo,$palavrasChave,$relacaoCom,$componentes,$idRelacaoComSubmissao) {
        $sql = "CALL adicionarSubmissao('$idEvento','$idArea','$idModalidade','$idTipoSubmissao','$idSituacaoSubmissao','$arquivo','$titulo','$resumo','$palavrasChave','$relacaoCom','$componentes','$idRelacaoComSubmissao');";
       // echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarSubmissao($id,$idEvento,$idArea,$idModalidade,$idTipoSubmissao,$idSituacaoSubmissao,$arquivo,$titulo,$resumo,$palavrasChave,$relacaoCom,$componentes,$idRelacaoComSubmissao) {
        $sql = "CALL atualizarSubmissao('$id','$idEvento','$idArea','$idModalidade','$idTipoSubmissao','$idSituacaoSubmissao','$arquivo','$titulo','$resumo','$palavrasChave','$relacaoCom','$componentes','$idRelacaoComSubmissao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    
    }
    public static function cancelarSubmissao($idSubmissao) {
        $sql = "CALL cancelarSubmissao('$idSubmissao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function finalizarSubmissao($id) {
        $sql = "CALL finalizarSubmissao('$id');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosSubmissao($idSubmissao) {
        $sql = "CALL retornaItemPorId('submissao','$idSubmissao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    

    
    public static function listaSubmissoesComFiltro($idEvento,$idModalidade,$idArea,$idSituacao,$idTipo) {
        $sql = "CALL listaSubmissoesComFiltro('$idEvento','$idModalidade','$idArea','$idSituacao','$idTipo');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function existeSubmissaoCorrigida($idSubmissaoParcial) {
        $sql = "CALL existeSubmissaoCorrigida('$idSubmissaoParcial');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function verificarGeracaoNotaFinalSubmissao($idSubmissao) {
        $sql = "CALL verificarGeracaoNotaFinalSubmissao('$idSubmissao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaSubmissaoCorrigidaPelaParcial($idSubmissaoParcial) {
        $sql = "CALL retornaSubmissaoCorrigidaPelaParcial('$idSubmissaoParcial');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaIdUltimaSubmissao() {
        $sql = "CALL retornaIdUltimaSubmissao();";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaSubmissoesParaFinalizar() {
        $sql = "CALL listaSubmissoesComFiltro('','','',3,'');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    
}
