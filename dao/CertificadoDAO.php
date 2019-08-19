<?php

require_once 'Conexao.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CertificadoDao {
    public static function adicionarCertificado ($idEvento,$idUsuario,$idTipoCertificado,$arquivo) {
        $sql = "CALL adicionarCertificado ('$idEvento','$idUsuario','$idTipoCertificado','$arquivo');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function retornaDadosCertificado($idCertificado) {
        $sql = "CALL retornaItemPorId ('certificado','$idCertificado');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
    public static function listaCertificadosComFiltro($idEvento,$idUsuario,$idTipoCertificado) {
        $sql = "CALL listaCertificadosComFiltro('$idEvento','$idUsuario','$idTipoCertificado');";
        //echo $sql; exit(1);
        return Conexao::executar($sql);
    }
}