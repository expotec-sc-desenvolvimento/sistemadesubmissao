<?php

    include dirname(__FILE__) . './inc/includes.php';
    
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
        <title>SS - Downloads</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>


    </head>
    
    <body>
        
        <?php include './inc/menuInicial.php';?>
        
        <?php
            $listaDownloads[] = new Download();
            $listaDownloads = Download::listaDownloads();
            
            
        ?>
        <br><br>
            <h3 align='center'>Listagem de Downloads do Sistema</h3>

            <p align='center'><input class="botaoConfirmar" type="button" value="Adicionar Download" onclick="location.href='addDownload.php'"></p>
            
            <p align='center'><strong>Total de Downloads cadastrados no sistema: </strong> <?php echo count($listaDownloads) ?></p>
                <br>
                
        <table border="1">
            <tr>
                <td colspan="6">Lista de Eventos Cadastrados</td>
            </tr>
            
            <tr>
                <td>Evento</td>
                <td>Nome</td>
                <td>Descricao</td>
                <td>Visualizar</td>
                <td>*</td>
                <td>*</td>
            </tr>
            <?php for ($i=0;$i<count($listaDownloads);$i++) { 
                $evento = new Evento();
                $evento = Evento::retornaDadosEvento($listaDownloads[$i]->getIdEvento()); ?>
                
            <tr>
                <td><?php echo $evento->getNome() ?></td>
                <td><?php echo $listaDownloads[$i]->getNome() ?></td>
                <td><?php echo $listaDownloads[$i]->getDescricao() ?></td>
                <td><a href="<?php echo $pastaDownloads . $listaDownloads[$i]->getArquivo()?>"> 
                        Visualizar
                    </a>
                </td>
                <td><a href=""> 
                        <img src="<?php echo $iconEditar?>" class="img-miniatura">
                    </a>
                </td>
                <td><a href="submissaoForms/wsExcluirDownload.php?idDownload=<?php echo $listaDownloads[$i]->getId() ?>" onclick="return confirm('Deseja realmente excluir esse arquivo?')"> 
                        <img src="<?php echo $iconExcluir?>" class="img-miniatura">
                    </a>
                </td>
                    
            </tr>
            <?php }?>
        </table>
    </body>
</html>
