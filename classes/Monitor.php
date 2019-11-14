<?php

require_once dirname(__DIR__). '/dao/MonitorDAO.php';

class Monitor {
    private $id;
    private $idEvento;
    private $idUsuario;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }
    
    function getIdEvento() {
        return $this->idEvento;
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

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function adicionarMonitores($idEvento,$idUsuarios) {
        $dado = MonitorDAO::adicionarMonitores($idEvento,$idUsuarios);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    function listaMonitoresComFiltro($idEvento) {
        $retorno = array();
        $dado = MonitorDAO::listaMonitoresComFiltro($idEvento);// CONSULTA O BANCO DE DADOS
        $retorno = Monitor::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Monitor();
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