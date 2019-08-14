<?php

require_once dirname(__FILE__). '/../dao/PrazosEventoDao.php';

class PrazosEvento {
    private $id;
    private $idEvento;
    private $idTipoPrazo;
    private $dias;
    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getIdEvento() {
        return $this->idEvento;
    }

    function getIdTipoPrazo() {
        return $this->idTipoPrazo;
    }

    function getDias() {
        return $this->dias;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }

    function setIdTipoPrazo($idTipoPrazo) {
        $this->idTipoPrazo = $idTipoPrazo;
    }

    function setDias($dias) {
        $this->dias = $dias;
    }

    public static function adicionarPrazosEvento($idEvento,$idTipoPrazo,$dias) {
        $dado = PrazosEventoDAO::adicionarPrazosEvento($idEvento,$idTipoPrazo,$dias);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function excluirPrazosEvento($id) {
        $dado = PrazosEventoDao::excluirPrazosEvento($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function atualizarPrazosEvento($id,$idEvento,$idTipoPrazo,$dias) {

        $dado = PrazosEventoDao::atualizarPrazosEvento($id,$idEvento,$idTipoPrazo,$dias);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
        
    }
    
    public static function retornaDadosPrazosEvento($idPrazosEvento) {
        $prazoEvento = new PrazosEvento();
        $dado = PrazosEventoDAO::retornaDadosPrazosEvento($idPrazosEvento);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $prazoEvento->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $prazoEvento;
    }
    
    public static function listaPrazosEventoComFiltro($idEvento,$idTipoPrazo) {
        $retorno = array();
        $dado = PrazosEventoDAO::listaPrazosEventoComFiltro($idEvento,$idTipoPrazo);// CONSULTA O BANCO DE DADOS
        $retorno = PrazosEvento::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new PrazosEvento();
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
    
    public static function retornaIdPrazosEvento($idEvento,$idTipoPrazo) {
        
        $dado = PrazosEventoDAO::retornaIdPrazosEvento($idEvento,$idTipoPrazo);
        $resposta = retornaRespostaUnica($dado);
        return $resposta;

    }
    
}
?>