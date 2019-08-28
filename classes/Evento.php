<?php

require_once dirname(__DIR__). '/dao/EventoDAO.php';

class Evento {
    private $id;
    private $logo;
    private $nome;
    private $descricao;
    private $inicioSubmissao;
    private $fimSubmissao;
    private $prazoFinalEnvioAvaliacaoParcial;
    private $prazoFinalEnvioSubmissaoCorrigida;
    private $prazoFinalEnvioAvaliacaoCorrigida;
    private $prazoFinalEnvioAvaliacaoFinal;
    private $distribuicaoAutomaticaAvaliadores;
    
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
    
    function getPrazoFinalEnvioAvaliacaoParcial() {
        return $this->prazoFinalEnvioAvaliacaoParcial;
    }

    function getPrazoFinalEnvioSubmissaoCorrigida() {
        return $this->prazoFinalEnvioSubmissaoCorrigida;
    }

    function getPrazoFinalEnvioAvaliacaoCorrigida() {
        return $this->prazoFinalEnvioAvaliacaoCorrigida;
    }

    function getPrazoFinalEnvioAvaliacaoFinal() {
        return $this->prazoFinalEnvioAvaliacaoFinal;
    }

    function getDistribuicaoAutomaticaAvaliadores() {
        return $this->distribuicaoAutomaticaAvaliadores;
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
    
    function setPrazoFinalEnvioAvaliacaoParcial($prazoFinalEnvioAvaliacaoParcial) {
        $this->prazoFinalEnvioAvaliacaoParcial = $prazoFinalEnvioAvaliacaoParcial;
    }

    function setPrazoFinalEnvioSubmissaoCorrigida($prazoFinalEnvioSubmissaoCorrigida) {
        $this->prazoFinalEnvioSubmissaoCorrigida = $prazoFinalEnvioSubmissaoCorrigida;
    }

    function setPrazoFinalEnvioAvaliacaoCorrigida($prazoFinalEnvioAvaliacaoCorrigida) {
        $this->prazoFinalEnvioAvaliacaoCorrigida = $prazoFinalEnvioAvaliacaoCorrigida;
    }

    function setPrazoFinalEnvioAvaliacaoFinal($prazoFinalEnvioAvaliacaoFinal) {
        $this->prazoFinalEnvioAvaliacaoFinal = $prazoFinalEnvioAvaliacaoFinal;
    }

    function setDistribuicaoAutomaticaAvaliadores($distribuicaoAutomaticaAvaliadores) {
        $this->distribuicaoAutomaticaAvaliadores = $distribuicaoAutomaticaAvaliadores;
    }

    public static function adicionarEvento($logo,$nome,$descricao,$inicioSubmissao,$fimSubmissao,$prazoFinalEnvioAvaliacaoParcial,$prazoFinalEnvioSubmissaoCorrigida,
                                           $prazoFinalEnvioAvaliacaoCorrigida, $prazoFinalEnvioAvaliacaoFinal, $distribuicaoAutomaticaAvaliadores) {
        
        $dado = EventoDAO::adicionarEvento($logo,$nome,$descricao,$inicioSubmissao,$fimSubmissao,$prazoFinalEnvioAvaliacaoParcial,$prazoFinalEnvioSubmissaoCorrigida,
                                           $prazoFinalEnvioAvaliacaoCorrigida, $prazoFinalEnvioAvaliacaoFinal, $distribuicaoAutomaticaAvaliadores);
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
    public static function atualizarEvento($id,$logo,$nome,$descricao,$inicioSubmissao,$fimSubmissao,$prazoFinalEnvioAvaliacaoParcial,$prazoFinalEnvioSubmissaoCorrigida,
                                           $prazoFinalEnvioAvaliacaoCorrigida, $prazoFinalEnvioAvaliacaoFinal, $distribuicaoAutomaticaAvaliadores) {
        
        $dado = EventoDAO::atualizarEvento($id,$logo,$nome,$descricao,$inicioSubmissao,$fimSubmissao,$prazoFinalEnvioAvaliacaoParcial,$prazoFinalEnvioSubmissaoCorrigida,
                                           $prazoFinalEnvioAvaliacaoCorrigida, $prazoFinalEnvioAvaliacaoFinal, $distribuicaoAutomaticaAvaliadores);
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