<?php

require_once dirname(__DIR__). '/dao/PerfilDAO.php';

class Perfil {
    private $id;
    private $descricao;
    
    function __construct() {
        
    }

    
    function getId () {
        return $this->id;
    }
    
    function getDescricao () {
        return $this->descricao;
    }
    function setId ($id) {
        $this->id = $id;
    }
    
    function setDescricao ($descricao) {
        $this->descricao = $descricao;
    }

    public static function listaPerfis () {
        $retorno = null;
        
        $dado = PerfilDao::listaPerfis();// CONSULTA O BANCO DE DADOS
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Perfil();
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
    
    
    public static function retornaDadosPerfil($idPerfil) {
        $perfil = new Perfil();
        $dado = PerfilDao::retornaDadosPerfil($idPerfil);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $perfil->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $perfil;
    }
}

?>