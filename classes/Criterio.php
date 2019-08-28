<?php

require_once dirname(__DIR__). '/dao/CriterioDAO.php';

class Criterio {
    
    private $id;
    private $idModalidade;
    private $idTipoSubmissao;
    private $descricao;
    private $detalhamento;
    private $peso;
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getIdModalidade() {
        return $this->idModalidade;
    }

    function getIdTipoSubmissao() {
        return $this->idTipoSubmissao;
    }

        
    function getDescricao() {
        return $this->descricao;
    }

    function getDetalhamento() {
        return $this->detalhamento;
    }
    
    function getPeso() {
        return $this->peso;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdModalidade($idModalidade) {
        $this->idModalidade = $idModalidade;
    }
    
    function setIdTipoSubmissao($idTipoSubmissao) {
        $this->idTipoSubmissao = $idTipoSubmissao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDetalhamento($detalhamento) {
        $this->detalhamento = $detalhamento;
    }
    
    function setPeso($peso) {
        $this->peso = $peso;
    }

    public static function adicionarCriterio($idModalidade,$idTipoSubmissao,$descricao,$detalhamento,$peso) {        
        
        $dado = CriterioDAO::adicionarCriterio($idModalidade,$idTipoSubmissao,$descricao,$detalhamento,$peso);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    public static function excluirCriterio($id) {
        
        $dado = CriterioDAO::excluirCriterio($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    public static function atualizarCriterio($id,$descricao,$detalhamento,$peso) {

        $dado = CriterioDAO::atualizarCriterio($id,$descricao,$detalhamento,$peso);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    
    public static function listaCriteriosComFiltro($idModalidade,$idTipoSubmissao) {
        $retorno = new Criterio();
        $dado = CriterioDao::listaCriteriosComFiltro($idModalidade,$idTipoSubmissao);// CONSULTA O BANCO DE DADOS
        $retorno = Criterio::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Criterio();
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
    
    public static function retornaDadosCriterio($id) {
        $criterio = new Criterio();
        $dado = CriterioDao::retornaDadosCriterio($id);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $criterio->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $criterio;
    }
    
    
    
}
?>
