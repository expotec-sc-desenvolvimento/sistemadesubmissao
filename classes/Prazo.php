<?php

require_once dirname(__FILE__). '/../dao/PrazoDAO.php';

class Prazo {
    private $id;
    private $idPrazoEvento;
    private $idEntidade;
    private $dataFinal;
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getIdPrazoEvento() {
        return $this->idPrazoEvento;
    }

    function getIdEntidade() {
        return $this->idEntidade;
    }

    function getDataFinal() {
        return $this->dataFinal;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdPrazoEvento($idPrazoEvento) {
        $this->idPrazoEvento = $idPrazoEvento;
    }

    function setIdEntidade($idEntidade) {
        $this->idEntidade = $idEntidade;
    }

    function setDataFinal($dataFinal) {
        $this->dataFinal = $dataFinal;
    }

        
    public static function adicionarPrazo($idPrazoEvento,$idEntidade,$dataFinal) {
        
        $dado = PrazoDAO::adicionarPrazo(idPrazoEvento,$idEntidade,$dataFinal);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function excluirPrazo($id) {
        
        $dado = PrazoDAO::excluirPrazo($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function atualizarPrazo($id,$idPrazoEvento,$idEntidade,$dataFinal) {

        $dado = PrazoDAO::atualizarPrazo($id,$idPrazoEvento,$idEntidade,$dataFinal);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function retornaDadosPrazo($id) {
        $prazo = new Prazo();
        $dado = PrazoDao::retornaDadosPrazo($id);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $prazo->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $prazo;
    }
    
    public static function retornaDadosPrazoPorTipoEntidade($idTipoPrazo,$idEntidade) {
        $prazo = new Prazo();
        $dado = PrazoDao::retornaDadosPrazoPorTipoEntidade($idTipoPrazo,$idEntidade);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $prazo->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $prazo;
    }
   
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Prazo();
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
    
    public static function listaPrazosComFiltro($idPrazoEvento,$idEntidade) {
        $retorno = array();
        $dado = PrazoDAO::listaPrazosComFiltro($idPrazoEvento,$idEntidade);// CONSULTA O BANCO DE DADOS
        $retorno = Prazo::ListaDeDados($dado);
        
        return $retorno;
    }

}

