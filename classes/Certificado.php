<?php

require_once dirname(__DIR__). '/dao/CertificadoDAO.php';

class Certificado {
    private $id;
    private $tipoCertificado;
    private $idUsuario;
    private $arquivo;
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getTipoCertificado() {
        return $this->tipoCertificado;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getArquivo() {
        return $this->arquivo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipoCertificado($tipoCertificado) {
        $this->tipoCertificado = $tipoCertificado;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

    public static function adicionarCertificado($tipoCertificado,$idUsuario,$arquivo) {

        $dado = CertificadoDAO::adicionarCertificado($tipoCertificado,$idUsuario,$arquivo);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function excluirCertificado($id) {

        $dado = CertificadoDAO::excluirCertificado($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function listaCertificadosComFiltro($tipoCertificado,$idUsuario) {
        $retorno = array();
        $dado = CertificadoDAO::listaCertificadosComFiltro($tipoCertificado,$idUsuario);// CONSULTA O BANCO DE DADOS
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
