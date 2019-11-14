<?php

require_once dirname(__DIR__). '/dao/SolicitacaoAvaliadorDAO.php';

class SolicitacaoAvaliador {
    
    private $id;
    private $idUsuario;
    private $idEvento;
    private $idArea;
    private $situacao;
    private $observacao;
    
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

    function getSituacao() {
        return $this->situacao;
    }
    
    function getObservacao() {
        return $this->observacao;
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

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }
        
    public static function adicionarSolicitacaoAvaliador($idUsuario,$idEvento,$idArea) {
        $dado = SolicitacaoAvaliadorDAO::adicionarSolicitacaoAvaliador($idUsuario,$idEvento,$idArea);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;  
    }
    public static function excluirSolicitacaoAvaliador($id) {
        $dado = SolicitacaoAvaliadorDAO::excluirSolicitacaoAvaliador($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;  
    }
    public static function atualizarSolicitacaoAvaliador($id,$idUsuario,$idEvento,$idArea,$situacao,$observacao) {
        $dado = SolicitacaoAvaliadorDAO::atualizarSolicitacaoAvaliador($id,$idUsuario,$idEvento,$idArea,$situacao,$observacao);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;  
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new SolicitacaoAvaliador();
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
    
    public static function listaSolicitacaoAvaliadorComFiltro($idUsuario,$idEvento,$idArea,$situacao) {
        $retorno = array();
        $dado = SolicitacaoAvaliadorDao::listaSolicitacaoAvaliadorComFiltro($idUsuario,$idEvento,$idArea,$situacao);// CONSULTA O BANCO DE DADOS
        $retorno = SolicitacaoAvaliador::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function retornaDadosSolicitacoesAvaliador($idSolicitacao) {
        $solicitacao = new SolicitacaoAvaliador();
        $dado = SolicitacaoAvaliadorDAO::retornaDadosSolicitacoesAvaliador($idSolicitacao);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $solicitacao->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $solicitacao;
    }
}
?>