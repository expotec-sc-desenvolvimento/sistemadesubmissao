<?php

    include 'inc/includes.php';
    
    session_start();
    
    loginObrigatorio();

    $usuario = new Usuario();
    $usuario = $_SESSION['usuario'];
    
        
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
            include 'inc/css.php';
            include 'inc/javascript.php';
        ?>
        <script>
            $(document).on('click', '.img-perfil', function(){
                $('#inpImagem').click();
            });
            $(document).on('change', '#inpImagem', function(){
                $('#botaoConfirmar').click();
            });
        </script>
    </head>
    
    <body>
        
        <?php include 'inc/menuInicial.php';?>
        
        <div class='painelControle'>
            <div class='img-usuario'><img class='img-perfil' src='<?php echo $pastaFotosPerfil . $usuario->getImagem() ?>'></div>
            <form  action="<?=htmlspecialchars('submissaoForms/wsValidarFoto.php');?>"
                  method="post" enctype="multipart/form-data">
                <p align="center"><input type="file" class='inpImagem' id="inpImagem" name="pImagem" style="display: none;"><input id="botaoConfirmar" type="submit" value="Enviar Imagem" style="display: none"></p>
            </form>
            <h2 align='center'>Você está logado como: <?php echo $usuario->getNome() . " " . $usuario->getSobrenome() ?></h2>
            <table style="margin-left: 45%">
                <tr>
                    <th class="direita">CPF: </th><td><?php echo $usuario->getCpf() ?></td>
                </tr>
                <tr>
                    <th class="direita">Perfil: </th><td><?php echo Perfil::retornaDadosPerfil($usuario->getIdPerfil())->getDescricao() ?></td>
                </tr>
                    
            </table>
        </div>
        <br>
        <div class='painelControle' style="background-color: #FFFFF; height: 150px">
            <div class='acoes-user'>                
                <span align='center' style="font-size: 40px"><a href="minhasSubmissoes.php"><?php echo count(UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro('', $usuario->getId(), ''))?></a><br>
                    <span align='center' style="font-size: 20px;">Submissão Vinculada(s)</span></span>
            </div>
            <div class='acoes-user'>                
                <span align='center' style="font-size: 40px"><a href="solicitacaoAvaliador.php"><?php echo count(SolicitacaoAvaliador::listaSolicitacaoAvaliadorComFiltro($usuario->getId(),'','',''))?></a><br>
                    <span align='center' style="font-size: 20px;">Solicitação para Avaliador </span></span>
            </div>
            <div class='acoes-user'>                
                <span align='center' style="font-size: 40px"><a href="minhasAvaliacoes.php">
                    <?php 
                        //echo count(Avaliacao::listaAvaliacoesComFiltro($usuario->getId(),'',''))
                        $cont=0;
                        $a=1;
                        foreach (Avaliacao::listaAvaliacoesComFiltro($usuario->getId(),'','') as $avaliacao) {
                            // Tipos de Submissao: 1-Parcial, 2-Corrigida, 3-Final
                            //echo "<script>alert(".$avaliacao->getIdSubmissao().")</script>";
                            $submissao = Submissao::retornaDadosSubmissao($avaliacao->getIdSubmissao());
                            
                            if ($submissao->getIdTipoSubmissao()==2) {
                                $subParcial = Submissao::retornaDadosSubmissao($submissao->getIdRelacaoComSubmissao());
                                if (count(Avaliacao::listaAvaliacoesComFiltro($usuario->getId(), $subParcial->getId(), 5))==1) $cont++;
                            }
                            else $cont++;
                        }
                        echo $cont;
                    ?></a><br>
                    <span align='center' style="font-size: 20px;">Avaliação de Trabalho</span></span>
            </div>
        </div>
        <div class='fileUpload'><input type='file' class='upload'></div>
    </body>
</html>

