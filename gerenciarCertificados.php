<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
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
        <title>SS - Gerenciar Avaliadores</title>
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
        <script type="text/javascript">
            
            function direcionar() {
                var tipo = document.getElementById('select-Tipo').value;
                var usuario = document.getElementById('select-Usuario').value;
                
                var url = 'gerenciarCertificados.php?';
                
                if (tipo!='') url+='tipo='+tipo+"&";
                if (usuario!='') url+='idUsuario='+usuario;    
                
                
                document.location = url;
            }
        </script>

    </head>
    
    <body>
        
        <?php 
            include 'inc/pInicial.php';
            include 'inc/modal.php';
        

            
        ?>
        
        
        <fieldset>
            <h2 align="center">Lista de Certificados</h2>
            <p align="center"><input type="button" class="addObjeto btn btn-sm marginTB-xs btn-success" value="Adicionar Certificado" name='Certificado'></p>
            <!-- <p align="center"><a href="downloads/wsListagemAvaliadores.php">Exportar Planilha Excel</a></p> -->
            <table align="center">
                <tr>
                    <td>
                        <label for="select-Tipo">Tipo: </label>
                        <select class="form-control" style="width: 200px" id="select-Tipo" name="select-Tipo" onchange="direcionar()">
                            <option value="">Selecione um Tipo</option>
                            <option value="Monitoria" <?php if (isset($_GET['tipo']) && $_GET['tipo']=='Monitoria') echo "selected"; ?>>Monitoria</option>
                            <option value="Apresentacao" <?php if (isset($_GET['tipo']) && $_GET['tipo']=='Apresentacao') echo "selected"; ?>>Apresentação</option>
                        </select>
                    </td>
                    <td>
                        <label for="select-Usuario">Usuário: </label>
                        <select class="form-control" style="width: 200px" id="select-Usuario" name="select-Usuario" onchange="direcionar()">
                            <option value="">Selecione um Usuario</option>
                            <?php
                                foreach (UsuarioPedrina::listaUsuarios('', '', '') as $user) {
                                    echo "<option value='".$user->getId()."'";
                                    if (isset($_GET['idUsuario']) && $_GET['idUsuario'] == $user->getId()) echo " selected";
                                    echo ">" . $user->getNome() . "</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            
            <br><br>
            <table class='table table-striped table-bordered dt-responsive nowrap' align='center' border='1'>
                <thead>
                    <tr>
                        <th style="text-align: center">*</th>
                        <th style="text-align: center">Tipo</th>
                        <th style="text-align: center">Usuário</th>
                        
                    </tr>
                </thead>
                <tbody>
            <?php // CONTINUAR DAQUI 
                    
                    $tipo = '';
                    $idUsuario = '';
                    
                    if (isset($_GET['tipo'])) $tipo = $_GET['tipo'];
                    if (isset($_GET['idUsuario'])) $idUsuario = $_GET['idUsuario'];

                    $listaCertificados = Certificado::listaCertificadosComFiltro($tipo, $idUsuario);
                    
                    if (count($listaCertificados)==0) echo "<tr><td colspan='3' align='center'><strong>Nenhum certificado encontrado!</strong></td></tr>";
                    else {

                        foreach($listaCertificados as $certificado) { // Puxa a lista de Eventos

                            $arquivo = "<a href='".$pastaCertificados .  $certificado->getArquivo()."' target='blank'><i class='fa fa-file'></i>  </a>";
                            $excluir = "<a href='submissaoForms/wsExcluirCertificado.php?id=".$certificado->getId()."' onclick=\"return confirm('Tem certeza que deseja excluir o certificado?')\"><i class='fa fa-trash m-right-xs'></i></a>";

                            $user = UsuarioPedrina::retornaDadosUsuario($certificado->getIdUsuario());
                        ?>    

                            <tr>
                                <td align="center" style="vertical-align: middle;"><?php echo $arquivo . $excluir; ?></td>
                                <td align="center"><?php echo $certificado->getTipoCertificado() ?></td>
                                <td><?php echo $user->getNome() ?></td>
                            </tr>            
                        <?php }
                    
                    }?>
                </tbody>
            </table><br>
            
                        
            
        </fieldset>
        <?php 
            include 'inc/pFinal.php';
        ?>
    </body>
    
</html>
