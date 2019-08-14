<?php
    include dirname(__DIR__) . '../inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
    if ($submissao->getId()=="") header('Location: ../paginaInicial.php');
    
    // Caso o usuário não seja administrador e não seja usuário da submissão
    if (count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), $usuario->getId(), ''))==0 
            && Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao()!="Administrador") header('Location: ./paginaInicial.php');
    
    $tipoSubmissao = TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao();
    $titulo = $submissao->getTitulo();
    $area = Area::retornaDadosArea($submissao->getIdArea())->getDescricao();
    $modalidade = Modalidade::retornaDadosModalidade($submissao->getIdModalidade())->getDescricao();
    $palavrasChave = $submissao->getPalavrasChave();
    $situacao = SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao())->getDescricao();
?>

<div class="titulo-modal">Visualizar Submissão</div>

<div class="itens-modal">
    <table class='cadastroItens-2'>
        <tr><th class='direita'>Tipo: </th><td><input class='campoDeEntrada' readonly="true" value="<?php echo $tipoSubmissao ?>"></td></tr>
        <tr><th class='direita'>Título: </th><td><input class='campoDeEntrada' readonly="true" value="<?php echo $titulo ?>"></td></tr>
        <tr><th class='direita'>Área: </th><td><input class='campoDeEntrada' readonly="true" value="<?php echo $area ?>"></td></tr>
        <tr><th class='direita'>Modalidade: </th><td><input class='campoDeEntrada' readonly="true" value="<?php echo $modalidade ?>"></td></tr>
        <tr><th class='direita'>Palavras chave: </th><td><input class='campoDeEntrada' readonly="true" value="<?php echo $palavrasChave ?>"></td></tr>
        <tr><th class='direita'>Situação: </th><td><input class='campoDeEntrada' readonly="true" value="<?php echo  $situacao ?>"></td></tr>
        
        <?php // TipoSubmissao: 3-Final
            if (TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getId()==3) {?>
        <tr><th class='direita'>Nota Final: </th><td><?php echo $submissao->getNota() == null ? "-" : $submissao->getNota() ?></td></tr>
        
        <?php }?>
        
        <tr><th class='direita'>Resumo: </th><td><textarea class='campoDeEntrada' rows="12" cols="80" readonly="true" style="resize: none;"><?php echo $submissao->getResumo()?></textarea></td></tr>
        <tr><th class='direita'>Autores: </th>
            <td>
        <?php
            foreach(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '') as $obj) {
                $user = Usuario::retornaDadosUsuario($obj->getIdUsuario());
                echo $user->getNome() . " " , $user->getSobrenome();
                if ($obj->getIsSubmissor()==1) echo "(Submissor)";
                echo "<br>";
            }
        ?>
                </td>
        </tr>
    </table>
        <h2 align='center'>Dados das Avaliações</h2>
        <?php 
            $avaliacoes = Avaliacao::listaAvaliacoesComFiltro('', $submissao->getId(),'');
                
            if (count($avaliacoes)==0) {
                echo "<tr><td colspan='2'><p align='center'>Nenhuma Avaliação cadastrada para a Submissão</p><td></tr>";
            } else {
                echo "ds";
            }
        ?>
    </table>

</div>