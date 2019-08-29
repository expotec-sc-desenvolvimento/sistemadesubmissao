<?php

    include dirname(__DIR__) . '/inc/includes.php';
    
    session_start();
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
    verificarPermissaoAcesso(Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao(),['Administrador'],"../paginaInicial.php"); //Apenas os perfis ao lado podem acessar a página
    
    $submissao = new Submissao();
    $submissao = Submissao::retornaDadosSubmissao($_GET['id']);
    
    
?>

<div class="titulo-modal">Adicionar Avaliação</div>

<div class="itens-modal">
    <h3 align="center">Você deve adicionar 3 Avaliadores</h3>
    <form method="post" action="<?=htmlspecialchars('submissaoForms/wsAddAvaliacao.php');?>">
        <input type="hidden" id="idSubmissao" name="idSubmissao" value="<?php echo $submissao->getId() ?>">
        
        <table class="cadastroItens-2">
            <tr><th>Trabalho: </th><td colspan="2"><?php echo $submissao->getTitulo() ?></td></tr>
            <tr><th>Área: </th><td colspan="2"><?php echo Area::retornaDadosArea($submissao->getIdArea())->getDescricao() ?></td></tr>
            <tr>
                <th>Avaliador 1:</th>
                <td>
                    <select class=campoDeEntrada id="avaliador1" name="avaliador1" required="true">
                        <option value="1">Selecione um Avaliador</option>
                        <?php 
                            foreach (Avaliador::listaAvaliadoresComFiltro($submissao->getIdEvento(), $submissao->getIdArea(), '', "area") as $avaliador) {
                                $user = Usuario::retornaDadosUsuario($avaliador->getIdUsuario());
                                if (count(Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), $submissao->getId(), ''))>0 || 
                                        count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), $user->getId(), ''))>0) continue;
                                echo "<option value='". $user->getId()."'>".$user->getNome()." ".$user->getSobrenome()."</option>";
                        }?>
                    </select>
                </td>
                <td><input type="checkbox" checked onchange="var x = this.checked ? 'area' : 'outra-area'; loadAvaliadores('',<?php echo $submissao->getId() ?>,
                                                                                                                            <?php echo $submissao->getIdEvento() ?>,
                                                                                                                            <?php echo $submissao->getIdArea() ?>,
                                                                                                                            x,
                                                                                                                            'avaliador1')">Avaliador da Área</td>
            </tr>
            <tr>
                <th>Avaliador 2:</th>
                <td>
                    <select class=campoDeEntrada id="avaliador2" name="avaliador2" required="true">
                        <option value="1">Selecione um Avaliador</option>
                        <?php 
                            foreach (Avaliador::listaAvaliadoresComFiltro($submissao->getIdEvento(), $submissao->getIdArea(), '', "area") as $avaliador) {
                                $user = Usuario::retornaDadosUsuario($avaliador->getIdUsuario());
                                if (count(Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), $submissao->getId(), ''))>0 || 
                                        count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), $user->getId(), ''))>0) continue;
                                echo "<option value='". $user->getId()."'>".$user->getNome()." ".$user->getSobrenome()."</option>";
                        }?>
                    </select>
                </td>
                <td><input type="checkbox" checked onchange="var x = this.checked ? 'area' : 'outra-area'; loadAvaliadores('',<?php echo $submissao->getId() ?>,
                                                                                                                            <?php echo $submissao->getIdEvento() ?>,
                                                                                                                            <?php echo $submissao->getIdArea() ?>,
                                                                                                                             x,
                                                                                                                            'avaliador2')">Avaliador da Área</td>
            </tr>
            <tr>
                <th>Avaliador 3:</th>
                <td>
                    <select class=campoDeEntrada id="avaliador3" name="avaliador3" required="true">
                        <option value="1">Selecione um Avaliador</option>
                        <?php 
                            foreach (Avaliador::listaAvaliadoresComFiltro($submissao->getIdEvento(), $submissao->getIdArea(), '', "outra-area") as $avaliador) {
                                $user = Usuario::retornaDadosUsuario($avaliador->getIdUsuario());
                                if (count(Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), $submissao->getId(), ''))>0 || 
                                        count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($submissao->getId(), $user->getId(), ''))>0) continue;
                                echo "<option value='". $user->getId()."'>".$user->getNome()." ".$user->getSobrenome()."</option>";
                        }?>
                    </select>
                </td>
                <td><input type="checkbox" onchange="var x = this.checked ? 'area' : 'outra-area'; loadAvaliadores('',<?php echo $submissao->getId() ?>,
                                                                                                                    <?php echo $submissao->getIdEvento() ?>,
                                                                                                                    <?php echo $submissao->getIdArea() ?>,
                                                                                                                    x,
                                                                                                                    'avaliador3')">Avaliador da Área</td>
            </tr>
        </table>
        <div class="div-btn"><input type="submit" class='btn-verde' value="Adicionar Avaliadores" onclick="return validacao();"></div>
    </form>
    
    <script type='text/javascript'>
        function validacao () {
            var av1 = document.getElementById('avaliador1').value;
            var av2 = document.getElementById('avaliador2').value;
            var av3 = document.getElementById('avaliador3').value;
            
            if (av1 == av2 || av2 == av3) { alert('Há avaliadores iguais!'); return false;}
            else return true;
        }
    </script>
</div>