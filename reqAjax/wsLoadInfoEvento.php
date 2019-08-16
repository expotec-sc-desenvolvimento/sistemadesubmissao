<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include dirname(__FILE__) . '/../inc/includes.php';

if(isset($_GET['evento']) && $_GET['evento']!="") {
    
    $idTipo = $_GET['tipoAvaliacao'];
    
    $nome = Evento::retornaDadosEvento($_GET['evento'])->getNome();
    
    $areasDoEvento = Area::listaAreasPorEvento($_GET['evento']);

    $resposta = "";
    
    $resposta = $resposta . "<strong>Nome do Evento: </strong>" . $nome . "<br><br>";
    

    
    $resposta = $resposta . "<table align='center' border='1' class='table_list'><tr>"
                                . "<td align='center'><strong>Área</strong></td>"
                                . "<td align='center'><strong>Avaliadores <br>da Área</strong></td>"
                                . "<td align='center'><strong>Trabalhos <br>sem Avaliadores</strong></td>";
    
                        
    foreach ($areasDoEvento as $area) {
        $avaliadores = Avaliador::listaAvaliadoresComFiltro($_GET['evento'], $area->getId(), '',"area");

        $resposta = $resposta . "<tr><td>" . $area->getDescricao() . "</td>";
        $resposta = $resposta . "<td><a class='visualizarObjeto' id='".AreaEvento::retornaIdAreaEvento($_GET['evento'], $area->getId())."' name='Avaliadores'>"
                                . "<img src='".$iconVisualizar."' class='img-miniatura'></a>";
        
        /*
        foreach ($avaliadores as $avaliador) {
            $resposta = $resposta . Usuario::retornaDadosUsuario($avaliador->getIdUsuario())->getNome() . "<br>";
        } */
        
        $resposta = $resposta . "</td>";
        
        
        $qtdeTrabalhosSemAvaliador = 0;
        
        $listaSubmissoes = Submissao::listaSubmissoesComFiltro($_GET['evento'],'',$area->getId(),1,$idTipo);
        
        foreach ($listaSubmissoes as $submissao) {
            if (count(Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(),''))==0) $qtdeTrabalhosSemAvaliador += 1;
        }
        
        $resposta = $resposta . "<td align='center'>$qtdeTrabalhosSemAvaliador</td></tr>";
        
    }
        $resposta = $resposta . "</table>";
        
       /* $resposta = $resposta . "<p align='center'><input type='submit' value='Distribuir Avaliadores'"
                . "onclick=\"return confirm('Resumo: '+document.getElementById('avaliadoresDaArea').value+ ' Avaliadores da Área \\n "
                . "              '+document.getElementById('avaliadoresOutraArea').value+' Avaliadores de outra Área \\n "
                . "              Deseja gerar as avalições com esses valores?')\">"
                . "</p>"; */
        
        $resposta = $resposta . "<p align='center'><input type='button' class='addDistribuicao btn-verde' value='Verificar'></p>";
     echo $resposta;
}
else {
 //   echo "Não chegou";
}
?>