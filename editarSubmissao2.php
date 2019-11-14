<?php

    include './inc/includes.php';
    
    session_start();    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    loginObrigatorio();

    
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
        <title>SS - Editar Submissão </title>
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>        
    </head>
    
    <body>
        
        <?php 
            include './inc/pInicial.php';
        ?>


<script type="text/javascript">
    var idUsersSelected = [];
    var nomeUsersSelected = [];
    //var idUserSubmissor;

    function verificarArquivo () {
	if (document.getElementById('novoArquivo').checked==false) document.getElementById('arquivo').value='';
	else if (document.getElementById('novoArquivo').checked==true && document.getElementById('arquivo').value=='') {
	    alert('Selecione um arquivo, caso deseje substituir o arquivo anteriormente submetido!');
	    document.getElementById('novoArquivo').checked=false;
	}
    }
</script>




<div class="panel-heading">
    <h3 class="panel-title">Editar Submissão</h3>
</div>
<div class="panel-body">

    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarSubmissao.php');?>" enctype="multipart/form-data" onsubmit="submeterAutores('<?php echo $usuario->getId()?>')">
        <input type="hidden" id="idSubmissao" name="idSubmissao" value="<?php echo $submissao->getId() ?>">
        <input type="hidden" id="idUsuariosAdd" name="idUsuariosAdd">


        <div class="row">
            <div class="col-md-4 mb-4">
                <label class="control-label">Evento</label>
                    <input type='hidden' id="select-Eventos" name="select-Eventos" value="<?php echo $submissao->getIdEvento()?>">
                    <input class='form-control' readonly="true" value="<?php echo $evento ?>">
                <div class="help-inline ">

                </div>
            </div>

            <div class="col-md-4 mb-4">
                <label class="control-label">Modalidade</label>
                    <input type='hidden' id="select-Modalidades" name="select-Modalidades" value="<?php echo $submissao->getIdModalidade()?>">
                    <input class='form-control' readonly="true" value="<?php echo $modalidade ?>">
                <div class="help-inline ">

                </div>
            </div>


            <div class="col-md-4 mb-4">
                <label for="select-Areas">Área</label> 
                    <input type='hidden' id="select-Areas" name="select-Areas" value="<?php echo $submissao->getIdArea()?>">
                    <input class='form-control' readonly="true" value="<?php echo $area ?>">
                <div class="help-inline ">

                </div>
            </div>

        </div>
        <hr/>

        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Título</label> 
                    <input class="form-control" id="titulo" name="titulo" required="true" value="<?php echo $submissao->getTitulo()?>">
                <div class="help-inline ">

                </div>
            </div>	
        </div>


        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="resumo">Resumo</label> 
                <textarea id="resumo" name="resumo" rows="10" class="form-control" required="true" style="resize:none"><?php echo $submissao->getResumo() ?></textarea>
                <div class="help-inline ">

                </div>
            </div>	
        </div>


        <div class="row">

            <div class="col-md-4 mb-4">
                    <label for="e.contact">Palavras-Chave</label>
                        <input class="form-control" id="palavrasChave" name="palavrasChave" required="true" value="<?php echo $submissao->getPalavrasChave()?>">
                    <div class="help-inline ">
                        Inserir de 3 a 5 palavras-chave, Separadas por vírgula (Ex.: palavra1; palavra2)
                    </div>
            </div>

            <div class="col-md-4 mb-4">
                <label for="e.contact">Relação com</label>
                <select class='form-control' id="relacaoCom" name="relacaoCom">
                    <option value="TCC" <?php if ($submissao->getRelacaoCom()=='TCC') echo "selected"?>>TCC</option>
                    <option value="PI" <?php if ($submissao->getRelacaoCom()=='PI') echo "selected"?>>PI</option>
                    <option value="-" <?php if ($submissao->getRelacaoCom()=='-') echo "selected"?>>Nenhuma das Alternativas</option>
                </select>
                <div class="help-inline ">

                </div>
            </div>

            <div class="col-md-4  mb-4">
                <label  for="arquivo" >Arquivo</label>
		<input class="form-control" type="file" id="arquivo" name="arquivo" onchange="document.getElementById('novoArquivo').checked=true;">
                <div class="help-inline ">
		<input type='checkbox' id='novoArquivo' name='novoArquivo' onclick="verificarArquivo()"> Adicionar novo arquivo (caso essa caixa não seja marcada, será mantido o arquivo anterior)
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Autores</label><br>
                    <div style="float: left"><?php echo $usuario->getNome() . "<img src='" . $iconOK. "' class='img-miniatura'>"?></div>
                    <div id='users-selected'></div>
                <div class="help-inline ">

                </div>
            </div>
        </div>
        <div class="row">	
            <div class="col-md-12  mb-4">
                <input class="form-control" id="buscaUsers" onkeydown="usuariosSubmissao('buscaUsers','resposta','<?php echo $usuario->getId() ?>')" placeholder="Digite parte do nome do Usuário..." autocomplete="off">
                    <div id="resposta"  style="left: 51px; width: 879px; top: 401.6px; bottom: auto;display: none;"></div>
                <div class="help-inline ">

                </div>
            </div>
        </div>


        <script>
                $(function(){
                         $('#about').summernote({
                                 airMode: true,
                                 popover: {
                                        air: [
                                            // [groupName, [list of button]]
                                            ['style', ['bold', 'italic', 'underline', 'clear']],
                                            ['fontsize', ['fontsize']],
                                            ['color', ['color']],
                                            ['insert', ['link']],
                                            ['para', ['ul', 'ol', 'paragraph']],
                                          ]
                                 }
                         });
                });

        </script>


        <input type='hidden' name="e.id" value="1">

        <div class="control-group form-actions">
            <div class="row">
                <div class="col-md-3 mb-4">
                                <input class="btn btn-lg btn-primary btn-block mb-4" type="submit"  id='botaoSubmeter' value="Atualizar Submissão">
                </div>

                <div class="col-md-3 mb-4">
                    <a class="btn btn-lg btn-default  btn-block" href="minhasSubmissoes.php">Retornar</a>
                </div>
            </div>
        </div>

    </form>
</div>

        
<?php
            $usuariosDaSubmissao = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '','','');
            
            foreach ($usuariosDaSubmissao as $usuarioSubmissao) {
                $user = UsuarioPedrina::retornaDadosUsuario($usuarioSubmissao->getIdUsuario());
                if ($usuarioSubmissao->getIsSubmissor() == 1) continue;
                echo "<script>adicionarId('".$user->getId()."','".$user->getNome()."','".$iconExcluir."')</script>";
            }
        ?>

<?php include dirname(__FILE__) . '/inc/pFinal.php'; ?>

        </body>
</html>
