<?php


require_once dirname(__DIR__). '/dao/ModalidadeEventoDAO.php';


class ModalidadeEvento {
    private $id;
    private $idEvento;
    private $idModalidade;
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getIdEvento() {
        return $this->idEvento;
    }

    function getIdModalidade() {
        return $this->idModalidade;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }

    function setIdModalidade($idModalidade) {
        $this->idModalidade = $idModalidade;
    }

    public static function adicionarModalidadeEvento($idEvento,$idModalidade) {

        $dado = ModalidadeEventoDao::adicionarModalidadeEvento($idEvento,$idModalidade);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function excluirModalidadeEvento($id) {
        $dado = ModalidadeEventoDao::excluirModalidadeEvento($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function atualizarModalidadeEvento($id,$idEvento,$idModalidade) {
        $dado = ModalidadeEventoDao::adicionarModalidadeEvento($id,$idEvento,$idModalidade);
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
                    $novoItem = new ModalidadeEvento();
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
    public static function retornaDadosModalidadeEvento($idModalidade) {
        $modalidade = new ModalidadeEvento();
        $dado = ModalidadeEventoDAO::retornaDadosModalidadeEvento($idModalidade);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $modalidade->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $modalidade;
    }
    
    public static function retornaIdModalidadeEvento($idEvento,$idModalidade) {
        $dado = ModalidadeEventoDAO::retornaIdModalidadeEvento($idEvento,$idModalidade);
        $resposta = retornaRespostaUnica($dado);
        return $resposta;
    }
    
    public static function listaModalidadeEventoComFiltro($idModalidade,$idEvento) {
        $retorno = array();
        $dado = ModalidadeEventoDAO::listaModalidadeEventoComFiltro($idModalidade,$idEvento);// CONSULTA O BANCO DE DADOS
        $retorno = ModalidadeEvento::ListaDeDados($dado);
        
        return $retorno;
    }
    
}
