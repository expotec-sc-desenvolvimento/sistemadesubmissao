<?php

require_once 'Conexao.php';

class EventoDao {
    
    public static function listaEventos(){
        $sql = "CALL listaItens('evento');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function atualizarEvento($id,$logo,$nome,$descricao,$inicioSubmissao,$fimSubmissao,$mediaAprovacaoTrabalhos) {
        $sql = "CALL atualizarEvento('$id','$logo','$nome','$descricao','$inicioSubmissao','$fimSubmissao','$mediaAprovacaoTrabalhos');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function adicionarEvento($logo,$nome,$descricao,$inicioSubmissao,$fimSubmissao,$mediaAprovacaoTrabalhos) {
        $sql = "CALL adicionarEvento('$logo','$nome','$descricao','$inicioSubmissao','$fimSubmissao','$mediaAprovacaoTrabalhos');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function excluirEvento($id) {
        $sql = "CALL excluirItem('evento','$id');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }


    public static function retornaIdUltimoEvento() {
        $sql = "CALL retornaIdUltimoEvento()";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosEvento($idEvento) {
        $sql = "CALL retornaItemPorId('evento','$idEvento')";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function dependenciasEventos($idEvento) {
       $sql = "CALL dependenciasEventos('$idEvento')";
       //echo $sql; exit(1);
        return Conexao::executar($sql);   
    }
    
}
