<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();
    
    date_default_timezone_set('America/Sao_Paulo');
    

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];

    $avaliadorAreas = Avaliador::listaAvaliadoresComFiltro('', '', $usuario->getId(), '');
    $eventos = Evento::listaEventos();
    
    $dataAtual = date('d-m-Y');
    $eventosComInscricoesParaAvaliadorDisponiveis = false;
    
    
    foreach ($eventos as $evento) {
        
        $dataFimInscricaoAvaliadores = date('d-m-Y', strtotime($evento->getPrazoInscricaoAvaliadores()));                
        
        if (strtotime($dataAtual) <= strtotime($dataFimInscricaoAvaliadores)) {

            $eventosComInscricoesParaAvaliadorDisponiveis = true;
            break;
        }
    }
    
?>

<div class="panel-heading">
    <h3 class="panel-title">Adicionar Solicitação de Avaliador</h3>
</div>

<div class="panel-body">
    
<?php  if (!$eventosComInscricoesParaAvaliadorDisponiveis) {
            echo "<p align=center><strong>Não há eventos com Inscrições para Avaliador Disponíveis!</strong></p>";
        }
        else {
?>
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddSolicitacaoAvaliador.php');?>">
        <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $usuario->getId() ?>">
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Nome do Evento</label> 
                    <select class='form-control' id="select-Eventos" name="select-Eventos" onchange="loadAreas()" required="true">
                        <option value="">Selecione um evento</option>
                        <?php
                            foreach ($eventos as $evento) {
                                $dataFimInscricaoAvaliadores = date('d-m-Y', strtotime($evento->getPrazoInscricaoAvaliadores()));                
                                if (strtotime($dataFimInscricaoAvaliadores) <= strtotime($dataAtual)) {echo "<option value='".$evento->getId()."'>".$evento->getNome()."</option>";}
                            }
                        ?>
                    </select>
                <div class="help-inline ">

                </div>
            </div>
            <div class="col-md-12  mb-4">
                <label for="e.address">Área</label> 
                    <select class='form-control' id="select-Areas" name="select-Areas" required="true"></select>
                <div class="help-inline ">

                </div>
            </div>
        </div>
        <div class="control-group form-actions">
            <div class="row">
                <div class="col-md-3 mb-4">
                <button class="btn btn-lg btn-primary btn-block mb-8" type="submit">Solicitar</button>
                </div>

                <div class="col-md-3 mb-4">
                    <a class="btn btn-lg btn-default  btn-block" onclick="$('#modal').fadeOut(500)">Retornar</a>
                </div>
            </div>
        </div>
    </form>
    <?php if (count($avaliadorAreas)>0) {?>
        <div class="row">
            <div class="col-md-12  mb-4">
                <table align="center" class="table table-striped table-bordered dt-responsive nowrap">
                    <tr><td align="center"><strong>Eventos/Áreas nos quais o Usuário já é avaliador: </strong></td></tr>
                    <tr><td>
                        <ol  style="margin-left: 10%">
                            <?php foreach ($avaliadorAreas as $avaliadorArea) {?>
                            <li><strong>Evento:</strong> <?php echo Evento::retornaDadosEvento($avaliadorArea->getIdEvento())->getNome()?> / 
                                <strong>Área: </strong> <?php echo Area::retornaDadosArea($avaliadorArea->getIdArea())->getDescricao()?>
                            <?php }?>
                        </ol>
                        </td>
                    </tr>
                </table>
                    
                <div class="help-inline ">

                </div>
            </div>	
        </div>
    <?php }?>

<?php }?>
</div>



        
          
            
        
