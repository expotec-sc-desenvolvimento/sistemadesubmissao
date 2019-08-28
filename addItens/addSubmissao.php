<?php

    include dirname(__DIR__) . '../inc/includes.php';
    
    session_start();
    
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
    //if (!$eventosComSubmissoesDisponiveis) if (!$eventosComSubmissoesDisponiveis) echo "<script>location.href = 'minhasSubmissoes.php?Submissao=EventosNaoDisponiveis'</script>";
    
    
?>

<script type="text/javascript">
    var idUsersSelected = [];
    var nomeUsersSelected = [];
    //var idUserSubmissor;
</script>

<div class="titulo-modal">Adicionar Submissão</div>

<div class="itens-modal">

<?php  if (!$eventosComSubmissoesDisponiveis) {
            echo "<p align=center><strong>Não há eventos com datas disponíveis para Submissão</strong></p>";
        }
        else {
?>

<form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddSubmissao.php');?>" enctype="multipart/form-data">
    <input type="hidden" id="idUsuariosAdd" name="idUsuariosAdd">
        
        <table class="cadastroItens-2">
            <tr><th></th><td><h2 align="center">Dados do Evento</h2></td></tr>
            <tr>
                <th class="direita">Evento: </th>
                <td>
                    <select class='campoDeEntrada' id="select-Eventos" name="select-Eventos" onchange="loadAreas();loadModalidades()" required="true">
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
                </td>
            </tr>
            <tr>
                <th class="direita">Área: </th>
                <td>
                    <div id="areas"><select class='campoDeEntrada' id="select-Areas" name="select-Areas" required="true"></select></div>
                </td>
            </tr>
            <tr>
                <th class="direita">Modalidade: </th>
                <td>
                    <div id="modalidade"><select class='campoDeEntrada' id="select-Modalidades" name="select-Modalidades" required="true"></select></div>
                </td>
            </tr>
            <tr><th></th><td><h2 align="center">Dados do Trabalho</h2></td></tr>
            <tr>
                <th class='direita'>Título: </th>
                <td><input class="campoDeEntrada" id="titulo" name="titulo" required="true"></td>
            </tr>
            <tr>
                <th class='direita'>Resumo: </th>
                <td><textarea class="campoDeEntrada" id="resumo" name="resumo" rows="10" required="true"></textarea></td>
            </tr>
            <tr>
                <th class='direita'>Palavras-chave: </th>
                <td><input class="campoDeEntrada" id="palavrasChave" name="palavrasChave" required="true"></td>
            </tr>
            <tr>
                <th class='direita'>Relação com: </th>
                <td>
                    <input type="radio" id="relacaoCom" name="relacaoCom" value="TCC">TCC
                    <input type="radio" id="relacaoCom" name="relacaoCom" value="PI">PI
                    <input type="radio" id="relacaoCom" name="relacaoCom" value="-" checked="">Nenhuma das Alternativas
                </td>
            </tr>
            <tr>
                <th class='direita'>Download: </th>
                <td><input class="campoDeEntrada" type="file" id="arquivo" name="arquivo"></td>
            </tr>
            <tr>
                <th class='direita'>Submissores: </th>
                <td>
                    <div style="float: left"><?php echo $usuario->getNome() . "<img src='" . $iconOK. "' class='img-miniatura'>"?></div>
                    <div id='users-selected'></div>
                </td>
            </tr>
            <tr>
                <th class='direita'>Usuários: </th>
                <td>
                    <input class="campoDeEntrada" id="buscaUsers" onkeydown="usuariosSubmissao('buscaUsers','resposta','<?php echo $usuario->getId() ?>')" placeholder="Digite parte do nome do Usuário..." autocomplete="off">
                    <div id="resposta" class="campoDeEntrada" style="display: none;"></div>
                </td>
            </tr>
            
        </table>
        <div class="div-btn"><input type='submit' class='btn-verde' value='Adicionar Submissão' onclick="submeterAutores('<?php echo $usuario->getId()?>')"></div>
    </form>       
</div>

        <?php }?>