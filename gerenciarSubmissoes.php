<?php

    include dirname(__FILE__) . './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"./paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
    
    if (!Avaliacao::atualizarSituacaoAvaliacoes()) {
        echo "erro"; exit(1);
    }  
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Gerenciar Submissões</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>

        <script type="text/javascript">
            function direcionar() {
                var evento = document.getElementById('select-Eventos').value;
                var modalidade = document.getElementById('select-Modalidades').value;
                var area = document.getElementById('select-Areas').value;
                var situacao = document.getElementById('select-Situacao').value;
                var tipo = document.getElementById('select-Tipo').value;
                
                var url = 'gerenciarSubmissoes.php?';
                if (evento!='') url+='idEvento='+evento+'&';
                if (modalidade!='') url+='idModalidade='+modalidade+'&';
                if (area!='') url+='idArea='+area+'&';
                if (situacao!='') url+='idSituacao='+situacao;
                if (tipo!='') url+='idTipo='+tipo;
                
                document.location = url;
            }
        </script>
    </head>
    
    <body>
        
        <?php 
            include './inc/menuInicial.php';
            include './inc/modal.php';

            $idEvento = "";
            $idModalidade = "";
            $idArea = "";
            $idSituacao = "";
            $idTipo = "";
            
            $vars = "";
            
            if (isset($_GET['idEvento'])) {
                $idEvento = $_GET['idEvento'];
                $vars .= "idEvento=" . $idEvento . "&";
            }
            if (isset($_GET['idModalidade'])) {
                $idModalidade = $_GET['idModalidade'];
                $vars .= "idModalidade=" . $idModalidade . "&";
            }
            if (isset($_GET['idArea'])) {
                $idArea = $_GET['idArea'];
                $vars .= "idArea=" . $idArea . "&";
            }
            if (isset($_GET['idSituacao'])) {
                $idSituacao = $_GET['idSituacao'];
                $vars .= "idSituacao=" . $idSituacao . "&";
            }
            if (isset($_GET['idTipo'])) {
                $idTipo = $_GET['idTipo'];
                $vars .= "idTipo=" . $idTipo;
            }
        
            $listaSubmissoes = Submissao::listaSubmissoesComFiltro($idEvento,$idModalidade,$idArea,$idSituacao,$idTipo);
            
        ?>
        <br>
        
        
        <fieldset>
            <h3 align='center'>Listagem de Submissoes (<?php echo count($listaSubmissoes)?>)</h3>
            
            <p align="center">
                <input class="addObjeto btn-verde" type="button" value="Distribuir Avaliadores" onclick="window.location.href='distribuirAvaliadores.php'"/>
                <input class="addObjeto btn-verde" type="button" value="Processar Avaliações" onclick="window.location.href='submissaoForms/wsProcessarAvaliacoes.php'"/>
            </p>
            <p align="center"><a href="downloads/wsListagemSubmissoes.php?<?php echo $vars ?>">Exportar Planilha Excel</a></p>
            <p align="center">     
                <label for="select-Eventos">Evento: </label>
                <select class="campoDeEntrada" id="select-Eventos" name="select-Eventos" onchange="direcionar()" style="width:200px">
                    <option value="">Selecione um evento</option>
                    <?php
                        foreach (Evento::listaEventos() as $evento) {
                            echo "<option value='".$evento->getId()."'";
                            if (isset($_GET['idEvento']) && $_GET['idEvento'] == $evento->getId()) echo " selected";
                            echo ">" . $evento->getNome() . "</option>";
                        }
                    ?>
                </select>
                <label for="select-Modalidades">Modalidade: </label>
                <select class="campoDeEntrada" id="select-Modalidades" name="select-Modalidades" onchange="direcionar()" style="width:200px">
                    <option value="">Selecione uma modalidade</option>
                    <?php
                        foreach (Modalidade::listaModalidades() as $modalidade) {
                            echo "<option value='".$modalidade->getId()."'";
                            if (isset($_GET['idModalidade']) && $_GET['idModalidade'] == $modalidade->getId()) echo " selected";
                            echo ">" . $modalidade->getDescricao() . "</option>";
                        }
                    ?>
                </select>
                <label for="select-Areas">Area: </label>
                <select class="campoDeEntrada" id="select-Areas" name="select-Areas" onchange="direcionar()" style="width:200px">
                    <option value="">Selecione uma Area</option>
                    <?php
                        foreach (Area::listaAreas() as $area) {
                            echo "<option value='".$area->getId()."'";
                            if (isset($_GET['idArea']) && $_GET['idArea'] == $area->getId()) echo " selected";
                            echo ">" . $area->getDescricao() . "</option>";
                        }
                    ?>
                </select>
                <label for="select-Situacao">Situação: </label>
                <select class="campoDeEntrada" id="select-Situacao" name="select-Situacao" onchange="direcionar()" style="width:200px">
                    <option value="">Selecione uma Situação</option>
                    <?php
                        foreach (SituacaoSubmissao::listaSituacaoSubmissao() as $situacao) {
                            echo "<option value='".$situacao->getId()."'";
                            if (isset($_GET['idSituacao']) && $_GET['idSituacao'] == $situacao->getId()) echo " selected";
                            echo ">" . $situacao->getDescricao() . "</option>";
                        }
                    ?>
                </select>
                <label for="select-Situacao">Tipo: </label>
                <select class="campoDeEntrada" id="select-Tipo" name="select-Tipo" onchange="direcionar()" style="width:200px">
                    <option value="">Selecione um Tipo</option>
                    <?php
                        foreach (TipoSubmissao::listaTipoSubmissoes() as $tipo) {
                            echo "<option value='".$tipo->getId()."'";
                            if (isset($_GET['idTipo']) && $_GET['idTipo'] == $tipo->getId()) echo " selected";
                            echo ">" . $tipo->getDescricao() . "</option>";
                        }
                    ?>
                </select>
                
            </p>
            
            <table border="1" align="center" class="table_list_3">
                <thead>
                    <tr>
                        <th>*</th>
                        <th>Evento</th>
                        <th>Area</th>
                        <th>Modalidade</th>
                        <th>Tipo</th>
                        <th>Titulo</th>
                        <th>Arquivo</th>
                        <th>Situação</th>
                        <th>Autores</th>
                        <th>Avaliadores</th>
                        <th>Nota</th>
                        <th>*</th>

                    </tr>
                </thead>
                <tbody>
                <?php 
                    if (count($listaSubmissoes)==0) echo "<tr><td colspan='12' align=center>Nenhuma Submissao com os Filtros acima!</td></tr>";
                    else {
                        foreach ($listaSubmissoes as $submissao) {
                            
                            $usuariosSubmissao = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '');
                            $usuarioSubmissao = "<ul class='listaCriterios'>";
                            foreach ($usuariosSubmissao as $user) $usuarioSubmissao = $usuarioSubmissao . "<li>" . Usuario::retornaDadosUsuario($user->getIdUsuario())->getNome() . "</li>";
                            $usuarioSubmissao .= "</ul>";
                                    
                            $avaliacoes = Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(),'');
                            $avaliadores = "<ul class='listaCriterios'>";
                            
                            foreach ($avaliacoes as $avaliacao) {
                                $editarAvaliador = "";
                                $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getId();
                                
                                // Situações de Avaliação = 1-Pendente, 2-Finalizada, 3-Atrasada, 4-Aprovado(a), 5-Aprovado(a) com ressalvas, 6-Reprovado
                                if (in_array($situacaoAvaliacao, array(1,3))) {
                                    $editarAvaliador = "<a class='editarObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><img src='".$iconEditar."' class='img-miniatura'></a>";
                                            //. "<a class='excluirObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><img src='".$iconExcluir."' class='img-miniatura'></a>";
                                }
                                else $editarAvaliador = "<a class='visualizarObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><img src='".$iconVisualizar."' class='img-miniatura'></a>";
                                $user = Usuario::retornaDadosUsuario($avaliacao->getIdUsuario());
                                $avaliadores = $avaliadores . "<li>" .$editarAvaliador . $user->getNome() . "</li>";
                            }
                            
                            $avaliadores .= "</ul>";

                            $finalizar="";
                            if ($submissao->getNota()!="" && SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao()=="Em avaliacao") {
                                $finalizar="<a href='submissaoForms/wsFinalizarSubmissao.php?id=".$submissao->getId()."' onclick=\"return confirm('Deseja finalizar esta avaliação?')\">Finalizar</a>";
                            }
                            
                            $addAvaliador = "";
                            $repetirAvaliadores = "";
                            
                            $situacaoSubmissao = SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao();
                            if ($situacaoSubmissao=="Submetida") {
                                $addAvaliador = "<p align='center'><input type='button' class='addObjeto btn-verde' id='".$submissao->getId()."' name='Avaliacao' value='Adicionar Manualmente'></p>";
                                $addAvaliador .= "<p align='center'><input type='button' class='addObjeto btn-verde' id='".$submissao->getId()."' name='Avaliacao' value='Distribuir Automaticamente'></p>";
                            }
                            
                            if (TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao()=="Final" &&
                                    SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao()=="Submetida") {
                                $repetirAvaliadores = "<p align='center'><input type='button' class='addObjeto btn-verde' id='".$submissao->getId()."' name='AvaliacaoRepetida' value='Repetir Avaliadores' ></p>";
                            }    
                    ?>
                            <tr>
                                <td><a class='visualizarObjeto' id='<?php echo $submissao->getId() ?>' name='Submissao'><img src='<?php echo $iconVisualizar ?>' class='img-miniatura'></a></td>
                                <td><?php echo Evento::retornaDadosEvento($submissao->getIdEvento())->getNome() ?></td>
                                <td><?php echo Area::retornaDadosArea($submissao->getIdArea())->getDescricao() ?></td>
                                <td><?php echo Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao() ?></td>
                                <td><?php echo TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao() ?></td>
                                <td><?php echo $submissao->getTitulo(); ?></td>
                                <td><a href='<?php echo $pastaSubmissoes . $submissao->getArquivo()  ?>'>Visualizar</a></td>
                                <td><?php echo SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao() ?></td>
                                <td><?php echo $usuarioSubmissao ?></td>
                                <td><?php echo $avaliadores . $addAvaliador . $repetirAvaliadores?></td>
                                <td><?php echo $submissao->getIdTipoSubmissao()==3 ? $submissao->getNota() : '-'; ?></td>
                                <td><?php echo $finalizar ?></td></tr>
                      <?php          
                        }
                    }
                ?>
                </tbody>
            </table>
    </body>
</html>