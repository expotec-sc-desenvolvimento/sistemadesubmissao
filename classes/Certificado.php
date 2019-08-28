<?php

require_once dirname(__DIR__). '/dao/CertificadoDAO.php';

class Certificado {
    private $id;
    private $idEvento;
    private $idUsuario;
    private $idTipoCertificado;
    private $arquivo;
    
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

    function getIdTipoCertificado() {
        return $this->idTipoCertificado;
    }

    function getArquivo() {
        return $this->arquivo;
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

    function setIdTipoCertificado($idTipoCertificado) {
        $this->idTipoCertificado = $idTipoCertificado;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

    public static function adicionarCertificado($idEvento,$idUsuario,$idTipoCertificado,$arquivo) {

        $dado = CertificadoDAO::adicionarCertificado($idEvento,$idUsuario,$idTipoCertificado,$arquivo);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function listaCertificadosComFiltro($idEvento,$idUsuario,$idTipoCertificado) {
        $retorno = array();
        $dado = CertificadoDAO::listaCertificadosComFiltro($idEvento,$idUsuario,$idTipoCertificado);// CONSULTA O BANCO DE DADOS
        $retorno = Certificado::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function retornaDadosCertificado($idCertificado) {
        $certificado = new Certificado();
        $dado = CertificadoDao::retornaDadosCertificado($idCertificado);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $certificado->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $certificado;
    }
    
    public static function ListaDeDados($dado) {
        
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Certificado();
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
