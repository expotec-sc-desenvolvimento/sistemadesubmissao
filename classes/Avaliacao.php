<?php

require_once dirname(__FILE__). '/../dao/AvaliacaoDAO.php';

class Avaliacao {
    private $id;
    private $idSubmissao;
    private $idUsuario;
    private $idSituacaoAvaliacao;
    private $nota;
    private $observacao;
    private $prazo;
            
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getIdSubmissao() {
        return $this->idSubmissao;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getIdSituacaoAvaliacao() {
        return $this->idSituacaoAvaliacao;
    }

    function getNota() {
        return $this->nota;
    }

    function getObservacao() {
        return $this->observacao;
    }
    
    function getPrazo() {
        return $this->prazo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdSubmissao($idSubmissao) {
        $this->idSubmissao = $idSubmissao;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setIdSituacaoAvaliacao($idSituacaoAvaliacao) {
        $this->idSituacaoAvaliacao = $idSituacaoAvaliacao;
    }

    function setNota($nota) {
        $this->nota = $nota;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }
    
    function setPrazo($prazo) {
        $this->prazo = $prazo;
    }

    public static function atualizarAvaliacao ($idAvaliacao, $novoAvaliador,$idSituacaoAvaliacao,$prazo) {
        $dado = AvaliacaoDAO::atualizarAvaliacao($idAvaliacao, $novoAvaliador,$idSituacaoAvaliacao,$prazo);
        $resposta = retornaRespostaUnica($dado);
        return $resposta;
    }

    public static function adicionarAvaliacoes ($idSubmissao,$idTipoSubmissao,$idModalidade,$idAvaliadores,$prazo) {
        $dado = AvaliacaoDAO::adicionarAvaliacoes ($idSubmissao,$idTipoSubmissao,$idModalidade,$idAvaliadores,$prazo);
        $resposta = retornaRespostaUnica($dado);
        return $resposta;
    }

    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Avaliacao();
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
    
    public static function retornaDadosAvaliacao($idAvaliacao) {
        $avaliacao = new Avaliacao();
        $dado = AvaliacaoDao::retornaDadosAvaliacao($idAvaliacao);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $avaliacao->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $avaliacao;
    }
    
    public static function realizarAvaliacao($idAvaliacao,$situacaoAvaliacao,$notas,$notaFinalAvaliacao,$observacao) {
        $dado = AvaliacaoDAO::realizarAvaliacao($idAvaliacao,$situacaoAvaliacao,$notas,$notaFinalAvaliacao,$observacao);
        $resposta = retornaRespostaUnica($dado);
        return $resposta;
    }

    public static function alterarAvaliador($id,$idNovoAvaliador) {
        $dado = AvaliacaoDao::alterarAvaliador($id,$idNovoAvaliador);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function listaAvaliacoesComFiltro($idUsuario,$idSubmissao,$idSituacao) {
        $retorno = array();
        $dado = AvaliacaoDAO::listaAvaliacoesComFiltro($idUsuario,$idSubmissao,$idSituacao);// CONSULTA O BANCO DE DADOS
        $retorno = Avaliacao::ListaDeDados($dado);
        
        return $retorno;
    }
    public static function excluirAvaliacao ($idAvaliacao) {
        $dado = AvaliacaoDao::excluirAvaliacao($idAvaliacao);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
}
?>