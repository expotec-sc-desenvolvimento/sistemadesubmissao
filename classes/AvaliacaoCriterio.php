<?php

require_once dirname(__DIR__). '/dao/AvaliacaoCriterioDAO.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AvaliacaoCriterio {
    private $id;
    private $idAvaliacao;
    private $idCriterio;
    private $nota;
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getIdAvaliacao() {
        return $this->idAvaliacao;
    }

    function getIdCriterio() {
        return $this->idCriterio;
    }

    function getNota() {
        return $this->nota;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdAvaliacao($idAvaliacao) {
        $this->idAvaliacao = $idAvaliacao;
    }

    function setIdCriterio($idCriterio) {
        $this->idCriterio = $idCriterio;
    }

    function setNota($nota) {
        $this->nota = $nota;
    }

    public static function retornaCriteriosParaAvaliacao($idAvaliacao) {
        $retorno = array();
        $dado = AvaliacaoCriterioDAO::retornaCriteriosParaAvaliacao($idAvaliacao);
        $retorno = AvaliacaoCriterio::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new AvaliacaoCriterio();
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