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
        <title>SS - Gerenciar Avaliadores</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>
        <script type="text/javascript">
            
            function direcionar() {
                var evento = document.getElementById('select-Eventos').value;
                var area = document.getElementById('select-Areas').value;
                
                var url = 'gerenciarAvaliadores.php?';
                
                if (evento!='') {
                    url+='idEvento='+evento+"&";
                    if (area!='') url+='idArea='+area+"&";    
                }
                
                document.location = url;
            }
        </script>

    </head>
    
    <body>
        
        <?php 
            include './inc/menuInicial.php';
            include './inc/modal.php';
        
            $areas = null;
            
            if (isset($_GET['idEvento'])) $areas = Area::listaAreasPorEvento($_GET['idEvento']);
            //else $areas = Area::listaAreas();
            
        ?>
        
        <fieldset>
            <h2 align="center">Lista de Avaliadores</h2>
            <p align="center"><input type="button" class="addObjeto btn-verde" value="Adicionar Avaliadores" name='Avaliadores'></p>
            <p align="center"><a href="downloads/wsListagemAvaliadores.php">Exportar Planilha Excel</a></p>
            <p align="center">     
                <label for="select-Eventos">Evento: </label>
                <select class="campoDeEntrada" style="width: 200px" id="select-Eventos" name="select-Eventos" onchange="direcionar()">
                    <option value="">Selecione um evento</option>
                    <?php
                        foreach (Evento::listaEventos() as $evento) {
                            echo "<option value='".$evento->getId()."'";
                            if (isset($_GET['idEvento']) && $_GET['idEvento'] == $evento->getId()) echo " selected";
                            echo ">" . $evento->getNome() . "</option>";
                        }
                    ?>
                </select>

                <label for="select-Areas">Area: </label>
                <select class="campoDeEntrada" style="width: 200px" id="select-Areas" name="select-Areas" onchange="direcionar()">
                    <option value="">Selecione uma Area</option>
                    <?php
                        foreach ($areas as $area) {
                            echo "<option value='".$area->getId()."'";
                            if (isset($_GET['idArea']) && $_GET['idArea'] == $area->getId()) echo " selected";
                            echo ">" . $area->getDescricao() . "</option>";
                        }
                    ?>
                </select>
            </p>
            
            <table class='table_list_2' align='center' border='1'>
                <thead>
                    <tr>
                        <th>*</th>
                        <th>Evento</th>
                        <th>Área</th>
                        <th>Avaliador</th>
                        <th>Avaliações Parciais</th>
                        <th>Avaliações Finais</th>
                    </tr>
                </thead>
                <tbody>
            <?php 
                    foreach(Evento::listaEventos() as $evento) { // Puxa a lista de Eventos
                        
                        if (isset($_GET['idEvento']) && $_GET['idEvento'] != $evento->getId()) continue;
                        
                        $idArea = "";
                        if (isset($_GET['idArea'])) $idArea = $_GET['idArea'];
                        
                            
                        foreach (Avaliador::listaAvaliadoresComFiltro($evento->getId(), $idArea, '',"area") as $avaliador) {
                                
                                $avParciais = 0;
                                $avFinais = 0;
                                foreach (Avaliacao::listaAvaliacoesComFiltro($avaliador->getIdUsuario(), '', '') as $av) {
                                    if (TipoSubmissao::retornaDadosTipoSubmissao(Submissao::retornaDadosSubmissao($av->getIdSubmissao())->getIdTipoSubmissao())->getDescricao()=="Parcial") $avParciais += 1;
                                    else $avFinais += 1;
                                }
                                
                            ?>
                            <tr>
                                <td><a class='excluirObjeto' id='<?php echo $avaliador->getId() ?>' name='Avaliadores'><img src='<?php echo $iconExcluir ?>' class='img-miniatura'></a></td>
                                <td><?php echo Evento::retornaDadosEvento($avaliador->getIdEvento())->getNome() ?></td>
                                <td><?php echo Area::retornaDadosArea($avaliador->getIdArea())->getDescricao() ?></td>
                                <td><?php echo Usuario::retornaDadosUsuario($avaliador->getIdUsuario())->getNome() ?></td>
                                <td><?php echo $avParciais ?></td>
                                <td><?php echo $avFinais ?></td>
                            </tr>
                        
                        <?php } ?>
                            </tbody>
                        </table><br>
                    <?php }
            ?>
                        
            
        </fieldset>
    </body>
    
</html>
