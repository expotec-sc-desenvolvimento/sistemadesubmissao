<?php

require_once dirname(__DIR__). '/dao/SubmissaoDAO.php';
require_once dirname(__DIR__). '/classes/Avaliacao.php';
date_default_timezone_set('America/Sao_Paulo');

class Submissao {
    
    private $id;
    private $idEvento;
    private $idArea;
    private $idModalidade;
    private $idTipoSubmissao;
    private $idSituacaoSubmissao;
    private $arquivo;
    private $titulo;
    private $resumo;
    private $palavrasChave;
    private $dataEnvio;
    private $relacaoCom;
    private $nota;
    private $idRelacaoComSubmissao;
    
    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getIdEvento() {
        return $this->idEvento;
    }

    function getIdArea() {
        return $this->idArea;
    }

    function getIdModalidade() {
        return $this->idModalidade;
    }

    function getIdTipoSubmissao() {
        return $this->idTipoSubmissao;
    }

    function getIdSituacaoSubmissao() {
        return $this->idSituacaoSubmissao;
    }

    function getArquivo() {
        return $this->arquivo;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getResumo() {
        return $this->resumo;
    }

    function getPalavrasChave() {
        return $this->palavrasChave;
    }

    function getRelacaoCom() {
        return $this->relacaoCom;
    }

    function getDataEnvio() {
        return $this->dataEnvio;
    }

        function getNota() {
        return $this->nota;
    }

    function getIdRelacaoComSubmissao() {
        return $this->idRelacaoComSubmissao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }

    function setIdArea($idArea) {
        $this->idArea = $idArea;
    }

    function setIdModalidade($idModalidade) {
        $this->idModalidade = $idModalidade;
    }

    function setIdTipoSubmissao($idTipoSubmissao) {
        $this->idTipoSubmissao = $idTipoSubmissao;
    }

    function setIdSituacaoSubmissao($idSituacaoSubmissao) {
        $this->idSituacaoSubmissao = $idSituacaoSubmissao;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setResumo($resumo) {
        $this->resumo = $resumo;
    }

    function setPalavrasChave($palavrasChave) {
        $this->palavrasChave = $palavrasChave;
    }

    function setRelacaoCom($relacaoCom) {
        $this->relacaoCom = $relacaoCom;
    }

    function setDataEnvio($dataEnvio) {
        $this->dataEnvio = $dataEnvio;
    }
    
    function setNota($nota) {
        $this->nota = $nota;
    }

    function setIdRelacaoComSubmissao($idRelacaoComSubmissao) {
        $this->idRelacaoComSubmissao = $idRelacaoComSubmissao;
    }
        
    public static function adicionarSubmissao($idEvento,$idArea,$idModalidade,$idTipoSubmissao,$idSituacaoSubmissao,$arquivo,$titulo,$resumo,$palavrasChave,$relacaoCom,$componentes,$idRelacaoComSubmissao) {
        $dado = SubmissaoDAO::adicionarSubmissao($idEvento,$idArea,$idModalidade,$idTipoSubmissao,$idSituacaoSubmissao,$arquivo,$titulo,$resumo,$palavrasChave,$relacaoCom,$componentes,$idRelacaoComSubmissao);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    public static function cancelarSubmissao($id) {
        $dado = SubmissaoDAO::cancelarSubmissao($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    public static function atualizarSubmissao($id,$idEvento,$idArea,$idModalidade,$idTipoSubmissao,$idSituacaoSubmissao,$arquivo,$titulo,$resumo,$palavrasChave,$relacaoCom,$componentes,$idRelacaoComSubmissao) {
        $dado = SubmissaoDAO::atualizarSubmissao($id,$idEvento,$idArea,$idModalidade,$idTipoSubmissao,$idSituacaoSubmissao,$arquivo,$titulo,$resumo,$palavrasChave,$relacaoCom,$componentes,$idRelacaoComSubmissao);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function finalizarSubmissao($id) {
        $dado = SubmissaoDAO::finalizarSubmissao($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function retornaDadosSubmissao($idSubmissao) {
        $submissao = new Submissao();
        $dado = SubmissaoDAO::retornaDadosSubmissao($idSubmissao);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $submissao->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $submissao;
    }
    
    
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Submissao();
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
    
    public static function listaSubmissoesComFiltro($idEvento,$idModalidade,$idArea,$idSituacao,$idTipo) {
        $retorno = array();
        $dado = SubmissaoDAO::listaSubmissoesComFiltro($idEvento,$idModalidade,$idArea,$idSituacao,$idTipo);// CONSULTA O BANCO DE DADOS
        $retorno = Submissao::ListaDeDados($dado);
        
        return $retorno;
    }
    
    public static function existeSubmissaoCorrigida($idSubmissaoParcial) {
        $dado = SubmissaoDAO::existeSubmissaoCorrigida($idSubmissaoParcial);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function verificarGeracaoNotaFinalSubmissao($idSubmissao) {
        $dado = SubmissaoDAO::verificarGeracaoNotaFinalSubmissao($idSubmissao);
        $resposta = retornaRespostaUnica($dado);
        
        if ($resposta==1) return true;
        else return false;
    }
    
    public static function retornaSubmissaoCorrigidaPelaParcial($idSubmissaoParcial) {
        $submissao = new Submissao();
        $dado = SubmissaoDAO::retornaSubmissaoCorrigidaPelaParcial($idSubmissaoParcial);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $submissao->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $submissao;
    }
    
    
    public static function retornaIdUltimaSubmissao() {
        $dado = SubmissaoDao::retornaIdUltimaSubmissao();
        $resposta = retornaRespostaUnica($dado);
        return $resposta;
    }
    
    public static function retornaSubmissoesParaFinalizar() {
        $retorno = array();
        $resposta = array();
        
        $dado = SubmissaoDAO::retornaSubmissoesParaFinalizar();// CONSULTA O BANCO DE DADOS
        $retorno = Submissao::ListaDeDados($dado);
        
        foreach ($retorno as $submissao) {
            $contAvaliacoesFinalizadas = 0;
            foreach (Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), '') as $aval) {
                if (in_array($aval->getIdSituacaoAvaliacao(), array(2,4,5,6)) && strtotime(date('d-m-Y'))>strtotime($aval->getDataRealizacaoAvaliacao())) {
                    $contAvaliacoesFinalizadas++;
                }
            }    
            if ($contAvaliacoesFinalizadas==3) array_push($resposta,$submissao);
        }

        return $resposta;
    }
} 
    

?>