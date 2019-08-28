<?php

require_once dirname(__DIR__). '/dao/SituacaoSubmissaoDAO.php';

class SituacaoSubmissao {
    private $id;
    private $descricao;
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

        
    public static function adicionarSituacaoSubmissao($id,$descricao) {
        return SituacaoSubmissaoDAO::adicionarSituacaoSubmissao($id,$descricao);
    }
    public static function apagarSituacaoSubmissao($id,$descricao) {
        return SituacaoSubmissaoDAO::apagarSituacaoSubmissao($id,$descricao);
    }
    public static function atualizarSituacaoSubmissao($id,$descricao) {
        return SituacaoSubmissaoDAO::atualizarSituacaoSubmissao($id,$descricao);
    }
    
    public static function retornaDadosSituacaoSubmissao($idSituacao) {
        $situacao = new SituacaoSubmissao();
        $dado = SituacaoSubmissaoDAO::retornaDadosSituacaoSubmissao($idSituacao);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $situacao->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $situacao;
    }
    
    public static function listaSituacaoSubmissao() {
        $retorno = array();
        $dado = SituacaoSubmissaoDAO::listaSituacaoSubmissao();// CONSULTA O BANCO DE DADOS
        $retorno = SituacaoSubmissao::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new SituacaoSubmissao();
                    foreach ($obj as $key => $value) {
                        $novoItem->{$key} = $value;
                    }
                    array_push($retorno, $novoItem);
                }
                
            } catch (Exception $e){
                echo $e->getMessage();
            }
        }
        return $retorno;
    }
}

?>