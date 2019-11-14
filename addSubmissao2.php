<?php

    include './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
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
</script>



<?php  if (!$eventosComSubmissoesDisponiveis) {
            echo "<p align=center><strong>Não há eventos com datas disponíveis para Submissão</strong></p>";
        }
        else {
?>





<div class="panel-heading">
    <h3 class="panel-title">Adicionar Submissão</h3>
</div>
<div class="panel-body">

    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddSubmissao.php');?>" enctype="multipart/form-data" onsubmit="submeterAutores('<?php echo $usuario->getId()?>')">
        <input type="hidden" id="idUsuariosAdd" name="idUsuariosAdd">


        <div class="row">
            <div class="col-md-4 mb-4">
                <label class="control-label">Evento</label>
                    <select class='form-control' id="select-Eventos" name="select-Eventos" onchange="loadAreas();loadModalidades('')" required="true">
                        <option value="">Selecione um evento</option>
                        <?php
                            foreach ($eventos as $evento) {

                                $dataInicioSubmissao = date('d-m-Y', strtotime($evento->getInicioSubmissao()));
                                $dataFimSubmissao = date('d-m-Y', strtotime($evento->getFimSubmissao()));

                                if (strtotime($dataInicioSubmissao) <= strtotime($dataAtual) && strtotime($dataAtual) <= strtotime($dataFimSubmissao)) {
                                    echo "<option value='".$evento->getId()."'>".$evento->getNome()."</option>";
                                }

                            }
                        ?>
                    </select>

                <div class="help-inline ">

                </div>
            </div>

            <div class="col-md-4 mb-4">
                <label class="control-label">Modalidade</label>
                    <div id="modalidade"><select class='form-control' id="select-Modalidades" name="select-Modalidades" required="true"><option value="">Selecione uma Modalidade</option></select></div>
                <div class="help-inline ">

                </div>
            </div>


            <div class="col-md-4 mb-4">
                <label for="select-Areas">Área</label> 
                    <div id="areas"><select class='form-control' id="select-Areas" name="select-Areas" required="true"><option value="">Selecione uma área</option></select></div>
                <div class="help-inline ">

                </div>
            </div>

        </div>
        <hr/>

        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Título</label> 
                    <input class="form-control" id="titulo" name="titulo" required="true">
                <div class="help-inline ">

                </div>
            </div>	
        </div>


        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="resumo">Resumo</label> 
                <textarea id="resumo" name="resumo" rows="10" class="form-control"  style="resize:none"></textarea>
                <div class="help-inline ">

                </div>
            </div>	
        </div>


        <div class="row">

            <div class="col-md-4 mb-4">
                    <label for="e.contact">Palavras-Chave</label>
                        <input class="form-control" id="palavrasChave" name="palavrasChave" required="true">
                    <div class="help-inline ">
                        Inserir de 3 a 5 palavras-chave, Separadas por vírgula (Ex.: palavra1, palavra2)
                    </div>
            </div>

            <div class="col-md-4 mb-4">
                <label for="e.contact">Relação com</label>
                <select class='form-control' id="relacaoCom" name="relacaoCom">
                    <option value="TCC">TCC</option>
                    <option value="PI">PI</option>
                    <option value="-" selected="">Nenhuma das Alternativas
                </select>
                <div class="help-inline ">

                </div>
            </div>

            <div class="col-md-4  mb-4">
                <label  for="arquivo" >Arquivo</label>
                <input class="form-control" type="file" id="arquivo" name="arquivo" required>
                <div class="help-inline ">
                    Arquivo em PDF
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
                <input class="btn btn-lg btn-primary btn-block mb-4" type="submit"  id='botaoSubmeter' value="Submeter Trabalho">
                </div>

                <div class="col-md-3 mb-4">
                    <a class="btn btn-lg btn-default  btn-block" href="minhasSubmissoes.php">Retornar</a>
                </div>
            </div>
        </div>

    </form>
</div>

        
    <?php 
	if (isset($_GET['idEvento']) && isset($_GET['idModalidade'])) {
	     echo "<script>
		     document.getElementById('select-Eventos').value = ".$_GET['idEvento'].";
		     loadModalidades('".$_GET['idModalidade']."');
		     loadAreas();
		  </script>";
	}
    }?>

<?php 
    include './inc/pFinal.php';
?>
</body>
</html>
