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
        <title>SS - Gerenciar Avaliações</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>

        <script type="text/javascript">
            function direcionar() {
                var usuario = document.getElementById('select-Usuario').value;
                var situacao = document.getElementById('select-Situacao').value;
                
                var url = 'gerenciarAvaliacoes.php?';
                if (usuario!='') url+='idUsuario='+usuario+'&';
                if (situacao!='') url+='idSituacao='+situacao;

                document.location = url;
            }
         </script>

    </head>
    
    <body>
        
        <?php 
            include './inc/menuInicial.php';
            include './inc/modal.php';

            $idUsuario = "";
            $idSituacao = "";
            
            $vars = "";
            
            if (isset($_GET['idUsuario'])) {
                $idUsuario = $_GET['idUsuario'];
                $vars .= "idUsuario=" . $idUsuario . "&";
            }
            if (isset($_GET['idSituacao'])) {
                $idSituacao = $_GET['idSituacao'];
                $vars .= "idSituacao=" . $idSituacao . "&";
            }
        
            
            $listaAvaliacoes = Avaliacao::listaAvaliacoesComFiltro($idUsuario,'',$idSituacao);
        ?>
        <br>
        
        
        <fieldset>
            <h3 align='center'>Listagem de Avaliações (<?php echo count($listaAvaliacoes)?>)</h3>
            
            <p align="center"><a href="downloads/wsListagemSubmissoes.php?<?php echo $vars ?>">Exportar Planilha Excel</a></p>
            <p align="center">     
                <label for="select-Usuario">Usuario: </label>
                <select class="campoDeEntrada" id="select-Usuario" name="select-Usuario" onchange="direcionar()" style="width: 200px">
                    <option value="">Selecione um Usuário</option>
                    <?php
                        foreach (Avaliador::listaAvaliadoresComFiltro('','','','') as $avaliador) {
                            
                            $user = Usuario::retornaDadosUsuario($avaliador->getIdUsuario());
                            echo "<option value='".$user->getId()."'";
                            if (isset($_GET['idUsuario']) && $_GET['idUsuario'] == $user->getId()) echo " selected";
                            echo ">" . $user->getNome()." ".$user->getSobrenome() ."</option>";
                        }
                    ?>
                </select>
                <label for="select-Situacao">Situação: </label>
                <select class="campoDeEntrada" id="select-Situacao" name="select-Situacao" onchange="direcionar()" style="width: 200px">
                    <option value="">Selecione uma Situação</option>
                    <?php
                        foreach (SituacaoAvaliacao::listaSituacaoAvaliacao() as $tipo) {
                            echo "<option value='".$tipo->getId()."'";
                            if (isset($_GET['idSituacao']) && $_GET['idSituacao'] == $tipo->getId()) echo " selected";
                            echo ">" . $tipo->getDescricao() . "</option>";
                        }
                    ?>
                </select>
                
            </p>
            
            <table border="1" align="center" class='table_list_2'>
                <thead>
                    <tr>
                        <th>*</th>
                        <th>Trabalho</th>
                        <th>Avaliador</th>
                        <th>Situação</th>
                        <th>Data Final para Entrega</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php 
                    if (count($listaAvaliacoes)==0) { ?>
                        <tr><td colspan='4' align=center>Nenhuma Avaliação com os Filtros acima!</td></tr>
                    
                    <?php }
                    else {
                        foreach ($listaAvaliacoes as $avaliacao) {
                            
                            $avaliador = Usuario::retornaDadosUsuario($avaliacao->getIdUsuario());
                            $dataAtual = date('Y-m-d');
                            $situacaoAvaliacao = '';
                            
                            if (strtotime($avaliacao->getPrazo())< strtotime($dataAtual)) {
                                // Situacao: 3-Atrasada
                                Avaliacao::atualizarAvaliacao ($avaliacao->getId(), $avaliacao->getIdUsuario(), 3, $avaliacao->getPrazo());
                                $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao(3)->getDescricao();
                            }
                            else $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao();

                    ?>
                        <tr>
                            <td><a class='visualizarObjeto' id='<?php echo $avaliacao->getId()?>' name='Avaliacao'><img src='<?php echo $iconVisualizar ?>' class='img-miniatura'></a></td>
                            <td><?php echo Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getTitulo()?></td>
                            <td><?php echo $avaliador->getNome() . " " . $avaliador->getSobrenome() ?></td>
                            <td><?php echo $situacaoAvaliacao ?></td>
                            <td><?php 
                                    // SituacaoAvaliacao = 1-Pendente / 3-Atrasada
                                    if ($avaliacao->getIdSituacaoAvaliacao()==1 || $avaliacao->getIdSituacaoAvaliacao()==3) echo date('d/m/Y',strtotime($avaliacao->getPrazo())); 
                                    else echo "-";
                                ?></td>
                        </tr>
                            
                                
                    <?php }
                    }
                ?>
                </tbody>
            </table>
        </fieldset>
    </body>
</html>