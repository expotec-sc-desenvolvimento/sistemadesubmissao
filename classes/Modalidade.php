<?php


require_once dirname(__FILE__). '/../dao/ModalidadeDAO.php';


class Modalidade {
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

    function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    
    public static function adicionarModalidade($descricao) {

        $dado = ModalidadeDAO::adicionarModalidade($descricao);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function excluirModalidade($id) {

        $dado = ModalidadeDAO::excluirModalidade($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    public static function atualizarModalidade($id,$descricao) {

        $dado = ModalidadeDAO::atualizarModalidade($id,$descricao);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }

    public static function listaModalidades() {
        
        $retorno = array();
        $dado = ModalidadeDAO::listaItens("modalidade");// CONSULTA O BANCO DE DADOS
        $retorno = Modalidade::ListaDeDados($dado);
        
        return $retorno;

    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Modalidade();
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
// REVER TODOS OS CODIGOS ABAIXO
    
    public static function listaModalidadesPorEvento($idEvento) {
        
        $retorno = array();
        $dado = ModalidadeDAO::listaModalidadesPorEvento($idEvento);// CONSULTA O BANCO DE DADOS
        $retorno = Modalidade::ListaDeDados($dado);
        
        return $retorno;

    }
    
    
    
    public static function retornaDadosModalidade($idModalidade) {
        $modalidade = new Modalidade();
        $dado = ModalidadeDAO::retornaDadosModalidade($idModalidade);
        
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
    
}
?>