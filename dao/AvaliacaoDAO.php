<?php


require_once 'Conexao.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AvaliacaoDao {

    
    public static function adicionarAvaliacoes ($idSubmissao,$idTipoSubmissao,$idModalidade,$idAvaliadores,$prazo) {
        $sql = "CALL adicionarAvaliacoes ('$idSubmissao','$idTipoSubmissao','$idModalidade','$idAvaliadores','$prazo');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarAvaliacao ($idAvaliacao, $novoAvaliador,$idSituacaoAvaliacao,$prazo) {
        $sql = "CALL atualizarAvaliacao ('$idAvaliacao','$novoAvaliador','$idSituacaoAvaliacao','$prazo');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosAvaliacao($idAvaliacao) {
        $sql = "CALL retornaItemPorId ('avaliacao','$idAvaliacao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function realizarAvaliacao($idAvaliacao,$situacaoAvaliacao,$notas,$notaFinalAvaliacao,$observacao) {
        $sql = "CALL realizarAvaliacao ('$idAvaliacao','$situacaoAvaliacao','$notas','$notaFinalAvaliacao','$observacao');";
       // echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function alterarAvaliador($id,$idNovoAvaliador) {
        $sql = "CALL alterarAvaliador('$id','$idNovoAvaliador');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function listaAvaliacoesComFiltro($idUsuario,$idSubmissao,$idSituacao) {
        $sql = "CALL listaAvaliacoesComFiltro('$idUsuario','$idSubmissao','$idSituacao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function excluirAvaliacao ($idAvaliacao) {
        $sql = "CALL excluirItem('avaliacao','$idAvaliacao');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarSituacaoAvaliacoes() {
        $sql = "CALL atualizarSituacaoAvaliacoes();";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}
    
        
    
?>
