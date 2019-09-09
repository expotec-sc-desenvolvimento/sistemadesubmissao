<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"./paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
    
    date_default_timezone_set('America/Sao_Paulo');
    //if (!Avaliacao::atualizarSituacaoAvaliacoes()) {
      //  echo "erro"; exit(1);
    //}  
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
            include 'inc/css.php';
            include 'inc/javascript.php';
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
            include 'inc/pInicial.php';
            include 'inc/modal.php';

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
   
        
            <h3 align='center' >Listagem de Submissões (<?php echo count($listaSubmissoes)?>)</h3>
            
            <p align="center">
                <input class="addObjeto btn btn-sm marginTB-xs btn-success" type="button" value="Distribuir Avaliadores Automaticamente" onclick="window.location.href='distribuirAvaliadores.php'"/>
                <input class="addObjeto btn btn-sm marginTB-xs btn-success" type="button" value="Finalizar Avaliações em Lote (<?php echo count(Submissao::retornaSubmissoesParaFinalizar()) ?>)" onclick="window.location.href='finalizarAvaliacoesEmLote.php'"/>
            </p>
            <p align="center"><a href="downloads/wsListagemSubmissoes.php?<?php echo $vars ?>">Exportar Planilha Excel</a></p>
            
            <table align="center">
                <tr><td>
                    <label for="select-Eventos">Evento: </label>
                    <select class="form-control" id="select-Eventos" name="select-Eventos" onchange="direcionar()" style="width:200px">
                        <option value="">Selecione um evento</option>
                        <?php
                            foreach (Evento::listaEventos() as $evento) {
                                echo "<option value='".$evento->getId()."'";
                                if (isset($_GET['idEvento']) && $_GET['idEvento'] == $evento->getId()) echo " selected";
                                echo ">" . $evento->getNome() . "</option>";
                            }
                        ?>
                    </select>
                    </td>
                    <td>
                    <label for="select-Modalidades">Modalidade: </label>
                    <select class="form-control" id="select-Modalidades" name="select-Modalidades" onchange="direcionar()" style="width:200px">
                        <option value="">Selecione uma modalidade</option>
                        <?php
                            foreach (Modalidade::listaModalidades() as $modalidade) {
                                echo "<option value='".$modalidade->getId()."'";
                                if (isset($_GET['idModalidade']) && $_GET['idModalidade'] == $modalidade->getId()) echo " selected";
                                echo ">" . $modalidade->getDescricao() . "</option>";
                            }
                        ?>
                    </select>
                    </td>
                    <td>
                    <label for="select-Areas">Area: </label>
                    <select class="form-control" id="select-Areas" name="select-Areas" onchange="direcionar()" style="width:200px">
                        <option value="">Selecione uma Area</option>
                        <?php
                            foreach (Area::listaAreas() as $area) {
                                echo "<option value='".$area->getId()."'";
                                if (isset($_GET['idArea']) && $_GET['idArea'] == $area->getId()) echo " selected";
                                echo ">" . $area->getDescricao() . "</option>";
                            }
                        ?>
                    </select>
                    </td>
                    <td>
                    <label for="select-Situacao">Situação: </label>
                    <select class="form-control" id="select-Situacao" name="select-Situacao" onchange="direcionar()" style="width:200px">
                        <option value="">Selecione uma Situação</option>
                        <?php
                            foreach (SituacaoSubmissao::listaSituacaoSubmissao() as $situacao) {
                                echo "<option value='".$situacao->getId()."'";
                                if (isset($_GET['idSituacao']) && $_GET['idSituacao'] == $situacao->getId()) echo " selected";
                                echo ">" . $situacao->getDescricao() . "</option>";
                            }
                        ?>
                    </select>
                    </td>
                    <td>
                    <label for="select-Situacao">Tipo: </label>
                    <select class="form-control" id="select-Tipo" name="select-Tipo" onchange="direcionar()" style="width:200px">
                        <option value="">Selecione um Tipo</option>
                        <?php
                            foreach (TipoSubmissao::listaTipoSubmissoes() as $tipo) {
                                echo "<option value='".$tipo->getId()."'";
                                if (isset($_GET['idTipo']) && $_GET['idTipo'] == $tipo->getId()) echo " selected";
                                echo ">" . $tipo->getDescricao() . "</option>";
                            }
                        ?>
                    </select>
                    </td>
                    
                </tr>
            </table>
            <br><br>
            <table align="center" class="table table-striped table-bordered dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>*</th>
                        <th>Evento</th>
                        <th>Área</th>
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
                                $resultadoAvaliacao = "";
                                $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getId();
                                
                                // Situações de Avaliação = 1-Pendente, 2-Finalizada, 3-Atrasada, 4-Aprovado(a), 5-Aprovado(a) com ressalvas, 6-Reprovado
                                if (in_array($situacaoAvaliacao, array(1,3))) {
                                    $editarAvaliador = "<a class='editarObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><img src='".$iconEditar."' class='img-miniatura'></a>";
                                            //. "<a class='excluirObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><img src='".$iconExcluir."' class='img-miniatura'></a>";
                                }
                                else {
                                    $editarAvaliador = "<a class='visualizarObjeto' id='".$avaliacao->getId()."' name='Avaliacao'><img src='".$iconVisualizar."' class='img-miniatura'></a>";
                                
                                    if ($situacaoAvaliacao == 2) /* Apresentado */ $resultadoAvaliacao = " - <img src='".$iconOK."' class='img-miniatura' title='Apresentado'>";
                                    else if ($situacaoAvaliacao == 4) /* Aprovado */ $resultadoAvaliacao = " - <img src='".$iconOK."' class='img-miniatura' title='Aprovado'>";
                                    else if ($situacaoAvaliacao == 5) /* Aprovado com Ressalvas */ $resultadoAvaliacao = " - <img src='".$iconOKRessalvas."' class='img-miniatura' title='Aprovado com Ressalvas'>";
                                    else /* Reprovado */ $resultadoAvaliacao = " - <img src='".$iconExcluir."' class='img-miniatura' title='Reprovado'>";
                                }
                                
                                
                                
                                $user = Usuario::retornaDadosUsuario($avaliacao->getIdUsuario());
                                $avaliadores = $avaliadores . "<li>" .$editarAvaliador . $user->getNome() . $resultadoAvaliacao ."</li>";
                            }
                            
                            $avaliadores .= "</ul>";

                            $finalizar="";
                            if (SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao()=="Em avaliacao") {
                                $contAvaliacoesFinalizadas = 0;
                                foreach (Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(), '') as $aval) {
                                    if (in_array($aval->getIdSituacaoAvaliacao(), array(2,4,5,6)) && strtotime(date('d-m-Y'))>strtotime($aval->getDataRealizacaoAvaliacao())) {
                                        $contAvaliacoesFinalizadas++;
                                    }
                                }    
                                if ($contAvaliacoesFinalizadas==3) $finalizar = "<input type='button' class='editarObjeto btn-verde' id='".$submissao->getId()."' name='Finalizacao' value='Finalizar Submissão' />";
                            }
                            
                            
                            $addAvaliador = "";
                            $repetirAvaliadores = "";
                            
                            $situacaoSubmissao = SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao();
                            if ($situacaoSubmissao=="Submetida") {
                                $addAvaliador = "<p align='center'><input type='button' class='addObjeto btn-verde' id='".$submissao->getId()."' name='Avaliacao' value='Adicionar Manualmente'></p>";
                                $addAvaliador .= "<p align='center'><input type='button' class='btn-verde' onclick=\"window.location.href='submissaoForms/wsDistribuirAvaliacoesPorSubmissaoIndividual.php?id=".$submissao->getId()."'\" value='Distribuir Automaticamente'></p>";
                            }
                            
                            if (TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao()=="Final" &&
                                    SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao()=="Submetida") {
                                $repetirAvaliadores = "<p align='center'><input type='button' class='addObjeto btn-verde' id='".$submissao->getId()."' name='AvaliacaoRepetida' value='Repetir Avaliadores' ></p>";
                            }    //date('m/d/Y',$submissao->getDataEnvio());
                    ?>
                            <tr>
                                <td><a onclick="location.href='visualizarSubmissao.php?id=<?php echo $submissao->getId()?>'"><img src='<?php echo $iconVisualizar ?>' class='img-miniatura'></a></td>
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
            <?php 
                include dirname(__FILE__) . '/inc/pFinal.php'; 
            ?>
    </body>
</html>