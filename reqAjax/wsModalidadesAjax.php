<?php

include dirname(__FILE__) . '/../inc/includes.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_GET['evento'])) {
    
    $modalidades = Modalidade::listaModalidadesPorEvento($_GET['evento']);

    
    $resposta = "<option value=''>Selecione uma Modalidade</option>";
    foreach ($modalidades as $modalidade) {
        $idModalidade = $modalidade->getId();
        $nomeModalidade = $modalidade->getDescricao();
        
        $resposta = $resposta . "<option value='".$idModalidade."'>".$nomeModalidade."</option>";
        
    }
    
    echo $resposta;
}
else {
    echo "<option value=1>Não chegou</option>";
}
