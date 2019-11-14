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
    date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Avaliações</title>
    </head>

    <body>
        <?php 
        
            
            $arquivo = "avaliações.xls";
            
            $html = "";
            $html .= "<table border=1>";
            $html .= "<tr><td align='center'><strong>Trabalho</strong></td>";
            $html .= "<td align='center'><strong>Tipo</strong></td>";
            $html .= "<td align='center'><strong>Avaliador</strong></td>";
            $html .= "<td align='center'><strong>Situação</strong></td>";
            $html .= "<td align='center'><strong>Data de Recebimento</strong></td>";
            $html .= "<td align='center'><strong>Data Final de Entrega</strong></td>";
            $html .= "<td align='center'><strong>Observação</strong></td></tr>";
            
            foreach (Avaliacao::listaAvaliacoesComFiltro('', '', '') as $avaliacao) {
                $prazoEntrega = strtotime(date($avaliacao->getPrazo()));
                $situacaoPrazo = "-";
                $dataAtual = strtotime(date('Y-m-d'));
                // verifica a diferença em segundos entre as duas datas e divide pelo número de segundos que um dia possui

                $diferenca = ($prazoEntrega - $dataAtual) /86400;
                // caso a data 2 seja menor que a data 1
                
                if (in_array(SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getId(), array(1,3)) && $avaliacao->getPrazo()!='') {
                    if ($diferenca>0) $situacaoPrazo = $diferenca . " para término do prazo!";
                    else if ($diferenca<0) $situacaoPrazo = -($diferenca) . " dia(s) de atraso!";
                    else $situacaoPrazo = "<strong>Último dia para entrega da Avaliação</strong>";
                }
                
                $user = UsuarioPedrina::retornaDadosUsuario($avaliacao->getIdUsuario());
                $html .= "<tr><td>". Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getTitulo()."</td>";
                $html .= "<td>". TipoSubmissao::retornaDadosTipoSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdTipoSubmissao())->getDescricao()."</td>";
                $html .= "<td>". $user->getNome()."</td>";
                $html .= "<td>". SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao()."</td>";
                $html .= "<td>". date('d/m/Y', strtotime($avaliacao->getDataRecebimento())) ."</td>";
                
                if (in_array(SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getId(), array(1,3)) && $avaliacao->getPrazo()!='') {
                    $html .= "<td>". date('d/m/Y', strtotime($avaliacao->getPrazo())) ."</td>";
                }
                else $html .= "<td>-</td>";
                
                $html .= "<td>". $situacaoPrazo ."</td></tr>";

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
