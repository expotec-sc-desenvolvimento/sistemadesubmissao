<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"./paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
    
   // if (!Avaliacao::atualizarSituacaoAvaliacoes()) {
     //   echo "erro"; exit(1);
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
        <title>SS - Gerenciar Avaliações</title>
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
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
            include 'inc/pInicial.php';
            include 'inc/modal.php';

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
            
            <p align="center"><a href="downloads/wsListagemAvaliacoes.php?<?php echo $vars ?>">Exportar Planilha Excel</a></p>
            <table align="center">     
                <tr><td>
                <label for="select-Usuario">Usuario: </label>
                <select class="form-control" id="select-Usuario" name="select-Usuario" onchange="direcionar()" style="width: 200px">
                    <option value="">Selecione um Usuário</option>
		    <?php
			$userListado = array();
                        foreach (Avaliador::listaAvaliadoresComFiltro('','','','') as $avaliador) {
                            
			    $user = UsuarioPedrina::retornaDadosUsuario($avaliador->getIdUsuario());

			    if (in_array($user->getId(),$userListado)) continue;
                            echo "<option value='".$user->getId()."'";
                            if (isset($_GET['idUsuario']) && $_GET['idUsuario'] == $user->getId()) echo " selected";
			    echo ">" . $user->getNome() ."</option>";
			    array_push($userListado,$user->getId());
                        }
                    ?>
                </select>
                </td><td>
                <label for="select-Situacao">Situação: </label>
                <select class="form-control" id="select-Situacao" name="select-Situacao" onchange="direcionar()" style="width: 200px">
                    <option value="">Selecione uma Situação</option>
                    <?php
                        foreach (SituacaoAvaliacao::listaSituacaoAvaliacao() as $tipo) {
                            echo "<option value='".$tipo->getId()."'";
                            if (isset($_GET['idSituacao']) && $_GET['idSituacao'] == $tipo->getId()) echo " selected";
                            echo ">" . $tipo->getDescricao() . "</option>";
                        }
                        
                    ?>
                </select>
                </td><tr>
            </table>
            <br><br>
            <table border="1" align="center" class='table table-striped table-bordered dt-responsive nowrap' >
                <thead>
                    <tr>
                        <th style="text-align: center">*</th>
                        <th style="text-align: center">Trabalho</th>
                        <th style="text-align: center">Tipo</th>
                        <th style="text-align: center">Avaliador</th>
                        <th style="text-align: center">Situação</th>
                        <th style="text-align: center">Data de Recebimento</th>
                        <th style="text-align: center">Data de Realização da Avaliação</th>
                        <th style="text-align: center">Data Final para Entrega</th>
                        <th style="text-align: center">Observação</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php 
                    if (count($listaAvaliacoes)==0) { ?>
                        <tr><td colspan='9' align=center>Nenhuma Avaliação com os Filtros acima!</td></tr>
                    
                    <?php }
                    else {
                        foreach ($listaAvaliacoes as $avaliacao) {
                            
                            $avaliador = UsuarioPedrina::retornaDadosUsuario($avaliacao->getIdUsuario());
                            $dataAtual = date('Y-m-d');
                            $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao())->getDescricao();
                            

                    ?>
                        <tr>
                            <td align="center" style="vertical-align: middle;">
                                <?php if ($avaliacao->getIdSituacaoAvaliacao()==1 ||$avaliacao->getIdSituacaoAvaliacao()==3 ) {?>
                                    <a class='editarObjeto' id='<?php echo $avaliacao->getId()?>' name='Avaliacao'><i class="fa fa-edit m-right-xs"></i></a>
                                <?php } else { ?>
                                    <a class='visualizarObjeto' id='<?php echo $avaliacao->getId()?>' name='Avaliacao'><i class="fa fa-search m-right-xs"></i></a>
                                <?php } ?>    
                            </td>
                            <td><?php echo Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getTitulo()?></td>
                            <td><?php echo TipoSubmissao::retornaDadosTipoSubmissao(Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao())->getIdTipoSubmissao())->getDescricao()?></td>
                            <td><?php echo $avaliador->getNome() ?></td>
                            <td><?php echo $situacaoAvaliacao ?></td>
                            <td><?php echo date('d/m/Y', strtotime($avaliacao->getDataRecebimento())) ?></td>
                            <td><?php echo $avaliacao->getDataRealizacaoAvaliacao()=='' ? "-" : date('d/m/Y',strtotime($avaliacao->getDataRealizacaoAvaliacao())) ?></td>
                            <td><?php 
                                    // SituacaoAvaliacao = 1-Pendente / 3-Atrasada
                                    if ($avaliacao->getIdSituacaoAvaliacao()==1 || $avaliacao->getIdSituacaoAvaliacao()==3) echo date('d/m/Y',strtotime($avaliacao->getPrazo())); 
                                    else echo "-";
                                ?></td>
                            <td><?php
                                    if ($avaliacao->getIdSituacaoAvaliacao()==1 || $avaliacao->getIdSituacaoAvaliacao()==3) {
                                        $prazoEntrega = strtotime(date($avaliacao->getPrazo())); 
                                        $dataAtual = strtotime(date('Y-m-d'));
                                        // verifica a diferença em segundos entre as duas datas e divide pelo número de segundos que um dia possui
                                        
                                        $diferenca = ($prazoEntrega - $dataAtual) /86400;
                                        // caso a data 2 seja menor que a data 1
                                        
                                        if ($diferenca>0) echo $diferenca . " para término do prazo!";
                                        else if ($diferenca<0) echo -($diferenca) . " dia(s) de atraso!";
                                        else echo "<strong>Último dia para entrega da Avaliação</strong>";
                                        
                                    }
                                    else echo "-";
                                    
                            
                            ?></td>
                        </tr>
                            
                                
                    <?php }
                    }
                ?>
                </tbody>
            </table>
        </fieldset>
        <?php 
            include 'inc/pFinal.php';
        ?>
    </body>
</html>
