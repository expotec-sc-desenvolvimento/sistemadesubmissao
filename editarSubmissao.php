<?php

    include dirname(__FILE__) . './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    $submissao = new Submissao();
    $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
    
    
    if ($submissao->getId()=="") header('Location: ./submissoes.php');
    
    
            
    if (count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), $usuario->getId(), 1))==0) { // SE ele não é o usuário submissor
        
        header('Location: ./minhasSubmissoes.php?Submissao=UsuarioNaoSubmissor');
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Editar Submissao</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>
        
        <script type="text/javascript">
            var idUsersSelected = [];
            var nomeUsersSelected = [];
            //var idUserSubmissor;
        </script>

    </head>
    
    <body>
        
        <?php include './inc/menuInicial.php';?>

        <?php 
            $evento = new Evento();
            $evento = Evento::retornaDadosEvento($submissao->getIdEvento());
            
            $area = new Area();
            $area = Area::retornaDadosArea($submissao->getIdArea());
            
            $modalidade = new Modalidade();
            $modalidade = Modalidade::retornaDadosModalidade($submissao->getIdModalidade());
        ?>
        
        <form method="post" action="<?=htmlspecialchars('submissaoForms/wsEditarSubmissao.php');?>" enctype="multipart/form-data">
            <input type="hidden" id="idSubmissao" name="idSubmissao" value="<?php echo $submissao->getId() ?>">
            <input type="hidden" id="idUsuariosAdd" name="idUsuariosAdd">
            <br>
            <strong>Usuário submissor:</strong> <?php echo $usuario->getNome() . "<img src='" . $iconOK. "' class='img-miniatura'>"?><br>
            <label for="users-selected"><strong>Outros usuários selecionados:</strong> </label><div id='users-selected'></div>
            
            <br>
            <label for="select-Eventos">Evento: </label>
            <select id="select-Eventos" name="select-Eventos">
                <option value="<?php echo $evento->getId()?>"><?php echo $evento->getNome() ?></option>
            </select>

            <br><br>
            <label for="select-Areas">Área: </label>
            <select id="select-Areas" name="select-Areas" >
                <option value="<?php echo $area->getId()?>"><?php echo $area->getDescricao() ?></option>
            </select>
            
            <br><br>
            <label for="select-Modalidades">Modalidades: </label>
            <select id="select-Modalidades" name="select-Modalidades">
                <option value="<?php echo $modalidade->getId()?>"><?php echo $modalidade->getDescricao() ?></option>
            </select>
            
            <br><br>
            <label for="resposta">Selecione os Usuários: </label>
            <input type="text" id="buscaUsers" onkeydown="usuariosSubmissao('buscaUsers','resposta','<?php echo $usuario->getId() ?>')">
                <div id="resposta" style="width: 400px; background-color: greenyellow"></div>

            <br><br>
            <label for="arquivo">Download(em PDF. Caso não seja adicionado, será considerado o arquivo anterior): </label>
                    <input type="file" id="arquivo" name="arquivo">
            
            <br><br><br>
            <label for="titulo">Titulo: </label>
            <input type="text" id="titulo" name="titulo" required="true" value="<?php echo $submissao->getTitulo() ?>">
            
            <br><br>
            <label for="resumo">Resumo: </label>
            <textarea id="resumo" name="resumo" required="true"><?php echo $submissao->getResumo() ?></textarea>
            
            <br><br>
            <label for="palavrasChave">Palavras-chave: </label>
            <input type="text" id="palavrasChave" name="palavrasChave" required="true" value="<?php echo $submissao->getPalavrasChave()?>">
            
            <br><br>
            <label for="relacaoCom">Relação com: </label>
            <input type="radio" id="relacaoCom" name="relacaoCom" value="TCC" <?php if ($submissao->getRelacaoCom()=="TCC") echo " checked" ?>>TCC
            <input type="radio" id="relacaoCom" name="relacaoCom" value="PI" <?php if ($submissao->getRelacaoCom()=="PI") echo " checked"?>>PI
            <input type="radio" id="relacaoCom" name="relacaoCom" value="-" <?php if ($submissao->getRelacaoCom()=="-") echo " checked"?>>Nenhuma das Alternativas
            
            <br><br>
            <input type='submit' value='Editar Submissao' onclick="submeterAutores('<?php echo $usuario->getId()?>')">
                
        </form>       

        
        <?php
            $usuariosDaSubmissao = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), '', '');
            
            foreach ($usuariosDaSubmissao as $usuarioSubmissao) {
                $user = Usuario::retornaDadosUsuario($usuarioSubmissao->getIdUsuario());
                if ($usuarioSubmissao->getIsSubmissor() == 1) continue;
                echo "<script>adicionarId('".$user->getId()."','".$user->getNome()."','".$iconExcluir."')</script>";
            }
        ?>
    </body>
    </html>

