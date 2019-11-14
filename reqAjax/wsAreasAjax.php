<?php

include dirname(__FILE__) . '/../inc/includes.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_GET['evento'])) {
    
    $areas = Area::listaAreasPorEvento($_GET['evento']);

    
    $resposta = "<option value=''>Selecione uma Área</option>";
    foreach ($areas as $area) {
        $idArea = $area->getId();
        $nomeArea = $area->getDescricao();
        
        $resposta = $resposta . "<option value='".$idArea."'>".$area->getDescricao()."</option>";
        
    }
    
    echo $resposta;
}
else {
    echo "<option value=1>Não chegou</option>";
}
