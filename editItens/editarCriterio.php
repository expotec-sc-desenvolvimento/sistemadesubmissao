<?php
    include dirname(__DIR__) . '../inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $criterio = Criterio::retornaDadosCriterio($_GET['id']);
    if ($criterio->getId()=="") header('Location: paginaInicial.php');
?>

<div class="titulo-modal">Editar Critério</div>


<div class="itens-modal">
    
    
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarCriterio.php');?>" enctype="multipart/form-data">
                
        <input type="hidden" name="pIdCriterio" value="<?php echo $criterio->getId() ?>">
        
        <table class="cadastroItens-2">
            <tr><td><strong>Modalidade:</td><td><?php echo Modalidade::retornaDadosModalidade($criterio->getIdModalidade())->getDescricao()?></td></tr>
            <tr><td><strong>Tipo de Critério:</strong></td><td><?php echo TipoSubmissao::retornaDadosTipoSubmissao($criterio->getIdTipoSubmissao())->getDescricao()?></td></tr>
            <tr>
                <td class='direita'><strong>Descrição:</strong></td>
                <td><input class="campoDeEntrada" id="inpDescricao" name="pDescricao" required="true" value="<?php echo $criterio->getDescricao()?>"></td>
                <td><div id="msgDescricao" class="msgerr"></div></td>
            </tr>
            <tr>
                <td class='direita'><strong>Detalhamento: </strong></td>
                <td><textarea class="campoDeEntrada" id="inpDescricao" name="pDetalhamento" cols="60" rows="5" required="true" style="resize: none;"><?php echo $criterio->getDetalhamento()?></textarea></td>
                <td><div id="msgDescricao" class="msgerr"></div></td>
            </tr>
            <tr>
                <?php if ($criterio->getDescricao()=="Final") {?>
                <td class='direita'><strong>Peso: </strong></td>
                <td><select class="campoDeEntrada" id='inpPeso' name="pPeso">
                        <option value="1" <?php if ($criterio->getPeso()==1) echo " selected"?>>1</option>
                        <option value="2" <?php if ($criterio->getPeso()==2) echo " selected"?>>2</option>
                        <option value="3" <?php if ($criterio->getPeso()==3) echo " selected"?>>3</option>
                        <option value="4" <?php if ($criterio->getPeso()==4) echo " selected"?>>4</option>
                        <option value="5" <?php if ($criterio->getPeso()==5) echo " selected"?>>5</option>
                    </select></td>
                <?php } else echo "<input type='hidden' id='inpPeso' name='pPeso' value=''>;"?>
            </tr>

        </table>
        
        <div class="div-btn"><input class="btn-verde" type="submit" value="Atualizar Criterio"></div>

    </form>
    
    </div>



    

    