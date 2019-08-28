<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
 //   verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
        
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Meus Certificados</title>
        <?php
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
    </head>
    
    <body>
        
        <?php 
            include 'inc/menuInicial.php';
            include 'inc/modal.php';
            $certificados = Certificado::listaCertificadosComFiltro('', $usuario->getId(),'');
        ?>

        <fieldset>
            <h2 align="center">Meus Certificados</h2>
            
            <?php if (count($certificados)==0) echo "<p align='center'>Você ainda não possui certificados disponíveis!</p>"; 
            else {
                $apresentacaoDeTrabalho = Certificado::listaCertificadosComFiltro('', $usuario->getId(),1);
            ?>
            
            <table border="1" align="center" class='table_list'>
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Arquivo</th>
                    </tr>
                </thead>
                <tbody>
                
                <?php

                    foreach ($apresentacaoDeTrabalho as $apresentacao) { ?>
                        <tr>
                            <td><?php echo Evento::retornaDadosEvento($apresentacao->getIdEvento())->getNome()?></td>
                            <td><a href='<?php echo $pastaCertificados . $apresentacao->getArquivo() ?>'>Visualizar</a></td>
                        </tr>
                    <?php }
                }  
                ?>
                </tbody>
            </table>
        </fieldset>
    </body>
</html>