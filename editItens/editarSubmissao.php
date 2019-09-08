<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
    
    if ($submissao->getId()=="") header('Location: ./minhasSubmissoes.php');
    
    
            
    if (count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), $usuario->getId(), 1))==0) { // Se ele não é o usuário submissor    
        header('Location: ./minhasSubmissoes.php?Submissao=UsuarioNaoSubmissor');
    }
    
    $evento = Evento::retornaDadosEvento($submissao->getIdEvento());
    $area = Area::retornaDadosArea($submissao->getIdArea());
    $modalidade = Modalidade::retornaDadosModalidade($submissao->getIdModalidade());
?>

<script type="text/javascript">
    var idUsersSelected = [];
    var nomeUsersSelected = [];
    //var idUserSubmissor;
</script>

<div class="titulo-modal">Editar Submissão</div>

<div class="itens-modal">

<form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarSubmissao.php');?>" enctype="multipart/form-data">
    <input type="hidden" id="idSubmissao" name="idSubmissao" value="<?php echo $submissao->getId() ?>">
    <input type="hidden" id="idUsuariosAdd" name="idUsuariosAdd">
        
        <table class="cadastroItens-2">
            <tr><th></th><td><h2 align="center">Dados do Evento</h2></td></tr>
            <tr>
                <th class="direita">Evento: </th>
                <td>
                    <input type='hidden' id="select-Eventos" name="select-Eventos" value="<?php echo $evento->getId()?>">
                    <input class='campoDeEntrada' readonly="readonly" value="<?php echo $evento->getNome() ?>">
                </td>
            </tr>
            <tr>
                <th class="direita">Área: </th>
                <td>
                    <input type='hidden' id="select-Areas" name="select-Areas" value="<?php echo $area->getId()?>">
                    <input class='campoDeEntrada' readonly="readonly" value="<?php echo $area->getDescricao() ?>">
                </td>
            </tr>
            <tr>
                <th class="direita">Modalidade: </th>
                <td>
                    <input type='hidden' id="select-Modalidades" name="select-Modalidades" value="<?php echo $modalidade->getId()?>">
                    <input class='campoDeEntrada' readonly="readonly" value="<?php echo $modalidade->getDescricao() ?>">
                </td>
            </tr>
            <tr><th></th><td><h2 align="center">Dados do Trabalho</h2></td></tr>
            <tr>
                <th class='direita'>Título: </th>
                <td><input class="campoDeEntrada" id="titulo" name="titulo" required="true" value="<?php echo $submissao->getTitulo() ?>"></td>
            </tr>
            <tr>
                <th class='direita'>Resumo: </th>
                <td><textarea class="campoDeEntrada" id="resumo" name="resumo" rows="10" required="true"><?php echo $submissao->getResumo() ?></textarea></td>
            </tr>
            <tr>
                <th class='direita'>Palavras-chave: </th>
                <td><input class="campoDeEntrada" id="palavrasChave" name="palavrasChave" required="true" value="<?php echo $submissao->getPalavrasChave()?>"></td>
            </tr>
            <tr>
                <th class='direita'>Relação com: </th>
                <td>
                    <input type="radio" id="relacaoCom" name="relacaoCom" value="TCC" <?php if ($submissao->getRelacaoCom()=="TCC") echo " checked" ?>>TCC
                    <input type="radio" id="relacaoCom" name="relacaoCom" value="PI" <?php if ($submissao->getRelacaoCom()=="PI") echo " checked"?>>PI
                    <input type="radio" id="relacaoCom" name="relacaoCom" value="-" <?php if ($submissao->getRelacaoCom()=="-") echo " checked"?>>Nenhuma das Alternativas
                </td>
            </tr>
            <tr>
                <th class='direita'>Download: </th>
                <td><input class="campoDeEntrada" type="file" id="arquivo" name="arquivo"></td>
            </tr>
            <tr>
                <th></th><td><span style="color: #FF0000; font-size: 10px;">O arquivo já existe. Caso não seja adicionado nenhum arquivo, o atual será considerado!</span></td>
            </tr>
            <tr>
                <th class='direita'>Autores: </th>
                <td>
                    <div style="float: left"><?php echo $usuario->getNome() . "<img src='" . $iconOK. "' class='img-miniatura'>"?></div>
                    <div id='users-selected'></div>
                </td>
            </tr>
            <tr>
                <th class='direita'>Usuários: </th>
                <td>
                    <input class="campoDeEntrada" id="buscaUsers" onkeydown="usuariosSubmissao('buscaUsers','resposta','<?php echo $usuario->getId() ?>')" placeholder="Digite parte do nome do Usuário..." autocomplete="off">
                    <div id="resposta" class="campoDeEntrada" style="display: none;"></div>
                </td>
            </tr>
            
        </table>
        <div class="div-btn"><input type='submit' class='btn-verde' value='Editar Submissao' onclick="submeterAutores('<?php echo $usuario->getId()?>')"></div>
    </form>       
   
        <?php
            $usuariosDaSubmissao = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '');
            
            foreach ($usuariosDaSubmissao as $usuarioSubmissao) {
                $user = Usuario::retornaDadosUsuario($usuarioSubmissao->getIdUsuario());
                if ($usuarioSubmissao->getIsSubmissor() == 1) continue;
                echo "<script>adicionarId('".$user->getId()."','".$user->getNome()."','".$iconExcluir."')</script>";
            }
        ?>

</div>