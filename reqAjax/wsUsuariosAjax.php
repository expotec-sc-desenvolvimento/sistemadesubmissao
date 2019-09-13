<?php

include dirname(__FILE__) . '/../inc/includes.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_GET['nome'])) {
    
    $usuarios = UsuarioPedrina::listaUsuarios($_GET['nome'], "", -1);
    
    $idSubmissor = "";
    if (isset($_GET['idSubmissor'])) $idSubmissor = $_GET['idSubmissor'];
    
    $resposta = "";
    
    if (count($usuarios)==0) {
        $resposta = $resposta . "<ul class='select2-results' style='list-style-type: none;'>"
                . "     <li class='select2-results-dept-0 select2-result select2-result-selectable select2-selected' role='presentation'>"
                . "         <div class='select2-result-label users-dinamic' role='option'>"
                . "             <img class='flag' src='public/img/semFoto.jpg'>Nenhum resultado encontrado"
                . "         </div>"
                . "     </li>"
                . "</ul>";
    }
    else {
        $resposta = $resposta . "<ul class='select2-results' style='list-style-type: none;'>";
        foreach ($usuarios as $usuario) {

            $idUsuario = $usuario->getId();

            if ($idUsuario == $idSubmissor) continue;

            $nomeCompleto = $usuario->getNome();

            $resposta = $resposta . "<input type='hidden' id='". $idUsuario."' value='". $idUsuario ."'>"
                                    ."<li class='select2-results-dept-0 select2-result select2-result-selectable select2-selected' role='presentation'>"
                                        . "<div class='select2-result-label users-dinamic' role='option' onclick=\"javascript:adicionarId('".$usuario->getId()."','".$nomeCompleto ."','$iconExcluir')\">" 
                                            . "<img src='/expotecsc/attendees/getuserpicture/".$idUsuario."/' class='flag'> "  . $nomeCompleto . "</div></li>";
        }
        $resposta .= "</ul>";
    }
    echo $resposta;
    
}
else {
    echo "não";
}
