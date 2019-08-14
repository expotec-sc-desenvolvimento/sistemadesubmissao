<?php


require_once dirname(__FILE__). '/../dao/UsuariosDaSubmissaoDao.php';

class UsuariosDaSubmissao {
    
    private $id;
    private $idSubmissao;
    private $idUsuario;
    private $isSubmissor;
    
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

    function getIsSubmissor() {
        return $this->isSubmissor;
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

    function setIsSubmissor($isSubmissor) {
        $this->isSubmissor = $isSubmissor;
    }
    
    public static function listaUsuariosDaSubmissaoComFiltro($idSubmissao,$idUsuario,$isSubmissor) {
        $retorno = array();
        $dado = UsuariosDaSubmissaoDAO::listaUsuariosDaSubmissaoComFiltro($idSubmissao,$idUsuario,$isSubmissor);// CONSULTA O BANCO DE DADOS
        $retorno = UsuariosDaSubmissao::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new UsuariosDaSubmissao();
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