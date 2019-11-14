<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Conexao.php';

class TipoUsuarioDao {
    public static function listaTipoUsuarios() {
        
        $sql = "CALL listaItens('tipousuario');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosTipoUsuario($idTipoUsuario) {
        $sql = "CALL retornaItemPorId('tipousuario','$idTipoUsuario');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}