<?php
    include './inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    //verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
    if ($submissao->getId()=="") header('Location: paginaInicial.php');
    
    // Caso o usuário não seja administrador e não seja usuário da submissão
    if (count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), $usuario->getId(), '','',''))==0 
            && Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao()!="Administrador") header('Location: paginaInicial.php');
    
    $tipoSubmissao = TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao();
    $titulo = $submissao->getTitulo();
    $evento = Evento::retornaDadosEvento($submissao->getIdEvento())->getNome();
    $area = Area::retornaDadosArea($submissao->getIdArea())->getDescricao();
    $modalidade = Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao();
    $palavrasChave = $submissao->getPalavrasChave();
    $situacao = SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Visualizar Submissão </title>
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>        
    </head>
    
    <body>
        
        <?php 
            include './inc/pInicial.php';
        ?>



    
        

    <div class="panel-heading">
        <h3 class="panel-title">Visualizar Submissão</h3>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-md-4 mb-4">
                <label class="control-label">Evento</label>
                <input class='form-control' readonly="true" value="<?php echo $evento ?>">
                <div class="help-inline ">

                </div>
            </div>

            <div class="col-md-4 mb-4">
                <label class="control-label">Modalidade</label>
                <input class='form-control' readonly="true" value="<?php echo $modalidade ?>">
                <div class="help-inline ">

                </div>
            </div>


            <div class="col-md-4 mb-4">
                <label class="control-label">Área</label>
                <input class='form-control' readonly="true" value="<?php echo $area ?>">
                <div class="help-inline ">

                </div>
            </div>

        </div>
        <hr/>

        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Título</label> 
                    <input class="form-control" readonly="true" value="<?php echo $titulo ?>">
                <div class="help-inline ">

                </div>
            </div>	
        </div>


        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="resumo">Resumo</label> 
                <textarea readonly="true" rows="10" class="form-control"  style="resize:none"><?php echo $submissao->getResumo() ?></textarea>
                <div class="help-inline ">

                </div>
            </div>	
        </div>


        <div class="row">

            <div class="col-md-4 mb-4">
                    <label for="e.contact">Palavras-Chave</label>
                    <input class="form-control" readonly="true" value="<?php echo $submissao->getPalavrasChave() ?>">
                    <div class="help-inline ">

                    </div>
            </div>

            <div class="col-md-4 mb-4">
                <label for="e.contact">Relação com</label>
                <input class="form-control" readonly="true" value="<?php echo $submissao->getRelacaoCom() ?>">
                <div class="help-inline ">

                </div>
            </div>

            <div class="col-md-4  mb-4">
                <label  for="arquivo" >Tipo de Submissão</label>
                <input class="form-control" readonly="true" value="<?php echo $tipoSubmissao ?>">
                <div class="help-inline ">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="situacao">Situação da Submissão</label> 
                <input class="form-control" readonly="true" value="<?php echo $situacao ?>">
                <div class="help-inline ">

                </div>
            </div>	
        </div>

        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Autores</label><br>
                    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsGerenciarApresentacaoTrabalho.php');?>" onsubmit="return confirm('Deseja atualizar os alunos que apresentaram este Trabalho?')"> <!-- Adicionado para contemplar a parte de apresentação de trabalhos-->
                        <input type="hidden" name="submissao" id="submissao" value="<?php echo $submissao->getId() ?>">
                        <ul style='list-style-type: none;'>
                            <?php
                                $botaoEnviar = "";
                                foreach(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '','','') as $obj) {
                                    $user = UsuarioPedrina::retornaDadosUsuario($obj->getIdUsuario());
                                    /*
                                     * O Código a seguir foi acrescentado para marcar os alunos que apresentaram o trabalho na EXPOTEC e que estão aptos a receber o certificado de
                                     * apresentação
                                     */
                                    $checkBoxApresentacao = "";
                                    
                                    if ($submissao->getIdTipoSubmissao()==3 && $usuario->getIdPerfil()==1) { // Caso o usuário logado seja um administrador e esta submissao for uma submissao final...
                                        $checked = "";
                                        $botaoEnviar = "<br><input type='submit' class='btn btn-sm marginTB-xs btn-success' value='Atualizar Apresentação de Trabalho'>";
                                        
                                        if ($obj->getApresentouTrabalho()==1) $checked = " checked";
                                        $checkBoxApresentacao = "<input type='checkbox' name='apresentados[]' id='apresentados[]' value='".$obj->getId()."' ".$checked.">";
                                    }


                                    if ($user->getPicture()!=NULL) echo "<li><div>".$checkBoxApresentacao."<img class='flag' src='/expotecsc/attendees/getuserpicture/".$user->getId()."/'>" .$user->getNome();
                                    else echo "<li><div>".$checkBoxApresentacao."<img class='flag' src='public/img/semFoto.jpg'>" .$user->getNome();
                                    if ($obj->getIsSubmissor()==1) echo "(Submissor)";
                                }
                                echo $botaoEnviar;
                            ?>
                        </ul>
                    </form>
                <div class="help-inline ">

                </div>
            </div>
        </div>
        <hr/>
        <div class="panel-heading">
            <h3 class="panel-title">Avaliações</h3>
        </div>
        <?php 
    $avaliacoes = Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(),'');

//    if (count($avaliacoes)==0) {
    if (count($avaliacoes)==0 || $submissao->getIdSituacaoSubmissao()==3) {
        echo "<p align='center'><strong>Nenhuma Avaliação Cadastrada/Finalizada para a Submissão</strong></p>";
    } else {
        $cont = 1;
        foreach ($avaliacoes as $avaliacao) {

            $user = UsuarioPedrina::retornaDadosUsuario($avaliacao->getIdUsuario());
            $situacaoAvaliacao = SituacaoAvaliacao::retornaDadosSituacaoAvaliacao($avaliacao->getIdSituacaoAvaliacao());

            $nomeCompleto = "Avaliador $cont";
            $cont++;
            if (Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao() == "Administrador") $nomeCompleto = $user->getNome();

            echo "<table align='center' class='table table-striped table-bordered dt-responsive nowrap'>"
                ."<tr><th class='direita' width='10px'>Avaliador: </th><td style='text-align:left; padding-left:10px;'>" . $nomeCompleto . "</td>"
                ."<tr><th class='direita'>Situação: </th><td style='text-align:left; padding-left:10px;'>" . $situacaoAvaliacao->getDescricao() . "</td>";


            // Situação 4 - Aprovado, 5 - Aprovado Com Ressalvas, 6 - Reprovado(a) 
            if (in_array($situacaoAvaliacao->getId(), array('2','4','5','6'))) {
                if (!($avaliacao->getObservacao() == 'AVALIAÇÃO GERADA AUTOMATICAMENTE PELO SISTEMA')) {

                    echo "<tr><th class='direita' width='10px'>Avaliação: </th><td>";
                    $avaliacaoCriterios = AvaliacaoCriterio::retornaCriteriosParaAvaliacao($avaliacao->getId());

		    echo "<ul class='listaCriterios'>";
		    $cont=1;		    
                    foreach ($avaliacaoCriterios as $avaliacaoCriterio) {
                        $criterio = Criterio::retornaDadosCriterio($avaliacaoCriterio->getIdCriterio());
                        echo "<li> ".$cont++." - ".$criterio->getDescricao();
                        //if ($submissao->getIdTipoSubmissao()==3) echo "(" .$criterio->getPeso().")";
                        echo " - ";
                        if ($submissao->getIdTipoSubmissao()==3) echo "<strong>" . $avaliacaoCriterio->getNota() . "</strong><br>";
                        else echo $avaliacaoCriterio->getNota()==1 ? "<b>Sim</b><br>" : "<b>Não</b><br>";
                    }
                    echo "</ul>";

                    if ($submissao->getIdTipoSubmissao()==3) echo "<tr><th class='direita'>Nota Final: </th><td><strong>". $avaliacao->getNota()."</strong></td>";
                }
                echo "<tr><th class='direita'>Observações:</th><td style='text-align:left; padding-left:10px;'><p style='white-space:pre-line;text-align=justify'>" . $avaliacao->getObservacao() . "</p></td></tr>";

            }

            echo "</table><br>";
        }
    }
?>

        
        <div class="control-group form-actions">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <a class="btn btn-lg btn-default  btn-block" href="<?php echo $_SERVER["HTTP_REFERER"] ?>">Retornar</a>
                </div>
            </div>
        </div>


    </div>
        


        
        <?php include dirname(__FILE__) . '/inc/pFinal.php'; ?>

        </body>
</html>
        
