<?php

require_once dirname(__DIR__). '/dao/TipoSubmissaoDAO.php';

class TipoSubmissao {
    
    private $id;
    private $descricao;
    private $detalhamento;
            
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }
    
    function getDetalhamento() {
        return $this->detalhamento;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDetalhamento($detalhamento) {
        $this->detalhamento = $detalhamento;
    }

    public static function listaTipoSubmissoes() {
        
        $retorno = array();
        $dado = TipoSubmissaoDAO::listaTipoSubmissoes();// CONSULTA O BANCO DE DADOS
        $retorno = TipoSubmissao::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function retornaIdTipoSubmissao($nome) {
        $dado = TipoSubmissaoDao::retornaIdTipoSubmissao($nome);
        $resposta = retornaRespostaUnica($dado);
        return $resposta;
    }
    
    public static function retornaDadosTipoSubmissao($idTipo) {
        $tipo = new TipoSubmissao();
        $dado = TipoSubmissaoDAO::retornaDadosTipoSubmissao($idTipo);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $tipo->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $tipo;
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new TipoSubmissao();
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
