<?php

require_once 'Conexao.php';

class PerfilDao {
        
    public static function listaPerfis(){
        $sql = "CALL listaItens('perfil');";
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosPerfil($idPerfil) {
        $sql = "CALL retornaItemPorId('perfil','$idPerfil');";
        return Conexao::executar($sql);
    }
}
?>