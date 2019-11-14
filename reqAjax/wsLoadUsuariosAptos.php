<?php

include dirname(__FILE__) . '/../inc/includes.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_GET['tipo']) && $_GET['tipo']!='') {
    
    $resposta = '<br>';
    if ($_GET['tipo']=='Monitoria') {
        $resposta .= "<h3 align='center'>Usuários Aptos</h3>
                <table class='table table-striped table-bordered dt-responsive' align='center' border='1' style='width: 50%;'>
                    <thead>
                        <tr>
                            <th style='text-align: center' width='40px'>*</th>
                            <th style='text-align: center'>Usuário</th>
                            <th style='text-align: center'>CPF</th>
                        </tr>
                    </thead>";
        
        $certificadosEmitidos = array();
        
        foreach (Certificado::listaCertificadosComFiltro('Monitoria', '') as $certificado) array_push ($certificadosEmitidos, $certificado->getIdUsuario());
        
        $resposta .= "<tbody>";
        
        
        
        foreach (UsuarioPedrina::listaUsuarios('', '', '') as $user) {
            $resposta .= "<tr><td style='text-align: center'>";
            if (in_array($user->getId(), $certificadosEmitidos)) $resposta .= "<img src='".$iconOK."' class='img-miniatura' title='Certificado emitido para este usuário'></td>"; //Caso já tenha sido gerado um certificado de monitor para este usuário...
            else $resposta .= "<input type='checkbox' id='certificados[]' name='certificados[]' value='". $user->getId() ."'></td>";
            
            $resposta .= "<td>".$user->getNome()."</td>
                          <td>".$user->getCpf()."</td>
                         </tr>";
        }
        $resposta .= "</tbody></table>";
    }
    
    else if ($_GET['tipo']=='Apresentacao') {
        
        $resposta .= "<script type='text/javascript'>
                        function marcarTodos() {
                            alert(\"Entrou aqui\");
                            }
                    </script>";
        
        $resposta .= "<h3 align='center'>Usuários Aptos</h3>
                <table class='table table-striped table-bordered dt-responsive' align='center' border='1' style='width: 70%;'>
                    <thead>
                        <tr>
                            <th style='text-align: center' width='40px'><input type='checkbox' id='marcarTodas' name='marcarTodas' onclick=\"if (document.getElementById('marcarTodas').checked == true) {
                                                                                                                                                        var itens = document.getElementsByName('certificados[]');
                                                                                                                                                        var i = 0;
                                                                                                                                                        for(i=0; i<itens.length;i++) itens[i].checked = true;
                                                                                                                                                    }
                                                                                                                                                    else {
                                                                                                                                                        var itens = document.getElementsByName('certificados[]');
                                                                                                                                                        var i = 0;
                                                                                                                                                        for(i=0; i<itens.length;i++) itens[i].checked = false;
                                                                                                                                                    }\"></th>
                            <th style='text-align: center'>Trabalho</th>
                            <th style='text-align: center'>Usuários do Trabalho</th>
                        </tr>
                    </thead>
                    <tbody>";
        
        $listaSubmissoes = Submissao::listaSubmissoesComFiltro('', '', '', 7, 3);
        
        if (count($listaSubmissoes)==0) $resposta .= "<tr><td colspan='3' style='text-align: center'><strong>Nenhum usuário apto a ter certificado emitido!</strong></td></tr></tbody></table>";
        else {
            foreach ($listaSubmissoes as $submissao) { //Submissões Finais (tipo 3) e apresentadas (tipo 7) style="vertical-align: middle;
                $resposta .= "";
                $resposta .= "<tr><td style='text-align: center; vertical-align: middle;'><input type='checkbox' id='certificados[]' name='certificados[]' value='". $submissao->getId() ."'></td>";
                $resposta .= "<td style='text-align: center; vertical-align: middle;'>".$submissao->getTitulo()."</td>";
                $resposta .= "<td><ul style='list-style-type: none;'>";
                
                foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '', '','') as $userSubmissao) {
                    if (existeCertificadoApresentacao($submissao->getId(),$userSubmissao->getIdUsuario())) {
                        $resposta .= "<li><img class='img-miniatura' src='".$iconOK."' title='Certificado Gerado'>".UsuarioPedrina::retornaDadosUsuario($userSubmissao->getIdUsuario())->getNome();
                    }
                    else if ($userSubmissao->getApresentouTrabalho()) {
                        $resposta .= "<li><img class='img-miniatura' src='".$iconOKRessalvas."' title='Certificado a ser emitido'>".UsuarioPedrina::retornaDadosUsuario($userSubmissao->getIdUsuario())->getNome();
                    }
                    else $resposta .= "<li><img class='img-miniatura' src='".$iconExcluir."' title='Não apresentou Trabalho'>".UsuarioPedrina::retornaDadosUsuario($userSubmissao->getIdUsuario())->getNome();
                }
                
            }
        }
    }
    echo $resposta;
}

else echo "";
?>

