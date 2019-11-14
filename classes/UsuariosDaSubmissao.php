<?php


require_once dirname(__DIR__). '/dao/UsuariosDaSubmissaoDAO.php';

class UsuariosDaSubmissao {
    
    private $id;
    private $idSubmissao;
    private $idUsuario;
    private $isSubmissor;
    private $apresentouTrabalho;
    private $envioEmailCartaAceite;
    
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
    function getApresentouTrabalho() {
        return $this->apresentouTrabalho;
    }

    function getEnvioEmailCartaAceite() {
        return $this->envioEmailCartaAceite;
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
    
    function setApresentouTrabalho($apresentouTrabalho) {
        $this->apresentouTrabalho = $apresentouTrabalho;
    }
    
    function setEnvioEmailCartaAceite($envioEmailCartaAceite) {
        $this->envioEmailCartaAceite = $envioEmailCartaAceite;
    }
    
    public static function atualizarUsuariosDaSubmissao($id,$idSubmissao,$idUsuario,$isSubmissor,$apresentouTrabalho,$envioEmailCartaAceite) {
        $dado = UsuariosDaSubmissaoDAO::atualizarUsuariosDaSubmissao($id,$idSubmissao,$idUsuario,$isSubmissor,$apresentouTrabalho,$envioEmailCartaAceite);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function listaUsuariosDaSubmissaoComFiltro($idSubmissao,$idUsuario,$isSubmissor,$apresentouTrabalho,$envioEmailCartaAceite) {
        $retorno = array();
        $dado = UsuariosDaSubmissaoDAO::listaUsuariosDaSubmissaoComFiltro($idSubmissao,$idUsuario,$isSubmissor,$apresentouTrabalho,$envioEmailCartaAceite);// CONSULTA O BANCO DE DADOS
        $retorno = UsuariosDaSubmissao::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function retornaDadosUsuariosDaSubmissao($idUsuarioDaSubmissao) {
        $usuarioDaSubmissao = new UsuariosDaSubmissao();
        $dado = UsuariosDaSubmissaoDAO::retornaDadosUsuariosDaSubmissao($idUsuarioDaSubmissao);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $usuarioDaSubmissao->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $usuarioDaSubmissao;
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