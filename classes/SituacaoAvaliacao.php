<?php


require_once dirname(__DIR__). '/dao/SituacaoAvaliacaoDAO.php';

class SituacaoAvaliacao {
    
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

    public static function retornaDadosSituacaoAvaliacao($idSituacao) {
        $situacao = new SituacaoAvaliacao();
        $dado = SituacaoAvaliacaoDAO::retornaDadosSituacaoAvaliacao($idSituacao);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $situacao->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $situacao;
    }
    
    public static function listaSituacaoAvaliacao() {
        $retorno = array();
        $dado = SituacaoAvaliacaoDAO::listaSituacaoAvaliacao();// CONSULTA O BANCO DE DADOS
        $retorno = SituacaoAvaliacao::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new SituacaoAvaliacao();
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
?>