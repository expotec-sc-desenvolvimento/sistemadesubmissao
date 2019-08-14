<?php
    include dirname(__DIR__) . '../inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
        
?>

<div class="titulo-modal">Adicionar Evento</div>


<div class="itens-modal">
    
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddEvento.php');?>" enctype="multipart/form-data">
        
        <table class="cadastroItens-2">
            <tr>
                <td class='direita'><label for="inpNomeEvento">Nome do Evento: </label></td>
                <td><input class="campoDeEntrada" id="inpNomeEvento" name="pNomeEvento" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpDescricao">Descrição: </label></td>
                <td><textarea class="campoDeEntrada" rows="10" cols="40" id="inpDescricaoEvento" name="pDescricaoEvento" required="true"></textarea></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpInicioSubmissao">Início da Submissão: </label></td>
                <td><input class="campoDeEntrada" type="date" id="inpInicioSubmissao" name="pInicioSubmissao" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="inpLocal">Fim da Submissão: </label></td>
                <td><input class="campoDeEntrada" type="date" id="inpFimSubmissao" name="pFimSubmissao" required="true"></td>
            </tr>
            <tr>
                <td class='direita'><label for="mediaAprovacaoTrabalhos">Média</label></td>
                <td>
                    <select class="campoDeEntrada" id="mediaAprovacaoTrabalhos" name="mediaAprovacaoTrabalhos" required="true">
                        <option value="">Selecione um valor</option>
                        <option value="60">60</option>
                        <option value="70">70</option>
                        <option value="80">80</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td class='direita'><label for="inpImagem">Logo: </label></td>
                <td><input class="campoDeEntrada" type="file" id="inpImagem" name="pImagem" required="true"></td>
            </tr>
        </table>
        <div class="div-btn"><input class="btn-verde" type="submit" value="Adicionar Evento"></div>
        
    </form>
    
    </div>
