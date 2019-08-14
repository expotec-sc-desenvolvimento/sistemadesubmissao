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
        <title>SS - Gerenciar Modalidades</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>


    </head>
    
    <body>
        
        <?php 
            include './inc/menuInicial.php';
            include './inc/modal.php';
        
        ?>
        
        <?php
            $listaModalidades = Modalidade::listaModalidades();
            $listaEventos = Evento::listaEventos();
        ?>
        <br>
        
        
        <fieldset>
            <h3 align='center'>Listagem de Modalidades (<?php echo count($listaModalidades)?>)</h3>
            <p align="center"><input type="button" class="addObjeto btn-verde" name='Modalidade' value="Adicionar Modalidade"></p>
            <table border="1" align="center" class="table_list">

                <tr><td align="center"><strong>*</strong></td>
                    <td align="center"><strong>Nome da Modalidade</strong></td>
                    <td align="center"><strong>Criterios Av. Parciais</strong></td>
                    <td align="center"><strong>Criterios Av. Corrigidas</strong></td>
                    <td align="center"><strong>Criterios Av. Finais</strong></td>
                    
                </tr>
                <?php foreach($listaModalidades as $modalidade){ 
     
                    $criteriosDaModalidade = Criterio::listaCriteriosComFiltro($modalidade->getId(), '');
                    $tipoSubmissoes = TipoSubmissao::listaTipoSubmissoes();
                    // A proxima instrução imprime os Eventos aos quais este tipo de submissao está vinculado
                ?>
                    <tr>
                        <td><a class='editarObjeto' id='<?php echo $modalidade->getId()?>' name='Modalidade'><img src='<?php echo $iconEditar ?>' class="img-miniatura"></a>
                            <a class='excluirObjeto' id='<?php echo $modalidade->getId()?>' name='Modalidade'><img src='<?php echo $iconExcluir ?>' class="img-miniatura"></a>
                        </td>
                        <td><?php echo $modalidade->getDescricao()?></td>
                        <?php foreach ($tipoSubmissoes as $tipo) { ?>
                            <td>
                                <ul class="listaCriterios">
                                    <?php foreach ($criteriosDaModalidade as $criterio) {
                                        if ($tipo->getId() == $criterio->getIdTipoSubmissao()) { ?>
                                            <li>
                                                <a class='editarObjeto' id='<?php echo $criterio->getId() ?>' name='Criterio'><img class="img-miniatura" src='<?php echo $iconEditar ?>' ></a>
                                                <a class='excluirObjeto' id='<?php echo $criterio->getId() ?>' name='Criterio'><img src='<?php  echo $iconExcluir ?>' class="img-miniatura"></a>
                                                
                                                <?php if ($criterio->getDescricao() == "Final") {echo "Peso " . $criterio->getPeso() . " - ";}
                                                      echo $criterio->getDescricao(); 
                                                ?>
                                            </li>
                                        <?php }
                                    }
                                    ?>
                                </ul>
                                
                                <div style="align-items: center; justify-content: center;"><input type='button' class='addCriterio btn-verde' id='<?php echo $modalidade->getId() ?>' name='<?php echo $tipo->getId()?>' value='Adicionar Critério' ></div>
                            </td>
                         <?php } 
                
                     }?>

            </table>
        
    </body>
</html>