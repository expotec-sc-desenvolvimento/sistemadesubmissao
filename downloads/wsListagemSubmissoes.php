<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    include dirname(__FILE__) . '/../inc/includes.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    
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
        
            
            $arquivo = "submissoes.xls";
            
            $html = "";
            $html .= "<table border='1'>";
            $html .= "<tr><td><strong>Evento</strong></td>";
            $html .= "<td><strong>Área</strong></td>";
            $html .= "<td><strong>Modalidade</strong></td>";
            $html .= "<td><strong>Tipo</strong></td>";
            $html .= "<td><strong>Titulo</strong></td>";
            $html .= "<td><strong>Situação</strong></td>";
            $html .= "<td><strong>Autores</strong></td>";
            $html .= "<td><strong>Avaliadores</strong></td>";
            $html .= "<td><strong>Nota</strong></td></tr>";
                
            $idEvento = "";
            $idModalidade = "";
            $idArea = "";
            $idSituacao = "";
            $idTipo = "";
            
            if (isset($_GET['idEvento'])) $idEvento = $_GET['idEvento'];
            if (isset($_GET['idModalidade'])) $idModalidade = $_GET['idModalidade'];
            if (isset($_GET['idArea'])) $idArea = $_GET['idArea'];
            if (isset($_GET['idSituacao'])) $idSituacao = $_GET['idSituacao'];
            if (isset($_GET['idTipo'])) $idTipo = $_GET['idTipo'];
                
            
            $listaSubmissoes = Submissao::listaSubmissoesComFiltro($idEvento,$idModalidade,$idArea,$idSituacao,$idTipo);
            
            foreach ($listaSubmissoes as $submissao) {
                
                

                $listaAvaliadores = Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(),'');
                $listaUsuariosDaSubmissao = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '','','');
                
                
                $avaliadores = "";
                $usuariosDaSubmissao = "";
                
                $flag = true;
                foreach ($listaAvaliadores as $avaliador) {
                    if ($flag) $flag=false;
                    else $avaliadores .= "<br>";
                    
                    $user = UsuarioPedrina::retornaDadosUsuario($avaliador->getIdUsuario());
                    $avaliadores .= $user->getNome();
                }
                
                $flag = true;
                foreach ($listaUsuariosDaSubmissao as $usuarioSubmissao) {
                    if ($flag) $flag=false;
                    else $usuariosDaSubmissao .= "<br>";
                    
                    $user = UsuarioPedrina::retornaDadosUsuario($usuarioSubmissao->getIdUsuario());
                    $usuariosDaSubmissao .= $user->getNome();
                }
                
                $html .= "<tr><td>".Evento::retornaDadosEvento($submissao->getIdEvento())->getNome()."</td>";
                $html .= "<td>".Area::retornaDadosArea($submissao->getIdArea())->getDescricao()."</td>";
                $html .= "<td>".Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao()."</td>";
                $html .= "<td>".TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao()."</td>";
                $html .= "<td>".$submissao->getTitulo()."</td>";
                $html .= "<td>".SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao()."</td>";
                $html .= "<td>".$usuariosDaSubmissao."</td>";
                $html .= "<td>".$avaliadores."</td>";
                $html .= "<td>".$submissao->getNota()."</strong></td></tr>";
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
