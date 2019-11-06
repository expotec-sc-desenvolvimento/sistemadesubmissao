<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
        
?>


<div class="panel-heading">
    <h3 class="panel-title">Adicionar Evento</h3>
</div>

<div class="panel-body">
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddEvento.php');?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Nome do Evento</label> 
                    <input class="form-control" id="inpNomeEvento" name="pNomeEvento" required="true">
                <div class="help-inline ">

                </div>
            </div>	
        </div>
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="resumo">Descrição</label> 
                <textarea id="inpDescricaoEvento" name="pDescricaoEvento" rows="5" class="form-control"  style="resize:none" required="true"></textarea>
                <div class="help-inline ">

                </div>
            </div>	
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <label for="e.contact">Início da Submissão</label>
                <div class="input-group">
                    <input class="form-control" type="date" id="inpInicioSubmissao" name="pInicioSubmissao" required="true"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                <div class="help-inline ">
                    
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <label for="e.contact">Fim da Submissão</label>
                <div class="input-group">
                    <input class="form-control" type="date" id="inpFimSubmissao" name="pFimSubmissao" required="true"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                <div class="help-inline ">
                    
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <label for="e.contact">Inscrição de Avaliadores</label>
                <div class="input-group">
                    <input class="form-control" type="date" id="prazoInscricaoAvaliadores" name="prazoInscricaoAvaliadores" required="true"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                <div class="help-inline ">
                    Data Final para inscrição de Avaliadores
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <label for="e.contact">Envio de Avaliações Parciais</label>
                <div class="input-group">
                    <input class="form-control" type="date" id="prazoFinalEnvioAvaliacaoParcial" name="prazoFinalEnvioAvaliacaoParcial" required="true"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                <div class="help-inline ">
                    Avaliações Iniciais da Submissão
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <label for="e.contact">Envio de Avaliações Corrigidas</label>
                <div class="input-group">
                    <input class="form-control" type="date" id="prazoFinalEnvioAvaliacaoCorrigida" name="prazoFinalEnvioAvaliacaoCorrigida" required="true"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                <div class="help-inline ">
                    Avaliações de ressubmissões
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <label for="e.contact">Envio de Avaliações Finais</label>
                <div class="input-group">
                    <input class="form-control" type="date" id="prazoFinalEnvioAvaliacaoFinal" name="prazoFinalEnvioAvaliacaoFinal" required="true"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                <div class="help-inline ">
                    Avaliação da Apresentação no Evento
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Envio de Submissões Corrigidas</label> 
                <div class="input-group">
                    <input class="form-control" type="date" id="prazoFinalEnvioSubmissaoCorrigida" name="prazoFinalEnvioSubmissaoCorrigida" required="true"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                <div class="help-inline ">
                    Prazo para envio da Ressubmissão
                </div>
            </div>	
        </div>
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Logo do Evento</label> 
                    <input class="form-control" type="file" id="inpImagem" name="pImagem" required="true">
                <div class="help-inline ">
                    
                </div>
            </div>	
        </div>
        <div class="row">
            <div class="col-md-12  mb-4">
                <label for="e.address">Distribuição automática de Avaliadores</label> 
                    <select class='form-control' id='distribuicaoAutomaticaAvaliadores' name='distribuicaoAutomaticaAvaliadores' onchange="if (this.value==1) alert('Ao ativar essa opção, os trabalhos submetidos a partir de agora serão distribuidos automaticamente!')">
                        <option value='1'>Ativado</option>
                        <option value='0' selected>Desativado</option>
                    </select>
                <div class="help-inline ">
                    
                </div>
            </div>	
        </div>
        <div class="control-group form-actions">
            <div class="row">
                <div class="col-md-3 mb-4">
                <button class="btn btn-lg btn-primary btn-block mb-4" type="submit">Adicionar Evento</button>
                </div>

                <div class="col-md-3 mb-4">
                    <a class="btn btn-lg btn-default  btn-block" href="minhasSubmissoes.php">Retornar</a>
                </div>
            </div>
        </div>
    </form>
</div>