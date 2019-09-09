<?php
    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $evento = Evento::retornaDadosEvento($_GET['id']);
    
    
?>
<div class="titulo-modal">Vincular Modalidade ao Evento <?php echo $evento->getNome() ?></div>

<div class="itens-modal">

        <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddModalidadesEvento.php');?>">
            <input type="hidden" name="idEvento" value="<?php echo $evento->getId() ?>">
            <table class="cadastroItens">
                <tr><td>
                <?php
                    $modalidades = Modalidade::listaModalidades();

                    $flag = "<p align='center'><strong>Todas as modalidades possíveis já foram vinculadas ou não existem modalidades!</strong></p>";
                    echo "<ul class='listaCriterios'>";
                    
                    foreach ($modalidades as $modalidade) {
                        if (count(ModalidadeEvento::listaModalidadeEventoComFiltro($modalidade->getId(), $evento->getId()))==0) {
                            $flag = "";
                            echo "<li><input type='checkbox' name='modalidades[]' value='". $modalidade->getId() ."'>" . $modalidade->getDescricao()."</li>";
                        }
                    }
                    echo "</ul>";
                    
                ?>
                </td></tr>
            </table>
            
            <?php if ($flag=="") { ?>
                <div class="div-btn"><input class="btn btn-sm marginTB-xs btn-success" type="submit" value="Vincular Modalidades"></div>
            <?php } else echo $flag; ?>

        </form>
</div>