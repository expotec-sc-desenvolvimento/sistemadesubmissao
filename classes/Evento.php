<?php

class Evento {
    private $id;
    private $logo;
    private $nome;
    private $descricao;
    private $inicioSubmissao;
    private $fimSubmissao;
    private $mediaAprovacaoTrabalhos;
    
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getLogo() {
        return $this->logo;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }


    function getInicioSubmissao() {
        return $this->inicioSubmissao;
    }

    function getFimSubmissao() {
        return $this->fimSubmissao;
    }
    
    function getMediaAprovacaoTrabalhos() {
        return $this->mediaAprovacaoTrabalhos;
    }


    function setId($id) {
        $this->id = $id;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setInicioSubmissao($inicioSubmissao) {
        $this->inicioSubmissao = $inicioSubmissao;
    }

    function setFimSubmissao($fimSubmissao) {
        $this->fimSubmissao = $fimSubmissao;
    }
    
    function setMediaAprovacaoTrabalhos($mediaAprovacao) {
        $this->mediaAprovacao = $mediaAprovacaoTrabalhos;
    }


    public static function adicionarEvento($logo,$nome,$descricao,$inicioSubmissao,$fimSubmissao,$mediaAprovacaoTrabalhos) {
        
        $dado = EventoDAO::adicionarEvento($logo,$nome,$descricao,$inicioSubmissao,$fimSubmissao,$mediaAprovacaoTrabalhos);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
    }
    
    public static function excluirEvento($id) {
        $dado = EventoDAO::excluirEvento($id);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;
        
    }
    public static function atualizarEvento($id,$logo,$nome,$descricao,$inicioSubmissao,$fimSubmissao,$mediaAprovacaoTrabalhos) {
        $dado = EventoDAO::atualizarEvento($id,$logo,$nome,$descricao,$inicioSubmissao,$fimSubmissao,$mediaAprovacaoTrabalhos);
        $resposta = retornaRespostaUnica($dado);

        if ($resposta==1) return true;
        else return false;        

    }
    
    public static function listaEventos() {
        
        $retorno = array();
        $dado = EventoDao::listaEventos();// CONSULTA O BANCO DE DADOS
        $retorno = Evento::ListaDeDados($dado);
        
        return $retorno;

    }
       
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Evento();
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
    
    public static function retornaIdUltimoEvento() {
        $dado = EventoDao::retornaIdUltimoEvento();
        $resposta = retornaRespostaUnica($dado);
        return $resposta;
    }
    
    public static function retornaDadosEvento($idEvento) {
        $evento = new Evento();
        $dado = EventoDao::retornaDadosEvento($idEvento);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $evento->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $evento;
    }

   
}