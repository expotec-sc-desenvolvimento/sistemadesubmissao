<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();
    
    date_default_timezone_set('America/Sao_Paulo');
    

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    $avaliadorAreas = Avaliador::listaAvaliadoresComFiltro('', '', $usuario->getId(), '');
    $eventos = Evento::listaEventos();
    
    $dataAtual = date('d-m-Y');
    $eventosComInscricoesParaAvaliadorDisponiveis = false;
    
    
    foreach ($eventos as $evento) {
        
        $dataFimInscricaoAvaliadores = date('d-m-Y', strtotime($evento->getPrazoInscricaoAvaliadores()));                
        
        if (strtotime($dataAtual) < strtotime($dataFimInscricaoAvaliadores)) {

            $eventosComInscricoesParaAvaliadorDisponiveis = true;
            break;
        }
    }
    
?>

<div class="titulo-modal">Adicionar Solicitação de Avaliador</div>

<div class="itens-modal">

<?php  if (!$eventosComInscricoesParaAvaliadorDisponiveis) {
            echo "<p align=center><strong>Não há eventos com Inscrições para Avaliador Disponíveis!</strong></p>";
        }
        else {
?>
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddSolicitacaoAvaliador.php');?>">
        <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $usuario->getId() ?>">

        <table class='cadastroItens'>
            <tr>
                <th>Selecione o Evento: </th>
                <td>
                    <select class='campoDeEntrada' id="select-Eventos" name="select-Eventos" onchange="loadAreas()" required="true">
                        <option value="">Selecione um evento</option>
                        <?php
                            foreach ($eventos as $evento) {
                                $dataFimInscricaoAvaliadores = date('d-m-Y', strtotime($evento->getPrazoInscricaoAvaliadores()));                
                                if (strtotime($dataFimInscricaoAvaliadores) <= strtotime($dataAtual)) {echo "<option value='".$evento->getId()."'>".$evento->getNome()."</option>";}
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Selecione a Área: </th>
                <td>
                    <select class='campoDeEntrada' id="select-Areas" name="select-Areas" required="true"></select>
                </td>
            </tr>
        </table>

        <div class='div-btn'><input type='submit' class='btn-verde' value='Enviar Solicitação' onclick="return listaIds()"></div>
    </form>
<?php } ?>
        <?php if (count($avaliadorAreas)>0) {?>
            <p align='center'><strong>Eventos/Áreas nos quais o Usuário já é avaliador: </strong></p>
            <ol  style="margin-left: 10%">
                <?php foreach ($avaliadorAreas as $avaliadorArea) {?>
                <li><strong>Evento:</strong> <?php echo Evento::retornaDadosEvento($avaliadorArea->getIdEvento())->getNome()?> / 
                    <strong>Área: </strong> <?php echo Area::retornaDadosArea($avaliadorArea->getIdArea())->getDescricao()?>
                <?php }?>
            </ol>
        <?php }?>
    
    
</div>