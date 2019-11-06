<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new UsuarioPedrina();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página


    $listaEventosDaArea = AreaEvento::listaAreaEventoComFiltro($_GET['id'], '');
    $listaAvaliadoresDaArea = Avaliador::listaAvaliadoresComFiltro('', $_GET['id'], '', 'area');
     
      
      
      $pendencias = count($listaEventosDaArea)+ count($listaAvaliadoresDaArea);
      
      $nome = Area::retornaDadosArea($_GET['id'])->getDescricao()
?>

<div class="titulo-modal">Excluir Área</div>

<div class="itens-modal">
    
    <?php if ($pendencias==0) {?>
        <p align='center'>Deseja realmente excluir a Área <strong><?php echo $nome  ?>?</strong></p>
        <div class="div-btn">
            <input type='button' value='Sim' class='btn btn-sm marginTB-xs btn-success' onclick="location.href='submissaoForms/wsExcluirArea.php?id=<?php echo $_GET['id']?>'">
            &nbsp;&nbsp;<input type='button' value='Não' class='btn btn-sm marginTB-xs btn-danger' onclick="$('#modal').fadeOut(500)">
        </div>
    <?php }
    
    else {?>
        <p align='center'>A área <strong><?php echo $nome ?></strong> não pode ser excluída devido às pendências abaixo:</p>
        <?php 
            if (count($listaEventosDaArea)>0) {
                echo "<p align='center'><strong>Eventos desta Área (".count($listaEventosDaArea).")</strong></p>";
                echo "<ul style='margin-left: 30px;'>";
                foreach ($listaEventosDaArea as $obj) {
                    echo "<li>";
                    echo "<strong>Evento: </strong>" . Evento::retornaDadosEvento($obj->getIdEvento())->getNome();
                    echo "</li>";
                }
                echo "</ul>";
            }
            if (count($listaAvaliadoresDaArea)>0) {
                echo "<p align='center'><strong>Avaliadores desta Área (".count($listaAvaliadoresDaArea).")</strong></p>";
                echo "<ul style='margin-left: 30px;'>";
                foreach ($listaAvaliadoresDaArea as $obj) {
                    $user = UsuarioPedrina::retornaDadosUsuario($obj->getIdUsuario());
                    echo "<li>";
                    echo "<strong>Avaliador: </strong>" . $user->getNome() . " " . $user->getSobrenome();
                    echo "</li>";
                }
                echo "</ul>";
            }
    ?>
        
    <?php }?>
    
</div>
