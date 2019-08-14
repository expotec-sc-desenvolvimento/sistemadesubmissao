<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TipoPrazo {
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
    
    public static function listaTipoPrazo () {
        $retorno = null;
        
        $dado = TipoPrazoDao::listaTipoPrazo();// CONSULTA O BANCO DE DADOS
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new TipoPrazo();
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
    
    
    public static function retornaDadosTipoPrazo($idTipoPrazo) {
        $tipoPrazo = new TipoPrazo();
        $dado = TipoPrazoDao::retornaDadosTipoPrazo($idTipoPrazo);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $tipoPrazo->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $tipoPrazo;
    }
}