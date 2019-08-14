<?php

include dirname(__FILE__) . '/../inc/includes.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_GET['nome'])) {
    
    $usuarios = Usuario::listaUsuarios($_GET['nome'], "", -1);
    
    $idSubmissor = "";
    if (isset($_GET['idSubmissor'])) $idSubmissor = $_GET['idSubmissor'];
    
    $resposta = "";
    foreach ($usuarios as $usuario) {
        
        $idUsuario = $usuario->getId();
        
        if ($idUsuario == $idSubmissor) continue;
        
        $nomeCompleto = $usuario->getNome() . " " . $usuario->getSobrenome();
        
        $resposta = $resposta . "<input type='hidden' id='". $idUsuario."' value='". $idUsuario ."'>"
                                . "<div id='users-dinamic' onclick=\"javascript:adicionarId('".$usuario->getId()."','".$nomeCompleto ."','$iconExcluir')\">" 
                                  . "<img src='".$pastaFotosPerfil . $usuario->getImagem()."' width='25px'> "  . $nomeCompleto . "</div>";
    }
    
    echo $resposta;
    
}
else {
    echo "não";
}
