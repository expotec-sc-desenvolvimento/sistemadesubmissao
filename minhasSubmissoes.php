<?php

    include dirname(__FILE__) . './inc/includes.php';
    
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
            <title>SS - Minhas Submissões</title>
            <?php
                include './inc/css.php';
                include './inc/javascript.php';
            ?>
            
        </head>

        <body>

            <?php 
                require_once './inc/menuInicial.php';
                require_once './inc/modal.php';
            ?>

            
            <?php
                $submissoes = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro('', $usuario->getId(), '');
                
            ?>
            
            <fieldset class='inicio'>
                <p align='center'><input class="addObjeto btn-verde" name='Submissao' type="button" value="Adicionar Submissao"></p>
            
                <h2 align="center">Submissões do Usuário</h2>
                <table border="1" class='table_list' align="center">
                <thead>
                <?php if (count($submissoes)==0) echo "<tr><td>Nenhum trabalho submetido</td></tr>";
                      else {
                          echo "<tr>"
                                . "<th><strong>*</th>"
                                . "<th><strong>Evento</th>"
                                . "<th><strong>Area</th>"
                                . "<th><strong>Modalidade</th>"
                                . "<th><strong>Tipo</th>"
                                . "<th><strong>Titulo</th>"
                                . "<th><strong>Arquivo</th>"
                                . "<th><strong>Situação</th>"
                                . "<th><strong>Autores</th>"
                                . "<th><strong>Versão Final</strong></td></tr></thead><tbody>";
                                
                                
                          foreach ($submissoes as $obj) {
                              $submissao = Submissao::retornaDadosSubmissao($obj->getIdSubmissao());
                              
                              $usuariosSubmissao = array (new UsuariosDaSubmissao());
                              $usuariosSubmissao = UsuariosDaSubmissao::listaUsuariosDaSubmissaoComFiltro($obj->getIdSubmissao(), '', '');
                              
                              
                              $usuarioSubmissao = "";
                              
                              foreach ($usuariosSubmissao as $user) {
                                  $usuarioSubmissao = $usuarioSubmissao . Usuario::retornaDadosUsuario($user->getIdUsuario())->getNome();
                                  if ($user->getIsSubmissor() == 1) $usuarioSubmissao = $usuarioSubmissao . " (Submissor)";
                                  $usuarioSubmissao = $usuarioSubmissao . "<br>";
                              }
                              
                              
                              
                              $id = $submissao->getId();
                              $evento = Evento::retornaDadosEvento($submissao->getIdEvento());
                              $area = Area::retornaDadosArea($submissao->getIdArea());
                              $modalidade = Modalidade::retornaDadosModalidade($submissao->getIdModalidade());
                              $tipo = TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao());
                              $situacao = SituacaoSubmissao::retornaDadosSituacaoSubmissao($submissao->getIdSituacaoSubmissao());
                              $arquivo = $submissao->getArquivo();
                              $titulo = $submissao->getTitulo();
                              $nota = $submissao->getNota();
                              
                              
                              $visualizar = "<a class='visualizarObjeto' id='".$id."' name='Submissao'><img class='img-miniatura' src='".$iconVisualizar."' width='20px'></a>";
                              $editar="";
                              $excluir="";
                              if ($obj->getIsSubmissor() && $situacao->getDescricao()=="Submetida" && $submissao->getIdTipoSubmissao()==1) {
                                  //$editar = "<a href='editarSubmissao.php?id=" . $id . "'><img src='".$iconEditar."' width='20px'></a>";
                                  $editar = "<a class='editarObjeto' id='".$id."' name='Submissao'><img class='img-miniatura' src='".$iconEditar."' ></a>";
                                  
                                  if (TipoSubmissao::retornaDadosTipoSubmissao($submissao->getIdTipoSubmissao())->getDescricao() == "Parcial") {
                                    $excluir = "<a href='submissaoForms/wsCancelarSubmissao.php?id=" . $id . "' "
                                              . "onclick=\"return confirm('Tem certeza que deseja excluir esta Submissao?')\">"
                                              . "<img src='".$iconExcluir."' width='20px'></a>";
                                  }
                              }
                              
                              $versaoFinal = "-";
                              
                                // Tipos de Submissoes: 1-Parcial, 2-Corrigida, 3-Final
                                // Tipos de Situacao de Submissao: 4-Aprovado(a), 5-Aprovado(a), 6-Reprovado(a)
                                if ($submissao->getIdTipoSubmissao()==1 && $submissao->getIdSituacaoSubmissao()==5 && !Submissao::existeSubmissaoCorrigida($submissao->getId())) {  
                                      $versaoFinal = "<input type='button' class='addObjeto btn-verde' name='VersaoCorrigida' id='".$submissao->getId()."' value='Enviar Versão Corrigida'>";
                                }
                                else if ($submissao->getIdTipoSubmissao()==1 && $submissao->getIdSituacaoSubmissao()==5 && Submissao::existeSubmissaoCorrigida($submissao->getId())) {
                                    $versaoFinal = "Enviada";
                                }
                              
                              
                              echo "<tr>"
                                . "<td align='center'>". $visualizar.$editar.$excluir."</td>"
                                . "<td>". $evento->getNome()."</td>"
                                . "<td>".$area->getDescricao()."</td>"
                                . "<td>".$modalidade->getDescricao()."</td>"
                                . "<td>".$tipo->getDescricao()."</td>"
                                . "<td>".$titulo."</td>"
                                . "<td><a href='".$pastaSubmissoes . $arquivo ."'>Visualizar</a></td>"
                                . "<td>".$situacao->getDescricao()."</td>"
                                . "<td>".$usuarioSubmissao."</td>"
                                . "<td>".$versaoFinal. "</td></tr>";
                                
                              
                          }
                          
                          
                      }
                ?>
                    </tbody>
                </table>
            </fieldset>
        </body>
    </html>

<!--    
    .fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}

<div class='fileUpload btn btn-primar'>
                                                    <span>Upload</span>
                                                    <input type='file' class='upload' /></div>
-->