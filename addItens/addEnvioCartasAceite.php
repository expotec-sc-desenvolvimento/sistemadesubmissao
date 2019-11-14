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
<script type="text/javascript">
    function marcarTodos() {
        if (document.getElementById('marcarTodas').checked == true) {
            var itens = document.getElementsByName('cartaAceite[]');
            var i = 0;
            for(i=0; i<itens.length;i++){
                itens[i].checked = true;
            }

        }
        else {

            var itens = document.getElementsByName('cartaAceite[]');
            var i = 0;
            for(i=0; i<itens.length;i++){
                itens[i].checked = false;
            }
        }
    }
</script>

<div class="panel-heading">
    <h3 class="panel-title">Enviar Cartas de Aceite</h3>
</div>

<div class="panel-body">
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEnviarCartasAceite.php');?>" onsubmit="return confirm('Deseja enviar as Cartas de Aceite para os autores das submissões selecionadas?')">
    
    
    <div class="row">	
        <div class="col-md-12  mb-4">
            <table class='table table-striped table-bordered dt-responsive' align='center' border='1' style='width: 70%;'>
                <thead>
                    <th style='text-align: center' width='40px'><input type='checkbox' id='marcarTodas' name='marcarTodas' onclick="marcarTodos()"></th>
                    <th style='text-align: center'>Trabalho</th>
                    <th style='text-align: center'>Autores</th>
                </thead>
                <tbody>
                    <?php
                        $listaSubmissoes = Submissao::listaSubmissoesComFiltro('', '', '', '', 3);
                        if (count($listaSubmissoes)==0) echo "<tr><td style='text-align: center' colspan='3'>Nenhuma submissão final encontrada</td>";
                        else {
                            foreach ($listaSubmissoes as $submissao) {
                                echo "<tr><td style='text-align: center; vertical-align: middle;'><input type='checkbox' id='cartaAceite[]' name='cartaAceite[]' value='". $submissao->getId() ."'></td>";
                                echo "<td style='text-align: center; vertical-align: middle;'>".$submissao->getTitulo()."</td>";
                                echo "<td><ul style='list-style-type: none;'>";
                                
                                foreach (UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '', '','') as $userSubmissao) {
                                    if ($userSubmissao->getEnvioEmailCartaAceite()==1) {
                                        echo "<li><img class='img-miniatura' src='".$iconOK."' title='Carta Enviada'>".UsuarioPedrina::retornaDadosUsuario($userSubmissao->getIdUsuario())->getNome();
                                    }
                                    else echo "<li><img class='img-miniatura' src='".$iconOKRessalvas."' title='Carta Pendente'>".UsuarioPedrina::retornaDadosUsuario($userSubmissao->getIdUsuario())->getNome();
                                }
                                echo "</ul></td>";
                            }
                        }
                    ?>
                </tbody>
            </table>
            <div class="help-inline ">

            </div>
        </div>
    </div>
    

    <div class="control-group form-actions">
        <div class="row">
            <div class="col-md-3 mb-4">
            <button class="btn btn-lg btn-primary btn-block mb-15" type="submit">Enviar Cartas de Aceite</button>
            </div>

            <div class="col-md-3 mb-4">
                <a class="btn btn-lg btn-default  btn-block" onclick="$('#modal').fadeOut(500)">Retornar</a>
            </div>
        </div>
    </div>
    </form>
</div>
    
