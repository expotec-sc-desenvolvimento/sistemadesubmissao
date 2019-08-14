<?php


require_once dirname(__FILE__). '/../dao/AreaEventoDAO.php';

class AreaEvento {
    private $id;
    private $idEvento;
    private $idArea;
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getIdEvento() {
        return $this->idEvento;
    }

    function getIdArea() {
        return $this->idArea;
    }

        
    function setId($id) {
        $this->id = $id;
    }

    function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }

    function setIdArea($idArea) {
        $this->idArea = $idArea;
    }

    public static function adicionarAreaEvento($idEvento,$idArea) {

        $dado = AreaEventoDao::adicionarAreaEvento($idEvento,$idArea);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function excluirAreaEvento($id) {
        $dado = AreaEventoDao::excluirAreaEvento($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function atualizarAreaEvento($id,$idEvento,$idArea) {

        $dado = AreaEventoDao::atualizarAreaEvento($id,$idEvento,$idArea);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
        
    }
    
    public static function retornaDadosAreaEvento($idAreaEvento) {
        $area = new AreaEvento();
        $dado = AreaEventoDAO::retornaDadosAreaEvento($idAreaEvento);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $area->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $area;
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new AreaEvento();
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
    
    public static function retornaIdAreaEvento($idEvento,$idArea) {
        $dado = AreaEventoDAO::retornaIdAreaEvento($idEvento,$idArea);
        $resposta = retornaRespostaUnica($dado);
        return $resposta;
    }
    
    public static function listaAreaEventoComFiltro($idArea,$idEvento) {
        $retorno = array();
        $dado = AreaEventoDAO::listaAreaEventoComFiltro($idArea,$idEvento);// CONSULTA O BANCO DE DADOS
        $retorno = AreaEvento::ListaDeDados($dado);
        
        return $retorno;
    }
}
