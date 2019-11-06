<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include dirname(__FILE__) . '/../inc/includes.php';

if( isset($_GET['idSubmissao']) && $_GET['idSubmissao']!="" && isset($_GET['tipo']) && $_GET['tipo']!="" &&
    isset($_GET['evento']) && $_GET['evento']!="" && isset($_GET['area']) && $_GET['area']!="") {
    
    $evento = $_GET['evento'];
    $area = $_GET['area'];
    $tipo = $_GET['tipo'];
    $idSubmissao = $_GET['idSubmissao'];

    $idAvaliadorAtual='';
    if (isset($_GET['idAvaliadorAtual'])) $idAvaliadorAtual = $_GET['idAvaliadorAtual'];
    
    
    //CODIGO ALTERADO PARA MUDANÇA DE PROCEDURES
    if ($tipo=="area") $avaliadores = Avaliador::listaAvaliadoresComFiltro($evento, $area, '',"area");
    else               $avaliadores = Avaliador::listaAvaliadoresComFiltro($evento, $area, '',"outra-area");
    
    //FALTA TESTAR SE O USUÁRIO É AVALIADOR DA SUBMISSAO
    
    
    $resposta = "<option value=''>Selecione um avaliador</option>";
//    $resposta = "<option value''>".$avaliadores."</option>";

    $userListado = array();
    foreach ($avaliadores as $avaliador) {
        $usuario = new UsuarioPedrina();
        $usuario = UsuarioPedrina::retornaDadosUsuario($avaliador->getIdUsuario());
        
        if ($idAvaliadorAtual=='') {
	   if ((count(Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), $idSubmissao, ''))>0) || 
                count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($idSubmissao, $usuario->getId(), ''))>0 || in_array($avaliador->getIdUsuario(),$userListado)) continue;

	}	
	else if ((count(Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), $idSubmissao, ''))>0 && $usuario->getId()!=$idAvaliadorAtual) || 
                count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($idSubmissao, $usuario->getId(), ''))>0 || in_array($avaliador->getIdUsuario(),$userListado)) continue;

        $selected = '';
        if ($idAvaliadorAtual!='' && $usuario->getId()==$idAvaliadorAtual) $selected = ' selected';
	$resposta = $resposta . "<option value='".$usuario->getId()."' ".$selected.">".$usuario->getNome()."</option>";
	array_push($userListado,$avaliador->getIdUsuario());
    }
    echo $resposta;
//	echo "<option value=''>".$evento." ".$area." ".$tipo." ".$idSubmissao." ".$idAvaliadorAtual."</option>";
}
else echo "<option value=''>Algum erro ocorreu</option>";
  
