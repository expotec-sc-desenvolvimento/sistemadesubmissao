<?php

    if (isset($_GET['User']) && $_GET['User']=="NaoLogado") echo "<div style='background: red; text-align: center;'>Você precisa se logar no Sistema</div>";
    else if (isset($_GET['User']) && $_GET['User']=="loginInvalido") echo "<div style='background: red; text-align: center;'>Usuário e Senha incorretos!</div>";
    else if (isset($_GET['User']) && $_GET['User']=="dadosAtualizados") echo "<div style='background: green; text-align: center;'>Dados atualizados com sucesso!</div>";
    else if (isset($_GET['User']) && $_GET['User']=="erroAtualizacaoDados") echo "<div style='background: red; text-align: center;'>Erro na atualização de Dados. Contate um administrador!</div>";
    else if (isset($_GET['User']) && $_GET['User']=="permissaoNegada") echo "<div style='background: red; text-align: center;'>Você não possui autorização para acessar essa página!</div>";
    
    else if (isset($_GET['logOut']) && $_GET['logOut']=="Sucesso") echo "<div style='background: green; text-align: center;'>Sessão finalizada com sucesso!</div>";
        
    else if (isset($_GET['Senha']) && $_GET['Senha']=="trocaRealizada") echo "<div style='background: green; text-align: center;'>Senha atualizada com sucesso!</div>";
    else if (isset($_GET['Senha']) && $_GET['Senha']=="incorreta") echo "<div style='background: red; text-align: center;'>Senha atual incorreta. Tente novamente!</div>";
    else if (isset($_GET['Senha']) && $_GET['Senha']=="erro") echo "<div style='background: red; text-align: center;'>Erro na atualizacao de senha. Tente novamente!</div>";
    else if (isset($_GET['dados']) && $_GET['dados']=="existentes") echo "<div style='background: red; text-align: center;'>Já existe um CPF ou Email iguais ao que foi cadastrado!</div>";
    
    else if (isset($_GET['TrocarSenha']) && $_GET['TrocarSenha']=="aceito") echo "<div style='background: green; text-align: center;'>Nova senha enviada para o email solicitado!</div>";
    else if (isset($_GET['TrocarSenha']) && $_GET['TrocarSenha']=="erro") echo "<div style='background: red; text-align: center;'>CPF e/ou Email Inválidos. Tente novamente!</div>";    
    

    else if (isset($_GET['Evento']) && $_GET['Evento']=="ImagemInvalida") echo "<div style='background: red; text-align: center;'>Selecione uma imagem válida para o Evento!</div>";
    else if (isset($_GET['Download']) && $_GET['Download']=="ArquivoInvalido") echo "<div style='background: red; text-align: center;'>Selecione um arquivo para o Download!</div>";
    

    else if (isset($_GET['Item']) && $_GET['Item']=="Criado") echo "<div style='background: green; text-align: center;'>Item criado com sucesso!</div>";
    else if (isset($_GET['Item']) && $_GET['Item']=="NaoCriado") echo "<div style='background: red; text-align: center;'>Erro na inserção do Item!</div>";
    else if (isset($_GET['Item']) && $_GET['Item']=="Atualizado") echo "<div style='background: green; text-align: center;'>Item atualizado com sucesso!</div>";
    else if (isset($_GET['Item']) && $_GET['Item']=="Cancelado") echo "<div style='background: green; text-align: center;'>Item cancelado com sucesso!</div>";
    else if (isset($_GET['Item']) && $_GET['Item']=="NaoAtualizado") echo "<div style='background: red; text-align: center;'>Item não atualizado. Existem dependências no sistema!</div>";
    else if (isset($_GET['Item']) && $_GET['Item']=="Excluido") echo "<div style='background: green; text-align: center;'>Item excluido com sucesso!</div>";
    else if (isset($_GET['Item']) && $_GET['Item']=="NaoExcluido") echo "<div style='background: red; text-align: center;'>Item não excluido. Existem dependencias no sistema!</div>";
    
    else if (isset($_GET['Submissao']) && $_GET['Submissao']=="UsuarioNaoSubmissor") echo "<div style='background: red; text-align: center;'>Apenas o submissor tem acesso para alterar os dados!</div>";
    else if (isset($_GET['Submissao']) && $_GET['Submissao']=="EventosNaoDisponiveis") echo "<div style='background: red; text-align: center;'>Não há eventos com datas de Submissão disponíveis</div>";
    
    else if (isset($_GET['Solicitacao']) && $_GET['Solicitacao']=="Fora") echo "<div style='background: red; text-align: center;'>Fora do Prazo de Solicitacao!</div>";
    else if (isset($_GET['Solicitacao']) && $_GET['Solicitacao']=="Pendente") echo "<div style='background: red; text-align: center;'>Há solicitações pendentes aguardando avaliação!</div>";
    else if (isset($_GET['Solicitacao']) && $_GET['Solicitacao']=="UsuarioAvaliador") echo "<div style='background: red; text-align: center;'>O usuário já é avaliador da área!</div>";
    
?>

