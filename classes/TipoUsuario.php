<?php

require_once dirname(__FILE__). '/../dao/TipoUsuarioDao.php';

class TipoUsuario {
    
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

    public static function listaTipoUsuarios() {
        
        $retorno = array();
        $dado = TipoUsuarioDAO::listaTipoUsuarios();// CONSULTA O BANCO DE DADOS
        $retorno = TipoUsuario::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new TipoUsuario();
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
    
    public static function retornaDadosTipoUsuario($idTipoUsuario) {
        $tipo = new TipoUsuario();
        $dado = TipoUsuarioDao::retornaDadosTipoUsuario($idTipoUsuario);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $tipo->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $tipo;
    }

}
?>
