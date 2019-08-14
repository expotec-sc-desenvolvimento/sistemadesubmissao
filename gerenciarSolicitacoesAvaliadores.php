<?php

    include dirname(__FILE__) . './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"./paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
    
        
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Gerenciar Solicitações de Avaliadores</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>

    </head>
    
    <body>
        
        <?php 
            include './inc/menuInicial.php';
            include './inc/modal.php';

            $filtro = "";
            
            if (isset($_GET['filtroSituacao'])) $filtro = $_GET['filtroSituacao'];
        
            $solicitacoesAvaliadores = SolicitacaoAvaliador::listaSolicitacaoAvaliadorComFiltro('', '', '', $filtro);
            
        ?>
        <br>
        
        
        <fieldset>
            <h3 align='center'>Listagem de Solicitações de Avaliador</h3>
            <p align="center">
                <label for="filtroSituacao">Filtro:</label>
                <select id="filtroSituacao" name="filtroSituacao" onchange="location.href='gerenciarSolicitacoesAvaliadores.php?filtroSituacao='+this.value">
                    <option value="" <?php if ($filtro=="") echo " selected"?>>Selecione um Filtro</option>
                    <option value="Deferida" <?php if ($filtro=="Deferida") echo " selected"?>>Deferidas</option>
                    <option value="Indeferida" <?php if ($filtro=="Indeferida") echo " selected"?>>Indeferidas</option>
                    <option value="Pendente" <?php if ($filtro=="Pendente") echo " selected"?>>Pendentes</option>
                </select>
            </p>
            
            <table border="1" align="center" class='table_list_2'>
                <?php
                    if (count($solicitacoesAvaliadores)==0) echo "<tr><td>Nenhuma solicitação para este filtro</td></tr>";
                    else {
                ?>
                        <thead>
                        <tr>
                            <th>*</th>
                            <th>Imagem</th>
                            <th>Nome do Solicitante</th>
                            <th>Evento</th>
                            <th>Area</th>
                            <th>Situacao</th>
                            <th>Observação</th>

                        </tr>
                        </thead>
                        
                        <tbody>    
                <?php foreach ($solicitacoesAvaliadores as $solicitacao) {
                            
                        $editar = "";  
                        $situacao = "";
                        if ($solicitacao->getSituacao()=="Pendente") {
                            $editar = "<a class='editarObjeto' id='".$solicitacao->getId()."' name='SolicitacaoAvaliador'><img src='".$iconEditar."' class='img-miniatura'>";
                        }
                        
                        if ($solicitacao->getSituacao() == 'Pendente') $situacao= "<img src='".$iconAguardando."' class='img-miniatura' title='Pendente'>";
                        if ($solicitacao->getSituacao() == 'Deferida') $situacao= "<img src='".$iconOK."' class='img-miniatura' title='Deferido'>";
                        if ($solicitacao->getSituacao() == 'Indeferida') $situacao= "<img src='".$iconExcluir."' class='img-miniatura' title='Indeferido'>";
                ?>            

                            <tr>
                                <td><?php echo $editar ?></td>
                                <td><img src='<?php echo $pastaFotosPerfil.Usuario::retornaDadosUsuario($solicitacao->getIdUsuario())->getImagem() ?>' width='30px'></td>
                                <td><?php echo Usuario::retornaDadosUsuario($solicitacao->getIdUsuario())->getNome() ?></td>
                                <td><?php echo Evento::retornaDadosEvento($solicitacao->getIdEvento())->getNome() ?></td>
                                <td><?php echo Area::retornaDadosArea($solicitacao->getIdArea())->getDescricao() ?></td>
                                <td><?php echo $situacao ?></td>
                                <td><?php echo $solicitacao->getObservacao() ?></td>
                            </tr>
                <?php    }
                } ?>
                
                </tbody>
            </table>
            
        </fieldset>
        
    </body>
</html>