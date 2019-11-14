<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    
    $eventos = array (new Evento());
    $eventos = Evento::listaEventos();
        
?>

<script>
    
    $(document).on('click', '.table', function(){
        $(this).tablesorter();
     });
</script>

<div class="panel-heading">
    <h3 class="panel-title">Adicionar Certificados</h3>
</div>

<div class="panel-body">
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsGerarCertificados.php');?>" onsubmit="return confirm('Deseja gerar os Certificados para os usuários selecionados?')">
    <input type="hidden" id="tipoCertificado" name="tipoCertificado">
    <table align="center">     
        <tr>
            <td>
                <label for="select-Usuario">Tipo de Certificado: </label>
                <select class="form-control" id="select-Tipo" name="select-Tipo" required="true" onchange="document.getElementById('tipoCertificado').value = this.value; loadUsuariosAptos(this.value,'resposta')">
                    <option value="">Selecione um Tipo de Certificado</option>
                    <option value="Monitoria">Monitoria</option>
                    <option value="Apresentacao">Apresentação de Trabalho</option>
                </select>
            </td>
        </tr>
    </table>
    
    
    <div class="row">	
        <div class="col-md-12  mb-4">
            <div id="resposta" name="resposta" align="center">
                
            </div>
            <div class="help-inline ">

            </div>
        </div>
    </div>
    <div class="control-group form-actions">
        <div class="row">
            <div class="col-md-3 mb-4">
            <button class="btn btn-lg btn-primary btn-block mb-15" type="submit">Gerar Certificados</button>
            </div>

            <div class="col-md-3 mb-4">
                <a class="btn btn-lg btn-default  btn-block" onclick="$('#modal').fadeOut(500)">Retornar</a>
            </div>
        </div>
    </div>
    </form>
</div>
    
