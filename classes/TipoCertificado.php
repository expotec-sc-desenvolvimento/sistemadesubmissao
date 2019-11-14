<?php

require_once dirname(__DIR__). '/dao/TipoCertificadoDAO.php';

class TipoCertificado {
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

    public static function listaTipoCertificado () {
        $retorno = null;
        
        $dado = TipoCertificadoDao::listaTipoCertificado();// CONSULTA O BANCO DE DADOS
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new TipoCertificado();
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
    
    
    public static function retornaDadosTipoCertificado($idTipoCertificado) {
        $tipoCertificado = new TipoCertificado();
        $dado = TipoCertificadoDao::retornaDadosTipoCertificado($idTipoCertificado);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $tipoCertificado->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $tipoCertificado;
    }
}

