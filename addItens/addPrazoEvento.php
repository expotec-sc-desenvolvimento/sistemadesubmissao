<?php
    include dirname(__DIR__) . '../inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
?>

<div class="titulo-modal">Adicionar Prazo para o Evento</div>

<div class="itens-modal">
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddPrazoEvento.php');?>" enctype="multipart/form-data">
        <input type="hidden" id="evento" name="evento" value="<?php echo $_GET['id'] ?>">
        <table class="cadastroItens-2">
            <tr>
                <th>Tipo de Prazo: </th>
                <td>
                    <select class="campoDeEntrada" id="tipoPrazo" name="tipoPrazo" required="true">
                        <option value="">Escolha um tipo de Prazo</option>
                        <?php
                            foreach (TipoPrazo::listaTipoPrazo() as $tipoPrazo) { 
                                if (count(PrazosEvento::listaPrazosEventoComFiltro($_GET['id'], $tipoPrazo->getId()))==0) {?>
                                    <option value="<?php echo $tipoPrazo->getId()?>"><?php echo $tipoPrazo->getDescricao() . " - " . $tipoPrazo->getDetalhamento(); ?></option>
                                <?php }
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Prazo (em dias): </th>
                <td>
                    <input class="campoDeEntrada" type="number" id="prazo" name="prazo" required="true" style="width: 60px;">
                </td>
            </tr>
        </table>
        <div class="div-btn">
            <input type='submit' value='Sim' class='btn-verde' type="submit">
            <input type='button' value='Não' class='btn-vermelho' onclick="$('#modal').fadeOut(500)">
        </div>
    </form>
</div>