<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
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
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>

    </head>
    
    <body>
        
        <?php 
            include 'inc/pInicial.php';
            include 'inc/modal.php';

            $listaAreas = Area::listaAreas();
            $listaEventos = Evento::listaEventos();
        ?>
        <br>
        
        
        <fieldset>
            <h3 align='center'>Listagem de Áreas (<?php echo count($listaAreas)?>)</h3>
            <p align="center"><input type="button" class="addObjeto btn btn-sm marginTB-xs btn-success"  name='Area' value="Adicionar Área"></p>
            <table border="1" align="center" class="table table-striped table-bordered dt-responsive nowrap" style="width: 50%">
                <thead>
                    <tr>
                        <th style="width: 10%; text-align: center">*</th>
                        <th style="text-align: center">Descrição</th>
                        <!-- <th style="text-align: center">SubAreas</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php foreach($listaAreas as $area){ ?>

                    <tr>
                        <td><a class='editarObjeto' id='<?php echo $area->getId()?>' name='Area'><i class="fa fa-edit aria-hidden='true'"></i></a>
                            <a class='excluirObjeto' id='<?php echo $area->getId() ?>' name='Area'><i class="fa fa-trash m-right-xs"></i></a>
                        </td>
                        <td align="center"><?php echo $area->getDescricao() ?></td>
                        <!-- <td>< ?php echo $area->getSubAreas() ?></td>    -->
                    </tr>
                
                <?php }?>
                    </tbody>
            </table>
        </fieldset>
        <?php 
            include 'inc/pFinal.php';
        ?>
    </body>
</html>
