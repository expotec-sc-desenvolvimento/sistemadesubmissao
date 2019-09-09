<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    
    $eventos = array (new Evento());
    $eventos = Evento::listaEventos();
        
?>
   
   <script type="text/javascript">
        var idUsersSelected = [];
        var nomeUsersSelected = [];
        //var idUserSubmissor;
    </script>




<div class="panel-heading">
    <h3 class="panel-title">Adicionar Avaliadores</h3>
</div>

<div class="panel-body">
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddAvaliadores.php');?>">
    <input type="hidden" id="idUsuariosAdd" name="idUsuariosAdd">
    <div class="row">
        <div class="col-md-6 mb-6">
            <label class="control-label">Evento</label>
            <select class="form-control" id="select-Eventos" name="select-Eventos" required="true" onchange="loadAreas();">
                <option value="">Selecione um evento</option>
                <?php
                    foreach ($eventos as $evento) {
                        echo "<option value='".$evento->getId()."'>".$evento->getNome()."</option>";
                    }
                ?>
            </select>
            <div class="help-inline ">

            </div>
        </div>
        <div class="col-md-6 mb-6">
            <label class="control-label">Área</label>
            <select class="form-control" id="select-Areas" name="select-Areas" required="true"><option value=''>Selecione uma Área</option></select>
            <div class="help-inline ">

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12  mb-4">
            <label for="e.address">Usuários Selecionados</label><br>
                <div style="float: left"></div>
                <div id='users-selected'></div>
            <div class="help-inline ">

            </div>
        </div>
    </div>
    <div class="row">	
        <div class="col-md-12  mb-4">
            <input class="form-control" id="buscaUsers" onkeydown="loadUsers('buscaUsers','resposta')" placeholder="Digite parte do nome do Usuário..." autocomplete="off">
                <div id="resposta"  style="left: 51px; width: 879px; top: 401.6px; bottom: auto;display: none;"></div>
            <div class="help-inline ">

            </div>
        </div>
    </div>
    <div class="control-group form-actions">
        <div class="row">
            <div class="col-md-3 mb-4">
            <button class="btn btn-lg btn-primary btn-block mb-15" type="submit" onclick="return listaIds()">Adicionar</button>
            </div>

            <div class="col-md-3 mb-4">
                <a class="btn btn-lg btn-default  btn-block" onclick="$('#modal').fadeOut(500)">Retornar</a>
            </div>
        </div>
    </div>
    </form>
</div>
    
