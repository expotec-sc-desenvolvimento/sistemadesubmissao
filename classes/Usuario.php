<?php

require_once dirname(__DIR__). '/dao/UsuarioDAO.php';


class Usuario {

    private $id;
    private $idPerfil;
    private $cpf;
    private $nome;
    private $sobrenome;
    private $dataNascimento;
    private $email;
    private $idTipoUsuario;
    private $imagem;
    private $isCredenciado;
    private $dataCredeciamento;
    
            
    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getNome() {
        return $this->nome;
    }

    function getSobrenome() {
        return $this->sobrenome;
    }

    function getDataNascimento() {
        return $this->dataNascimento;
    }

    function getEmail() {
        return $this->email;
    }

    function getIdTipoUsuario() {
        return $this->idTipoUsuario;
    }

    function getImagem() {
        return $this->imagem;
    }

    function getIsCredenciado() {
        return $this->isCredenciado;
    }
    
    function getDataCredeciamento() {
        return $this->dataCredeciamento;
    }

    function setId($id) {
        $this->idUsuario = $id;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setIdTipoUsuario($idTipoUsuario) {
        $this->idTipoUsuario = $idTipoUsuario;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    function setIsCredenciado($isCredenciado) {
        $this->isCredenciado = $isCredenciado;
    }
    
    function setDataCredeciamento($dataCredeciamento) {
        $this->dataCredeciamento = $dataCredeciamento;
    }
    

    public static function login($cpf,$senha) {
        
        $usuario = null;
        
        $dado = UsuarioDao::login($cpf, $senha);// CONSULTA O BANCO DE DADOS
        if($dado != null){
            $usuario = new Usuario();
            try{
                foreach ($dado as $obj){
                    foreach ($obj as $key => $value) {
                        $usuario->{$key} = $value;
                    }
                }
            } catch (Exception $e){
                $usuario = null;
                $mensagem[] = $e->getMessage();
            }
        }
        return $usuario;
    }


    public function getPerfil() {
        $dado =  UsuarioDao::getPerfil($this->idPerfil);
        $resposta = retornaRespostaUnica($dado);
        return $resposta;
        
    }

    public function alterarSenha($idUsuario,$senhaAntiga, $novaSenha) {

        $dado = UsuarioDao::alterarSenha($idUsuario, $senhaAntiga, $novaSenha);
        $resposta = retornaRespostaUnica($dado);
        
        if ($resposta==1) return true;
        else return false;

    }
    
    
    public static function recuperarSenha ($cpf,$email,$senha) {
        $dado = UsuarioDao::recuperarSenha($cpf, $email,$senha);
        $resposta = retornaRespostaUnica($dado);
        
        if ($resposta==1) return true;
        else return false;
    }
    
    

    public static function listaUsuarios($filtroNome,$filtroTipoUsuario,$filtroPerfil) {
    
        $retorno = array();
        
        $dado = UsuarioDao::listaUsuarios($filtroNome,$filtroTipoUsuario,$filtroPerfil);// CONSULTA O BANCO DE DADOS
        $retorno = Usuario::ListaDeDados($dado);
        return $retorno;
        
    }

    
    public static function atualizarUsuario($idUsuario,$perfil,$cpf,$nome,$sobrenome,$dataNascimento,$email,$tipoUsuario) {
        
        $dado = UsuarioDao::atualizarUsuario($idUsuario,$perfil,$cpf,$nome,$sobrenome,$dataNascimento,$email,$tipoUsuario);
        $resposta = retornaRespostaUnica($dado);
        
        if ($resposta==1) return true;
        else return false;

    }
    
    public static function adicionarUsuario($perfil,$cpf,$nome,$sobrenome,$senha,$dataNascimento,$email,$tipoUsuario,$foto) {
        
        $dado = UsuarioDao::adicionarUsuario($perfil,$cpf,$nome,$sobrenome,$senha,$dataNascimento,$email,$tipoUsuario,$foto);
        $resposta = retornaRespostaUnica($dado);
        
        if ($resposta==1) return true;
        else return false;

    }
    
    public static function excluirUsuario($idUsuario) {
        $dado = UsuarioDao::excluirUsuario($idUsuario);
        $resposta = retornaRespostaUnica($dado);
        
        if ($resposta==1) return true;
        else return false;
    }

    
    public static function retornaDadosUsuario ($idUsuario) {
        $usuario = new Usuario();
        $dado = UsuarioDao::retornaDadosUsuario($idUsuario);
        
        try{
            foreach ($dado as $obj){
                foreach ($obj as $key => $value) 
                    $usuario->{$key} = $value;
                
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }
        
        return $usuario;        
    }
    
    public static function setarSenha($idUsuario,$senha) {
        return UsuarioDao::setarSenha($idUsuario, $senha);
    }
    
    public static function ListaDeDados($dado) {
        
        $retorno = array();
        if($dado != null){
            $retorno = array();
            try{
                foreach ($dado as $obj){
                    $novoItem = new Usuario();
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
    
    public static function listaAvaliadoresParaCadastro($idEvento,$idArea,$tipo,$limite,$idSubmissao) {
        $retorno = array();
        
        $dado = UsuarioDao::listaAvaliadoresParaCadastro($idEvento,$idArea,$tipo,$limite,$idSubmissao);// CONSULTA O BANCO DE DADOS
        $retorno = Usuario::ListaDeDados($dado);
        return $retorno;
    }
   
}
