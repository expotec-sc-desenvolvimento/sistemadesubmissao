<?php
    
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $modalidade = Modalidade::retornaDadosModalidade($_GET['id']);
    if ($modalidade->getId()=="") header('Location: ./gerenciarModalidades.php');
    
?>




<div class="panel-heading">
    <h3 class="panel-title">Editar Modalidade</h3>
</div>

<div class="panel panel-headline">
    <div class="panel-body">

        <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarModalidade.php');?>" enctype="multipart/form-data">
            <input type="hidden" name="pIdModalidade" value="<?php echo $modalidade->getId() ?>">

            <div class="row">
                <div class="col-md-12  mb-4">
                    <label for="e.address">Área</label> 
                        <input class="form-control" id="inpModalidade" name="pNome" value="<?php echo $modalidade->getDescricao() ?>" required="true">
                    <div class="help-inline ">

                    </div>
                </div>	
            </div>
            <div class="control-group form-actions">
                <div class="row">
                    <div class="col-md-3 mb-4">
                    <button class="btn btn-lg btn-primary btn-block mb-8" type="submit">Atualizar</button>
                    </div>

                    <div class="col-md-3 mb-4">
                        <a class="btn btn-lg btn-default  btn-block" onclick="$('#modal').fadeOut(500)">Retornar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
