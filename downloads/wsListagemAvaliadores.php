<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    include dirname(__FILE__) . '/../inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Avaliadores</title>
    </head>

    <body>
        <?php 
        
            
            $arquivo = "avaliadores.xls";
            
            $html = "";
            $html .= "<table border=1>";
            $html .= "<tr><td><strong>Evento</strong></td>";
            $html .= "<td><strong>Área</strong></td>";
            $html .= "<td><strong>Avaliador</strong></td>";
            $html .= "<td><strong>Trabalhos Vinculados</strong></td></tr>";
            
            foreach (Avaliador::listaAvaliadoresComFiltro('','','','') as $avaliador) {
                $usuario = UsuarioPedrina::retornaDadosUsuario($avaliador->getIdUsuario());
                $trabalhosVinculados = count(Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), '', ''));
                $html .= "<tr><td>". Evento::retornaDadosEvento($avaliador->getIdEvento())->getNome()."</td>";
                $html .= "<td>". Area::retornaDadosArea($avaliador->getIdArea())->getDescricao()."</td>";
                $html .= "<td>". $usuario->getNome() ."</td>";
                $html .= "<td>". $trabalhosVinculados ."</td></tr>";
            }
            
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=".basename($arquivo));            
            header("Content-Description: PHP Generated Data");
            echo $html;
        ?>
        
    </body>
</html>