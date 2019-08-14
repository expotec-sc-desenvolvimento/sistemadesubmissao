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
        
        function gerarLista(icon) {

            // Existe a variavel global 'idUsersSelected' e 'nomesUsers', que guarda o nome dos usuários, que guardam os ids e nomes dos usuarios escolhidos, respectivamente
            var nomesUsers = "";
            //var idUsers = "";
            
            for (var i=0;i<idUsersSelected.length;i++) {
                var inserir = nomeUsersSelected[i]+"<a onclick=\"retirarNome('"+idUsersSelected[i]+"','"+icon+"')\"><img src='"+icon+"' class='img-miniatura' style='cursor:pointer;'></a>";

                nomesUsers = nomesUsers + inserir + " ";

            }
            //echo(nomesUsers);
            
            document.getElementById("users-selected").innerHTML = nomesUsers;

        }
        function adicionarId(id,nome,iconExcluir) {

            if (idUsersSelected.indexOf(id)!=-1) alert('Usuário já adicionado');
            else {
                idUsersSelected.push(id);
                nomeUsersSelected.push(nome)   
                gerarLista(iconExcluir);
            }
        }


        function retirarNome(id,iconExcluir) {

            var index = idUsersSelected.indexOf(id);

            if (index>-1) {

                 nomeUsersSelected.splice(index, 1);
                 idUsersSelected.splice(index, 1);
                 gerarLista(iconExcluir);

            }
        }

        function listaIds() {

            if (idUsersSelected.length<=0) {
                alert("Nenhum Usuario selecionado!")
                return false;
            }
            else {        
                var ids = "";
                for (var i=0;i<idUsersSelected.length;i++) ids = ids + idUsersSelected[i] + ";";
                document.getElementById('idUsuariosAdd').value = ids;
                return true;

            }
        }
    </script>
    <script>
               
        $(document).ready(function (e){
            
            $('.select-Eventos').change(function (){
               $.ajax({
                url: './reqAjax/wsAreasAjax.php?evento='+$(this).val(),
                success: function(data) {
                    $('.select-Areas').html(data);
                }
              });
            });
            $('.buscaUsers').keydown(function (){
               if (parseInt($(this).val().length)>=3) {
                    $.ajax({
                    url: './reqAjax/wsUsuariosAjax.php?nome='+$(this).val(),
                    success: function(data) {
                        $('.resposta').html(data);
                    }
                  });
              }
              else $('.resposta').html("Digite ao menos 4 letras");
            });
            

        });

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
                            <select class="select-Eventos campoDeEntrada" id="select-Eventos" name="select-Eventos" required="true">
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
                    <td><div id="areas"><select class="select-Areas campoDeEntrada" id="select-Areas" name="select-Areas" required="true"></select></div></td>
                </tr>
                <tr>
                    <td><label for="evento">Selecione os Usuários: </label></td>
                    <td><input type="text" class="buscaUsers campoDeEntrada" id="buscaUsers" autocomplete="off"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><div class="resposta" id="resposta"></div></td>
                </tr>
            </table>
            

            <p align="center">  <input class="addObjeto" type='submit' value='Adicionar Avaliadores' onclick="return listaIds()"></p>
                
        </form>
    
    
</div>