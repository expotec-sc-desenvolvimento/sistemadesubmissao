<?php

    include dirname(__FILE__) . './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];


    // DESCOMENTAR ESSA LINHA PARA DESABILITAR A PAGINA
    // header("Location: ./paginaInicial.php?Solicitacao=Fora");
    
    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Adicionar Solicitação de Avaliador</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>
        
    </head>
    
    <body>
        
        <?php include './inc/menuInicial.php';?>

        <?php 
            $eventos = array (new Evento());
            $eventos = Evento::listaEventos();
        ?>
        
        <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddSolicitacaoAvaliador.php');?>">
            <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $usuario->getId() ?>">
            <br>
            <br>

            <label for="evento">Selecione o Evento: </label>
                <div id="eventos">
                    <select id="select-Eventos" name="select-Eventos" onchange="loadAreas()" required="true">
                        <option value="">Selecione um evento</option>
                        <?php
                            foreach ($eventos as $evento) {
                                echo "<option value='".$evento->getId()."'>".$evento->getNome()."</option>";
                            }
                        ?>
                    </select>
                </div>
            <br>
            <label for="areas">Selecione a Área: </label><div id="areas"><select id="select-Areas" name="select-Areas" required="true"></select></div>
            <br>

                <input type='submit' value='Enviar Solicitação' onclick="return listaIds()">
                
        </form>       
    </body>
    </html>

        
        