<?php

require_once dirname(__DIR__). '/dao/AreaDAO.php';

class Area {
    
    private $id;
    private $descricao;
    private $subAreas;
    
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }
    
    function getDescricao() {
        return $this->descricao;
    }

    function getSubAreas() {
        return $this->subAreas;
    }

    function setId($id) {
        $this->id = $id;
    }
    
    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setSubAreas($subAreas) {
        $this->subAreas = $subAreas;
    }

    public static function adicionarArea($descricao,$subAreas) {
        
        $dado = AreaDao::adicionarArea($descricao,$subAreas);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function excluirArea($id) {

        $dado = AreaDao::excluirArea($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function atualizarArea($idArea, $descricao, $subAreas) {

        $dado = AreaDao::atualizarArea($idArea, $descricao, $subAreas);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function listaAreas() {
        
        $retorno = array();
        $dado = AreaDao::listaAreas();// CONSULTA O BANCO DE DADOS
        $retorno = Area::ListaDeDados($dado);
        
        return $retorno;

    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Area();
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
 
    public static function listaAreasPorEvento($idEvento) {
        $retorno = array();
        $dado = AreaDao::listaAreasPorEvento($idEvento);// CONSULTA O BANCO DE DADOS
        $retorno = Area::ListaDeDados($dado);
        
        return $retorno;
        
    }
    
    public static function retornaDadosArea($idArea) {
        $area = new Area();
        $dado = AreaDao::retornaDadosArea($idArea);
        
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

        
}
    
?>