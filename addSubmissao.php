<?php

    include dirname(__FILE__) . './inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];

    date_default_timezone_set('America/Sao_Paulo');    
    //verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página    
    
        
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="José Sueney de Lima">
        <meta name="keywords" content="Evento, IFRN-SC, IFRN, Santa Cruz, sistema">
        <meta name="description" content="Página inicial do sistema de submissão de trabalhos do IFRN campus Santa Cruz">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SS - Página Inicial</title>
        <?php
            include './inc/css.php';
            include './inc/javascript.php';
        ?>
        
        <script type="text/javascript">
            var idUsersSelected = [];
            var nomeUsersSelected = [];
//            var idUserSubmissor; (VERIFICAR SE ESSA VARIAVEL É NECESSARIO
        </script>

    </head>
    
    <body>
        
        <?php include './inc/menuInicial.php';?>

        <?php 
            $eventos = array (new Evento());
            $eventos = Evento::listaEventos();
            
            $dataAtual = date('d-m-Y');
                    
            $eventosComSubmissoesDisponiveis = false;
            foreach ($eventos as $evento) {
                $dataInicioSubmissao = date('d-m-Y', strtotime($evento->getInicioSubmissao()));
                $dataFimSubmissao = date('d-m-Y', strtotime($evento->getFimSubmissao()));                
                if (strtotime($dataInicioSubmissao) <= strtotime($dataAtual) && strtotime($dataAtual) <= strtotime($dataFimSubmissao)) {
                    $eventosComSubmissoesDisponiveis = true;
                    break;
                }
            }
            if (!$eventosComSubmissoesDisponiveis) echo "<script>location.href = 'minhasSubmissoes.php?Submissao=EventosNaoDisponiveis'</script>";
        ?>
        
        <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddSubmissao.php');?>" enctype="multipart/form-data">
            <input type="hidden" id="idUsuariosAdd" name="idUsuariosAdd">
            <br>
            <strong>Usuário submissor:</strong> <?php echo $usuario->getNome() . "<img src='" . $iconOK. "' class='img-miniatura'>"?><br>
            <label for="users-selected"><strong>Outros usuários selecionados:</strong> </label><div id='users-selected'></div>
            <br>
            
            <label for="evento">Selecione o Evento: </label>
                <div id="eventos">
                    <select id="select-Eventos" name="select-Eventos" onchange="loadAreas();loadModalidades()" required="true">
                        <option value="">Selecione um evento</option>
                        <?php
                            foreach ($eventos as $evento) {
                                
                                $dataInicioSubmissao = date('d-m-Y', strtotime($evento->getInicioSubmissao()));
                                $dataFimSubmissao = date('d-m-Y', strtotime($evento->getFimSubmissao()));
                                
                                if (strtotime($dataInicioSubmissao) <= strtotime($dataAtual) && strtotime($dataAtual) <= strtotime($dataFimSubmissao)) {
                                    echo "<option value='".$evento->getId()."'>".$evento->getNome()."</option>";
                                }
                                
                            }
                        ?>
                    </select>
                </div>
            <br>
            <label for="areas">Selecione a Área: </label><div id="areas"><select id="select-Areas" name="select-Areas" required="true"></select></div>
            <br>
            <br>
            <label for="areas">Selecione a Modalidade: </label><div id="modalidade"><select id="select-Modalidades" name="select-Modalidades" required="true"></select></div>
            <br>
            <label for="resposta">Selecione os Usuários: </label>

            <input type="text" id="buscaUsers" onkeydown="usuariosSubmissao('buscaUsers','resposta','<?php echo $usuario->getId() ?>')">
                <div id="resposta" style="width: 400px; background-color: greenyellow"></div>

                <br><br>
                <label for="arquivo">Download(em PDF): </label>
                        <input type="file" id="arquivo" name="arquivo" required="true">
                <br><br><br>
                <label for="titulo">Titulo: </label>
                    <input type="text" id="titulo" name="titulo" required="true">
                <br><br>
                <label for="resumo">Resumo: </label>
                <textarea id="resumo" name="resumo" required="true"></textarea>
                <br><br>
                <label for="palavrasChave">Palavras-chave: </label>
                <input type="text" id="palavrasChave" name="palavrasChave" required="true">
                <br><br>
                <label for="relacaoCom">Relação com: </label>
                <input type="radio" id="relacaoCom" name="relacaoCom" value="TCC">TCC
                <input type="radio" id="relacaoCom" name="relacaoCom" value="PI">PI
                <input type="radio" id="relacaoCom" name="relacaoCom" value="-" checked="">Nenhuma das Alternativas
                <br><br>
                <input type='submit' value='Adicionar Submissao' onclick="submeterAutores('<?php echo $usuario->getId()?>')">
                
        </form>       
    </body>
    </html>

