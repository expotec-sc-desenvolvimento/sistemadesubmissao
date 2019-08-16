<?php
    include dirname(__DIR__) . '../inc/includes.php';
    
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


<div class="titulo-modal">Adicionar Avaliadores</div>

<div class="itens-modal">

    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddAvaliadores.php');?>">
            <input type="hidden" id="idUsuariosAdd" name="idUsuariosAdd">
            <br>
            <label for="users-selected"><strong>Usuários selecionados: </strong></label><div id='users-selected'></div>
            <br>

            <table class="cadastroItens-2">
                <tr>
                    <td><label for="evento">Selecione o Evento: </label></td>
                    <td>
                        <div id="eventos">
                            <select class="campoDeEntrada" id="select-Eventos" name="select-Eventos" required="true" onchange="loadAreas();">
                                <option value="">Selecione um evento</option>
                                <?php
                                    foreach ($eventos as $evento) {
                                        echo "<option value='".$evento->getId()."'>".$evento->getNome()."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="areas">Selecione a Área: </label></td>
                    <td><div id="areas"><select class="campoDeEntrada" id="select-Areas" name="select-Areas" required="true"><option value=''>Selecione uma Área</option></select></div></td>
                </tr>
                <tr>
                    <td><label for="evento">Selecione os Usuários: </label></td>
                    <td><input class="campoDeEntrada" id="buscaUsers" onkeydown="loadUsers('buscaUsers','resposta')" placeholder="Digite parte do nome do Usuário..." autocomplete="off">
                    <div id="resposta" class="campoDeEntrada" style="display: none;"></div></td>
                </tr>
                
            </table>
            

            <p align="center">  <input class="btn-verde" type='submit' value='Adicionar Avaliadores' onclick="return listaIds()"></p>
                
        </form>
    
    
</div>