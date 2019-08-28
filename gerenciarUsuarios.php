<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"./paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    
            
?>
    <!DOCTYPE html>
    <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="author" content="José Sueney de Lima">
            <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
            <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>SS - Listagem de Usuários</title>
            <?php
                include 'inc/css.php';
                include 'inc/javascript.php';
            ?>
            <script>
            $(document).ready(function (e){
                $(function(){
                    $('.table_list').tablesorter();
                });
                $('.editarObjeto').click(function (){
                   $('#modal').fadeIn(500);
                   var x = $(this).attr('id');
                   $('.modal-box-conteudo').load("editItens/editarUsuario.php?id="+x);
                });
                
                $('.addObjeto').click(function (){
                   $('#modal').fadeIn(500);
                   $('.modal-box-conteudo').load("addItens/addUsuario.php");
                });
                $('.excluirObjeto').click(function (){
                   $('#modal').fadeIn(500);
                   var x = $(this).attr('id');
                   $('.modal-box-conteudo').load("excluirItens/excluirUsuario.php?id="+x);
                });
                
                $('.fechar,#modal').click(function (event){
                    if (event.target !== this) return;
                    $('#modal').fadeOut(500);
                });
               
                $(document).keyup(function(e) { 
                    if (e.keyCode === 27) 
                        $('#modal').fadeOut(300);
                });
            });
        </script>
            
        </head>

        <body>

            <?php 
                require_once './inc/menuInicial.php';
                require_once './inc/modal.php';
            ?>


            <?php 
                
                $filtroNome="";
                $filtroTipoUsuario=-1;
                $filtroPerfil=-1;
                
                if (isset($_GET['nome'])) $filtroNome = $_GET['nome'];
                if (isset($_GET['tipoUsuario'])) $filtroTipoUsuario = $_GET['tipoUsuario'];
                if (isset($_GET['pPerfil'])) $filtroPerfil = $_GET['pPerfil'];

                $listaUsuarios = Usuario::listaUsuarios($filtroNome,$filtroTipoUsuario,$filtroPerfil);                
                $listaPerfis = Perfil::listaPerfis();
            ?>
            <br><br>
            <h3 align='center'>Listagem de Usuários: <?php echo count ($listaUsuarios)?></h3>
            <p align="center"><input type="button" class="addObjeto btn-verde" name="Usuario" value="Adicionar Usuário"></p>
            
            <div class="users">
            
                <br>

                <form method="get" action="<?=htmlspecialchars('gerenciarUsuarios.php');?>">
                    <p align='center'>
                        Buscar por nome: <input class="input" type="text" id="nome" name="nome" value='<?php if (isset($_GET['nome'])) echo $_GET['nome']?>'> 
                        Tipo Usuário:   <select name="tipoUsuario" id="tipoUsuario">
                                            <option value='-1'>Selecione um Tipo</option>
                                            <?php
                                            foreach (TipoUsuario::listaTipoUsuarios() as $tipoUsuario) {

                                                $option = "<option value='" . $tipoUsuario->getId() . "'";
                                                if (isset($_GET['tipoUsuario']) && $_GET['tipoUsuario']==$tipoUsuario->getId()) $option = $option . " selected";
                                                $option = $option . ">" . $tipoUsuario->getDescricao() . "</option>";
                                                echo $option;
                                            }
                                        ?>
                                        </select>
                        Perfil: <select name="pPerfil" id="inpPerfil">
                                    <option value='-1'>Selecione um Perfil</option>>
                                    <?php

                                        foreach ($listaPerfis as $perfil) {

                                            $option = "<option value='" . $perfil->getId() . "' ";
                                            if (isset($_GET['pPerfil']) && $_GET['pPerfil']==$perfil->getId()) $option = $option . " selected";
                                            $option = $option . ">" . $perfil->getDescricao() . "</option>";
                                            echo $option;
                                        }
                                    ?>
                            </select>
                        <input class="botaoConfirmar" type="submit" value="Buscar Usuário"></p>

                </form>
                <br>
                <table class='table_list' border='1' align="center">
                    <thead>
                    <tr>
                        <th>*</th>
                        <th>Imagem</th>
                        <th>Nome Completo</th>
                        <th>CPF</th>
                        <th>Perfil</th>
                        <th>Tipo de Usuário</th>
                    </tr>
                    </thead>
                    <?php foreach ($listaUsuarios as $user) { ?>
                            
                            <tr><td>
                                    <a class='editarObjeto' id='<?php echo $user->getId() ?>'><img class="img-miniatura" src='<?php echo $iconEditar?>'></a>
            <?php if ($user->getId()!=$usuario->getId()) {?>    <a class='excluirObjeto' id='<?php echo $user->getId() ?>'><img class ='img-miniatura' width='30px' src='<?php echo $iconExcluir ?>'></a> <?php }?>
                                </td>
                                <td><img id ='fotoMiniatura' src='<?php echo $pastaFotosPerfil . $user->getImagem()?>' width=50px></img></td>
                                <td><?php echo $user->getNome() ." " . $user->getSobrenome() ?> </td>
                                <td><?php echo $user->getCpf() ?></td>
                                <td><?php echo Perfil::retornaDadosPerfil($user->getIdPerfil())->getDescricao() ?></td>
                                <td><?php echo TipoUsuario::retornaDadosTipoUsuario($user->getIdTipoUsuario())->getDescricao() ?></td>
                                
                      <?php  }
                     
                    ?>
                </table>

            </div>
            <div id="modal">
                <div class="modal-box-maior">
                    <div class="modal-box-conteudo">

                    </div>
                    <div class="fechar">X</div>
                </div>
            </div>
        </body>
    </html>
