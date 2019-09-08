<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    date_default_timezone_set('America/Sao_Paulo');
    
    // O código abaixo verifica se há eventos com datas disponíveis para submissão
    $eventos = Evento::listaEventos();

    $dataAtual = date('d-m-Y');

    $eventosComSubmissoesDisponiveis = false;
    foreach ($eventos as $evento) {
        $dataInicioSubmissao = date('d-m-Y', strtotime($evento->getInicioSubmissao()));
        $dataFimSubmissao = date('d-m-Y', strtotime($evento->getFimSubmissao()));                
        if (strtotime($dataInicioSubmissao) <= strtotime($dataAtual) && strtotime($dataAtual) <= strtotime($dataFimSubmissao)) {
            $eventosComSubmissoesDisponiveis = true;
            break;
        }
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
        <title>SS - Adicionar Submissão </title>
        <?php
            include dirname(__DIR__) . '/inc/css.php';
            include dirname(__DIR__) .'/inc/javascript.php';
        ?>
        <script>
            $(document).on('click', '.img-perfil', function(){
                $('#inpImagem').click();
            });
            $(document).on('change', '#inpImagem', function(){
                $('#botaoConfirmar').click();
            });
        </script>
    </head>
    
    <body>
        
        <?php 
            include dirname(__DIR__) . '/inc/pInicial.php';
        ?>


<script type="text/javascript">
    var idUsersSelected = [];
    var nomeUsersSelected = [];
    //var idUserSubmissor;
</script>

<div class="titulo-modal">Adicionar Submissão</div>

<?php  if (!$eventosComSubmissoesDisponiveis) {
            echo "<p align=center><strong>Não há eventos com datas disponíveis para Submissão</strong></p>";
        }
        else {
?>

<div class="main-content">
            <div class="container-fluid">
				<div class="breadcrumbs">9&ordf; EXPOTEC/SC</div>
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            
    Editar Evento

                        </h3>
                        <p class="panel-subtitle"> </p>
                    </div>
                    <div class="panel-body">
                        





<form action="/expotecsc/administrators/saveevent" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="form-horizontal" >
<input type="hidden" name="authenticityToken" value="ca318b21daab2daa48af7caaf3bf84daed6c1837"/>
 
    <div class="row">
	
	<div class="col-md-4  mb-8">
		<label for="e.title">Nome</label> <input
			type="text" id="e.title" name="e.title"
			value="9&ordf; EXPOTEC/SC" class="form-control"
			placeholder="Nome" required minlength="1" maxlength="150">
		<div class="help-inline ">
			
		</div>
	</div>
	
	
	<div class="col-md-8 mb-4">
		<label for="e.edition">Tema</label> 
		<input type="text" id="e.edition" name="e.edition" 
			value="Construindo conex&otilde;es, mudando vidas: O IFRN na regi&atilde;o Trairi" class="form-control" maxlength="100"
			placeholder="Tema" required/>
		<div class="help-inline ">
			
		</div>
	</div>
	
</div>

<div class="row">
	
	<div class="col-md-8  mb-4">
		<label for="e.address">Endereço</label> <input
			type="text" id="e.address" name="e.address"
			value="Rua S&atilde;o Braz, 304, Bairro Para&iacute;so Santa Cruz-RN ,  CEP: 59200-000" class="form-control"
			placeholder="address" required minlength="1" maxlength="150">
		<div class="help-inline ">
			
		</div>
	</div>
	
	
	<div class="col-md-4 mb-4">
		<label for="e.organization">Organização</label> 
		<input type="text" id="e.organization" name="e.organization" 
			value="IFRN | Santa Cruz" class="form-control"  maxlength="150"
			placeholder="Organização" required />
		<div class="help-inline ">
			
		</div>
	</div>
	
</div>

<div class="row">
	
	<div class="col-md-4 mb-4">
		<label class="control-label">Abertura</label>
		<div class="input-group">
			<input type="date" value="2019-11-18" 
				id="e.start" name="e.start"
				class="form-control"> 
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		</div>
		<div class="help-inline ">
			
		</div>
	</div>
	
	
	
	<div class="col-md-4 mb-4">
		<label class="control-label">Encerramento</label>
		<div class="input-group">
			<input type="date" value="2019-11-21" id="e.end" name="e.end"
				class="form-control">
			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		</div>
		<div class="help-inline ">
			
		</div>
	</div>
	
	
	<div class="col-md-4 mb-4">
		<label for="e.promoVideo">Vídeo Promocional (Youtube)</label> 
		<input type="url" id="e.promoVideo" name="e.promoVideo" 
			value="https://www.youtube.com/embed/WTyv_ALzgh8" class="form-control"
			placeholder="www.youtube.com"/>
		<div class="help-inline ">
			
		</div>
	</div>
	
</div>
<hr/>

<div class="row">
	
	<div class="col-md-12  mb-4">
		<label for="e.about">Sobre o Evento</label> 
		
		<textarea id="about" name="e.about"  rows="10"
			 class="form-control"  style="resize:none">Instituto Federal de Educa&ccedil;&atilde;o, Ci&ecirc;ncia e Tecnologia do Rio Grande do Norte (IFRN), Campus Santa Cruz, promove anualmente a EXPOTEC, um evento de Exposi&ccedil;&atilde;o Cient&iacute;fica, Tecnol&oacute;gica e Cultural, realizado na cidade de Santa Cruz. Em sua nona edi&ccedil;&atilde;o, a EXPOTEC 2019 ter&aacute; como tema Construindo conex&otilde;es, mudando vidas: O IFRN na regi&atilde;o Trairi, evidenciando trabalhos de pesquisa, extens&atilde;o, inova&ccedil;&atilde;o e ensino acerca das tecnologias empregadas na contemporaneidade.O evento apresenta uma mostra dos trabalhos produzidos por alunos, servidores, professores, e pesquisadores da regi&atilde;o, nas &aacute;reas de ensino, pesquisa e extens&atilde;o, promovendo o desenvolvimento tecnol&oacute;gico de estudantes do ensino m&eacute;dio, ensino t&eacute;cnico e ensino superior.Localizado na cidade de Santa Cruz, no interior do estado do Rio Grande do Norte, o IFRN - Campus Santa Cruz vem desenvolvendo importantes pesquisas e projetos voltados ao desenvolvimento da regi&atilde;o, seja no &acirc;mbito tecnol&oacute;gico, seja na forma&ccedil;&atilde;o inicial e continuada de profissionais de diversas &aacute;reas, seja no desenvolvimento cultural e social. Tais projetos e pesquisas precisam e devem ser divulgados e tornados p&uacute;blicos na regi&atilde;o e fora dela, possibilitando a aplica&ccedil;&atilde;o de tais conhecimentos. A realiza&ccedil;&atilde;o da EXPOTEC em &acirc;mbito regional justifica-se pela oportunidade de estimular a produ&ccedil;&atilde;o cient&iacute;fica dos diversos Campi do IFRN e das demais institui&ccedil;&otilde;es de educa&ccedil;&atilde;o da cidade e regi&atilde;o (UFRN, UERN, universidades privadas, escolas de ensino fundamental e m&eacute;dio das redes p&uacute;blica e privada).</textarea>
		<div class="help-inline ">
			
		</div>
	</div>
	
</div>


<div class="row">
	
	<div class="col-md-4 mb-4">
		<label for="e.contact">Contatos</label> 
		<input type="text" id="e.contact" name="e.contact" 
			value="(84) 4005-4110 / 3291-4700" class="form-control" maxlength="50"
			placeholder="Contatos"/>
		<div class="help-inline ">
			
		</div>
	</div>
	
	
	<div class="col-md-4 mb-4">
		<label for="e.blog">Blog</label> 
		<input type="url" id="e.blog" name="e.blog" 
			value="http://lausana.ifrn.edu.br/blog" class="form-control"
			placeholder="Blog"/>
		<div class="help-inline ">
			
		</div>
	</div>
	
	
    <div class="col-md-4  mb-4">
        <label  for="e.logo" >Logo</label>
        <input type="file"  id="e.logo" name="e.logo" class="form-control"/>
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
            	<button class="btn btn-lg btn-primary btn-block mb-4" type="submit" >Salvar</button>
	    	</div>
        
      		<div class="col-md-3 mb-4">
      			<a class="btn btn-lg btn-default  btn-block" href="/expotecsc/administrators/listevents">Cancelar</a>
        	</div>
    	</div>
    </div>

</form>



 
                    </div>
                </div>
            </div>
        </div>
        
        <?php }?>

