<?php
    require_once dirname(__FILE__) . './includes.php';
    
?>

<!--
    Há a variável de sessão $usuario, que pertente à classe Usuario.php
-->

<script src="scripts/wz_tooltip.js"></script>
<!-- onmouseover=\"Tip('Blog do Rafael Coutossssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss')\" onmouseout=\"UnTip()\" -->

<div class="menu-container"> <!-- class="menu" -->

    
    
    <ul class="menu clearfix"> <!-- class="menu-list" -->
        <li>
            <a href="#">Início</a>
            <ul class="sub-menu clearfix"> <!-- class="sub-menu" -->
                <li><a href="paginaInicial.php">Página Inicial</a></li>
                <li><a href="atualizarDados.php">Dados Pessoais</a></li>
                <li><a href="minhasAvaliacoes.php">Minhas Avaliações</a></li>
                <li><a href="minhasSubmissoes.php">Minhas Submissoes</a></li>
                <li><a href="solicitacaoAvaliador.php">Minhas Solicitacoes de Avaliador</a></li>
                <li><a href="atualizarSenha.php">Trocar Senha</a></li>
                <li><a href="submissaoForms/wsLogOut.php">Sair</a></li>
            </ul>
        </li>
        <?php if (Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao()  == "Administrador") {   ?>
    
        <li>

            <a href="#">Cadastros</a>
            <ul class="sub-menu clearfix"> <!-- class="sub-menu" -->
                <li><a href='gerenciarAreas.php'>Areas</a></li>
                <li><a href="gerenciarAvaliacoes.php">Avaliações</a></li>
                <li><a href="gerenciarAvaliadores.php">Avaliadores</a></li>
                <li><a href="gerenciarEventos.php">Eventos</a></li>
                <li><a href='gerenciarModalidades.php'>Modalidades de Submissao</a></li>
                <li><a href="gerenciarSolicitacoesAvaliadores.php">Solicitacoes de Avaliadores</a></li>
                <li><a href='gerenciarSubmissoes.php'>Submissoes</a></li>
                <li><a href='gerenciarUsuarios.php'>Usuarios</a></li>
                
                
                
                
            </ul>
        </li>
    
    <?php } ?>
    </ul>
</div>

<?php
    include dirname(__FILE__) . './mensagensGET.php';
?>
<!--
<fieldset id="principal">
    <br>

    <h2 align='center'>Informações Pessoais</h2>

    <table>
        <tr>
            <td width="220px"><img id ='fotoPerfil' src="<?php echo $pastaFotosPerfil . $usuario->getImagem() ?>" width='70px'></img> <br>
                <p align="center">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href="atualizarFoto.php">Editar Foto</a><p></td>
            <td> <strong>Nome:</strong> <?php echo $usuario->getNome() . " " . $usuario->getSobrenome() ?> <br>
                <strong>CPF: </strong><?php echo $usuario->getCpf() ?> <br>
                <strong>Email: </strong><?php echo $usuario->getEmail() ?> <br>
                <strong>Perfil: </strong> <?php echo Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao() ?> <br>
            </td>
        </tr>

    </table>

</fieldset>
-->