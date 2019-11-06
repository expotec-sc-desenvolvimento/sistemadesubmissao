<?php

require_once dirname(__DIR__). '/dao/AvaliadorDAO.php';

class Avaliador {
    
    private $id;
    private $idEvento;
    private $idArea;
    private $idUsuario;
    
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

    function getIdUsuario() {
        return $this->idUsuario;
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

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

        
    public static function adicionarAvaliador($idEvento,$idArea,$idUsuarios) {
        $dado = AvaliadorDAO::adicionarAvaliador($idEvento,$idArea,$idUsuarios);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    public static function excluirAvaliador($id) {
        $dado = AvaliadorDAO::excluirAvaliador($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    public static function atualizarAvaliador($id,$idEvento,$idArea,$idUsuario) {
        $dado = AvaliadorDAO::atualizarAvaliador($id,$idEvento,$idArea,$idUsuario);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function retornaDadosAvaliador($idAvaliador) {
        $avaliador = new Avaliador();
        $dado = AvaliadorDAO::retornaDadosAvaliador($idAvaliador);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $avaliador->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $avaliador;
    }
    

    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Avaliador();
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
    
    public static function listaAvaliadoresComFiltro($idEvento,$idArea,$idUsuario,$tipo) {
        $retorno = array();
        $dado = AvaliadorDAO::listaAvaliadoresComFiltro($idEvento,$idArea,$idUsuario,$tipo);// CONSULTA O BANCO DE DADOS
        $retorno = Avaliador::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function listaAvaliadoresParaCadastro($idEvento,$idArea,$tipo,$limite,$idSubmissao) {
        $retorno = array();
        
        $dado = AvaliadorDao::listaAvaliadoresParaCadastro($idEvento,$idArea,$tipo,$limite,$idSubmissao);// CONSULTA O BANCO DE DADOS
        $retorno = Avaliador::ListaDeDados($dado);
        return $retorno;
    }
   
}
?>
