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
        <title>SS - Gerenciar Áreas</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>

    </head>
    
    <body>
        
        <?php 
            include './inc/menuInicial.php';
            include './inc/modal.php';

            $listaAreas = Area::listaAreas();
            $listaEventos = Evento::listaEventos();
        ?>
        <br>
        
        
        <fieldset>
            <h3 align='center'>Listagem de Áreas (<?php echo count($listaAreas)?>)</h3>
            <p align="center"><input type="button" class="addObjeto btn-verde"  name='Area' value="Adicionar Área"></p>
            <table class='table_list_2' align='center' border='1'>
                <thead>
                    <tr>
                        <th>*</th>
                        <th>Descrição</th>
                        <th>SubAreas</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($listaAreas as $area){ ?>

                    <tr>
                        <td><a class='editarObjeto' id='<?php echo $area->getId()?>' name='Area'><img src='<?php echo $iconEditar ?>' class='img-miniatura'></a>
                            <a class='excluirObjeto' id='<?php echo $area->getId() ?>' name='Area'> <img src='<?php echo $iconExcluir ?>' class='img-miniatura'></a>
                        </td>
                        <td><?php echo $area->getDescricao() ?></td>
                        <td><?php echo $area->getSubAreas() ?></td>    
                    </tr>
                
                <?php }?>
                    </tbody>
            </table>
        </fieldset>
        
    </body>
</html>