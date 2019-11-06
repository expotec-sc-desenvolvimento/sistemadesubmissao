<?php

include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
    
    $areaAvento = AreaEvento::retornaDadosAreaEvento($_GET['id']);
    $avaliadores = Avaliador::listaAvaliadoresComFiltro($areaAvento->getIdEvento(), $areaAvento->getIdArea(), '', '');
    
    $nomeEvento = Evento::retornaDadosEvento($areaAvento->getIdEvento())->getNome();
    $nomeArea = Area::retornaDadosArea($areaAvento->getIdArea())->getDescricao();
            
?>

<div class="titulo-modal">Avaliadores</div>

<div class="itens-modal">
    <table class='table table-striped table-bordered dt-responsive nowrap'>
        <tr><td><strong>Evento: </strong></td><td><?php echo $nomeEvento ?></td></tr>
        <tr><td><strong>Area: </strong></td><td><?php echo $nomeArea ?></td></tr>
        <tr><td><strong>Avaliadores: </strong></td><td>
            <?php foreach (Avaliador::listaAvaliadoresComFiltro($areaAvento->getIdEvento(), $areaAvento->getIdArea(), '', "area") as $avaliador) {
                echo "<i>" . UsuarioPedrina::retornaDadosUsuario($avaliador->getIdUsuario())->getNome() . "</i><br> ";
            }
    ?>
          </td> 
    </table>
</div>
