<?php

require_once 'Conexao.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CertificadoDao {
    public static function adicionarCertificado($tipoCertificado,$idUsuario,$arquivo) {
        $sql = "CALL adicionarCertificado ('$tipoCertificado','$idUsuario','$arquivo');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function excluirCertificado($id) {
        $sql = "CALL excluirItem ('certificado','$id');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    
    public static function retornaDadosCertificado($idCertificado) {
        $sql = "CALL retornaItemPorId ('certificado','$idCertificado');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function listaCertificadosComFiltro($idTipoCertificado,$idUsuario) {
        $sql = "CALL listaCertificadosComFiltro('$idTipoCertificado','$idUsuario');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}