<?php

require_once dirname(__DIR__). '/dao/UsuarioPedrinaDAO.php';

class UsuarioPedrina {
    
    private $uuid;
    private $permission;
    private $name;
    private $cpf;
    private $email;
    private $picture;
    private $idPerfil;
    
    
    //private $usuario = "admin_expotec";
    //private $senha = "4dm1n3xp0t3c";
            
    function __construct() {
        
    }
    function getId() {
        return $this->uuid;
    }

    function getPermission() {
        return $this->permission;
    }

    function getNome() {
        return $this->name;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getEmail() {
        return $this->email;
    }

    function getPicture() {
        return $this->picture;
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }
    
    function setUuid($uuid) {
        $this->uuid = $uuid;
    }

    function setPermission($permission) {
        $this->permission = $permission;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPicture($picture) {
        $this->picture = $picture;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

        
    public static function retornaDadosUsuario ($idUsuario) {
        
        //$conn = mysqli_connect('localhost', 'root', 'root', 'expotecdb');
        $conn = mysqli_connect('localhost', 'root', 'root', 'sistemadesubmissao');
        mysqli_set_charset($conn, "utf8");
        
      
	$result = mysqli_query($conn, 'SELECT u.uuid, u.name, u.permission, u.email, u.picture, u.cpf_suap FROM User u WHERE u.uuid = ' . $idUsuario);
//	echo $result; exit(1);
        $user = null;
        while ($consulta = mysqli_fetch_array($result)) {
            $user = new UsuarioPedrina();
            $user->setUuid($consulta['uuid']);
            $user->setName($consulta['name']);
            $user->setPermission($consulta['permission']);
            $user->setCpf($consulta['cpf_suap']);
            $user->setEmail($consulta['email']);
            $user->setPicture($consulta['picture']);
            
            if ($user->permission == "ADMIN") $user->setIdPerfil (1);
            else if ($user->permission == "ATTENDEE") $user->setIdPerfil (2);
            else $user->setIdPerfil (3);
        }
        mysqli_close($conn);
        return $user;
    }
    
    public static function listaUsuarios ($filtroNome,$filtroTipoUsuario,$filtroPerfil) {
        
        //$conn = mysqli_connect('localhost', 'root', 'root', 'expotecdb');
        $conn = mysqli_connect('localhost', 'root', 'root', 'sistemadesubmissao');
        mysqli_set_charset($conn, "utf8");
        
        
        $result = mysqli_query($conn, "SELECT u.uuid, u.name, u.permission, u.email, u.picture, u.cpf_suap FROM User u WHERE u.name LIKE '%".$filtroNome."%' ORDER BY name");
        $users = array();
        while ($consulta = mysqli_fetch_array($result)) {
            $user = new UsuarioPedrina();
            $user->setUuid($consulta['uuid']);
            $user->setName($consulta['name']);
            $user->setPermission($consulta['permission']);
            $user->setCpf($consulta['cpf_suap']);
            $user->setEmail($consulta['email']);
            $user->setPicture($consulta['picture']);
            
            if ($user->permission == "ADMIN") $user->setIdPerfil (1);
            else if ($user->permission == "ATTENDEE") $user->setIdPerfil (2);
            else $user->setIdPerfil (3);
            
            array_push($users, $user);
        }
        mysqli_close($conn);
        return $users;
    }
/*    
/*    
    public static function listaAvaliadoresParaCadastro($idEvento,$idArea,$tipo,$limite,$idSubmissao,$tipoAvaliacao) {
        $conn = mysqli_connect('localhost', 'root', 'root', 'expotecdb');
        //$conn = mysqli_connect('localhost', 'admin_expotec', '4dm1n3xp0t3c', 'expotecdb');
        mysqli_set_charset($conn, "utf8");
        
        $sql = "SELECT u.* FROM avaliador u WHERE "
                                        . " u.idEvento = $idEvento AND u.idArea ".$tipo.$idArea." AND "
                                        . " u.id NOT IN (SELECT us.idUsuario FROM submissao s, usuariosdasubmissao us WHERE us.idSubmissao = s.id AND s.id = $idSubmissao) "
                                        . " ORDER BY (SELECT COUNT(*) FROM avaliacao a, submissao s WHERE a.idUsuario = u.id AND a.idSubmissao = s.id AND s.idTipoSubmissao=$tipoAvaliacao),idUsuario";
        
        echo $sql; exit(1);
        $result = mysqli_query($conn, $sql);
        

        
        $users = array();
        while ($consulta = mysqli_fetch_array($result)) {
            $user = UsuarioPedrina::retornaDadosUsuario($consulta['idUsuario']);
            array_push($users, $user);
        }
        mysqli_close($conn);
        return $users;
    } */
}
